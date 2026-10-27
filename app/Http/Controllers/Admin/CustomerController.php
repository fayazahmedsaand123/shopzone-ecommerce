<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller {

    public function index(Request $request) {
        $query = User::where('role', 'customer');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $customers = $query->withCount('orders')->latest()->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function toggleStatus(User $user) {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Customer ' . $newStatus . ' successfully.',
            'status'  => $newStatus,
        ]);
    }
}