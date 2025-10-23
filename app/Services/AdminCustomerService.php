<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminCustomerService
{
    public function getAllCustomers(int $perPage = 10, array $filters = []): LengthAwarePaginator
    {
        $query = User::query();

        // Filter by role (only customers)
        $query->where('role', 'user');

        // Search by name or email
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by registration date
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Order by latest first
        $query->latest();

        return $query->paginate($perPage);
    }

    public function getCustomerById(int $id): ?User
    {
        return User::where('id', $id)
                   ->where('role', 'user')
                   ->first();
    }

    public function getCustomerStats(): array
    {
        $totalCustomers = User::where('role', 'user')->count();
        $newCustomersThisMonth = User::where('role', 'user')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $activeCustomers = User::where('role', 'user')
            ->whereHas('orders')
            ->count();

        return [
            'total' => $totalCustomers,
            'new_this_month' => $newCustomersThisMonth,
            'active' => $activeCustomers,
        ];
    }

    public function getCustomerOrders(User $customer, int $perPage = 5): LengthAwarePaginator
    {
        return $customer->orders()
            ->with(['orderDetails.product'])
            ->latest()
            ->paginate($perPage);
    }

    public function updateCustomer(User $customer, array $data): bool
    {
        $allowedFields = ['full_name', 'phone', 'address'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        if (empty($updateData)) {
            return false;
        }

        return $customer->update($updateData);
    }

    public function deleteCustomer(User $customer): bool
    {
        // Check if customer has orders
        if ($customer->orders()->exists()) {
            return false; // Cannot delete customer with orders
        }

        return $customer->delete();
    }

    public function getValidationRules(bool $isUpdate = false): array
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ];

        if (!$isUpdate) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    public function getValidationMessages(): array
    {
        return [
            'full_name.required' => 'Họ tên là bắt buộc.',
            'full_name.string' => 'Họ tên phải là chuỗi ký tự.',
            'full_name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ];
    }
}

