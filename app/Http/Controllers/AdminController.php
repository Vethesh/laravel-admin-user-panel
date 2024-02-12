<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    public function dashboard()
    {
        $details = User::all();
        return view('admin.dashboard', ['details' => $details]);
    }
    public function edit(User $detail)
    {
        return view('admin.edit', ['detail' => $detail]);
    }

    public function update(User $detail, Request $request)
    {

        $data = $request->validate([
            "name" => "required",
            "email" => "required"

        ]);


        $detail->update($data);
        // dd($detail);

        return redirect(route('dashboard'))->with('success', "User updated succesfully");
    }

    public function destroy(User $detail)
    {
        $detail->delete();
        return redirect(route('dashboard'))->with('success', "User deleted succesfully");
    }

    public function activate(User $detail )
    {

        $detail->update(['status' => 'active']);

        // dd($detail);
        return redirect(route("dashboard"))->with('success', 'User activated successfully');
    }

    public function deactivate(User $detail)
    {
        // echo "hello";
        $detail->update(['status' => 'inactive']);

        // dd($detail);
        return redirect(route("dashboard"))->with('success', 'User deactivated successfully');
    }


    public function showChangePasswordForm(User $user)
    {
        return view('admin.change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard')->with('success', 'Password updated successfully.');
    }
}
