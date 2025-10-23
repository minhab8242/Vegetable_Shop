<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem thông tin cá nhân');
        }

        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Chưa đăng nhập'], 401);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.max' => 'Họ và tên không được vượt quá :max ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá :max ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $user->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Cập nhật thông tin thành công!']);
        }

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePassword(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Chưa đăng nhập'], 401);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.min' => 'Mật khẩu hiện tại phải có ít nhất :min ký tự.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
            'new_password_confirmation.required' => 'Vui lòng nhập lại mật khẩu mới.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Mật khẩu hiện tại không đúng.'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Đổi mật khẩu thành công']);
    }
}


