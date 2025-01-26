<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function listCustomers (Request $request)
    {
        $search = $request->query('search');

        $customers = User::where('role', 'customer')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10);

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
