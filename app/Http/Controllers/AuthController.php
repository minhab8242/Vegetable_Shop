<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\EmailVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$this->emailVerificationService->isEmailVerified($user)) {
                session(['unverified_email' => $user->email]);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('verification.notice')
                    ->with('error', 'Vui lòng xác thực email trước khi đăng nhập. Chúng tôi đã gửi email xác thực đến địa chỉ email của bạn.');
            }

            $request->session()->regenerate();

            $pendingCartItem = session('pending_cart_item');
            if ($pendingCartItem) {
                session()->forget('pending_cart_item');

                $cartService = app(\App\Services\CartService::class);
                $success = $cartService->addToCart($user, $pendingCartItem['product_id'], $pendingCartItem['quantity']);

                if ($success) {
                    $redirectUrl = $pendingCartItem['redirect_url'] ?? route('home');
                    return redirect($redirectUrl)
                        ->with('success', 'Đăng nhập thành công! Sản phẩm đã được thêm vào giỏ hàng.');
                }
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Đăng nhập thành công!');
        }

        \Log::info('Failed login attempt', [
            'email' => $credentials['email'],
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        throw ValidationException::withMessages([
            'email' => 'Thông tin đăng nhập không chính xác. Vui lòng kiểm tra lại email và mật khẩu.',
        ]);
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(RegisterRequest $request)
    {
        $userData = $request->validated();
        $userData['password'] = Hash::make($userData['password']);

        $user = User::create($userData);

        session(['unverified_email' => $user->email]);

        $emailSent = $this->emailVerificationService->sendVerificationEmail($user);

        if ($emailSent) {
            return redirect()->route('verification.notice')
                ->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
        } else {
            return redirect()->route('verification.notice')
                ->with('error', 'Đăng ký thành công nhưng không thể gửi email xác thực. Vui lòng thử lại sau.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Đăng xuất thành công!');
    }


    public function showVerificationNotice()
    {
        return view('auth.verify-email');
    }


    public function verifyEmail(Request $request, $id, $token)
    {
        $verified = $this->emailVerificationService->verifyEmail($id, $token);

        if ($verified) {
            return redirect()->route('login')
                ->with('success', 'Email đã được xác thực thành công! Bạn có thể đăng nhập ngay bây giờ.');
        } else {
            return redirect()->route('verification.notice')
                ->with('error', 'Link xác thực không hợp lệ hoặc đã hết hạn. Vui lòng đăng ký lại.');
        }
    }


    public function resendVerificationEmail(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            $email = $request->input('email') ?? session('unverified_email');

            if (!$email) {
                return redirect()->route('login')
                    ->with('error', 'Vui lòng đăng nhập để gửi lại email xác thực.');
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->route('login')
                    ->with('error', 'Không tìm thấy tài khoản với email này.');
            }
        }

        if ($this->emailVerificationService->isEmailVerified($user)) {
            return redirect()->route('home')
                ->with('info', 'Email của bạn đã được xác thực.');
        }

        $emailSent = $this->emailVerificationService->resendVerificationEmail($user);

        if ($emailSent) {
            return back()->with('success', 'Email xác thực đã được gửi lại. Vui lòng kiểm tra hộp thư.');
        } else {
            return back()->with('error', 'Không thể gửi email xác thực. Vui lòng thử lại sau.');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email']
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.exists' => 'Không tìm thấy tài khoản với email này.',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Password::getRepository()->create($user);

        Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email));

        $status = Password::RESET_LINK_SENT;

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Chúng tôi đã gửi link đặt lại mật khẩu đến email của bạn.');
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'email' => $request->email,
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Mật khẩu đã được đặt lại thành công. Bạn có thể đăng nhập với mật khẩu mới.');
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
