<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AdminCustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminCustomerController extends Controller
{
    public function __construct(
        private AdminCustomerService $customerService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'date_from', 'date_to']);
        $customers = $this->customerService->getAllCustomers(10, $filters);
        $stats = $this->customerService->getCustomerStats();

        return view('admin.customers.index', compact('customers', 'stats', 'filters'));
    }

    public function show(int $id): View
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            abort(404, 'Khách hàng không tồn tại.');
        }

        $orders = $this->customerService->getCustomerOrders($customer, 5);

        return view('admin.customers.show', compact('customer', 'orders'));
    }

    public function edit(int $id): View
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            abort(404, 'Khách hàng không tồn tại.');
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            abort(404, 'Khách hàng không tồn tại.');
        }

        $rules = $this->customerService->getValidationRules(true);
        $messages = $this->customerService->getValidationMessages();

        $validated = $request->validate($rules, $messages);

        $updated = $this->customerService->updateCustomer($customer, $validated);

        if ($updated) {
            return redirect()
                ->route('admin.customers.show', $customer)
                ->with('success', 'Cập nhật thông tin khách hàng thành công.');
        }

        return back()
            ->withInput()
            ->with('error', 'Không có thay đổi nào được thực hiện.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $customer = $this->customerService->getCustomerById($id);

        if (!$customer) {
            abort(404, 'Khách hàng không tồn tại.');
        }

        $deleted = $this->customerService->deleteCustomer($customer);

        if ($deleted) {
            return redirect()
                ->route('admin.customers.index')
                ->with('success', 'Xóa khách hàng thành công.');
        }

        return back()
            ->with('error', 'Không thể xóa khách hàng vì khách hàng này có đơn hàng.');
    }
}

