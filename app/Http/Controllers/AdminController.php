<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function listCustomers(Request $request)
    {
        $search = $request->query('search');

        $customers = User::where('role', 'customer')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function editCustomer($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
    }

    public function deactivateCustomer($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'inactive']);
        return redirect()->route('admin.customers.index')->with('success', 'Customer deactivated successfully');
    }

    public function reactivateCustomer($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return redirect()->route('admin.customers.index')->with('success', 'Customer reactivated successfully');
    }

    public function deleteCustomer($id)
    {
        User::destroy($id);
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully');
    }
}
