<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function listCustomers (Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $customers = $query->get();
        return response()->json($customers);
    }

    public function updateCustomer (Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function deactivateCustomer ($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'inactive']);
        return response()->json(['message' => 'User deactivated']);
    }

    public function reactivateCustomer ($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return response()->json(['message' => 'User reactivated']);
    }

    public function deleteCustomer ($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted']);
    }
}
