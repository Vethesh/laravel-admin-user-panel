<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    //
    public function login()
    {
        if (Auth::check()) {
            return redirect(route("home"));
        }
        return view("login");
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect(route("home"));
        }
        return view("register");
    }

    // public function loginpost(Request $request)
    // {

    //     $request->validate([
    //         "email" => "required",
    //         "password" => "required"


    //     ]);

    //     $credentials = $request->only("email", "password");
    //     if (Auth::attempt($credentials)) {

    //         return redirect()->intended(route("home"))->with("success", "login is successfull....");
    //     }
    //     return redirect(route("login"))->with("error", "login details are not valid!.");
    // }

    public function registerpost(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:8",


        ]);

        $usertype = $request->has('is_admin') ? 'admin' : 'user';
        // $status = $request->has('status') ? 'active':'inactive';

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['user-type'] = $usertype;
        // $data['status'] = $status;

        $user = User::create($data);

        // dd($user);
        if (!$user) {
            return redirect(route("register"))->with("error", "Registration is failed try again!.");
        }
        return redirect(route("login"));
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route("login"));
    }


    //     public function loginpost(Request $request)
//     {

    //         $request->validate([
//             "email" => "required",
//             "password" => "required"


    //         ]);

    //         $credentials = $request->only("email", "password");
//         if (Auth::attempt($credentials)) {
//             $user = Auth::user();
//             $userType = User::where('email', $user->email)->value('user-type');
//             $userstatus = User::where('email', $user->email)->value('status');

    //             // dd($userType);
//             if ($userType == 'user') {

    //                 if($userstatus=="")

    //                 return redirect()->intended(route("home"))->with("success", "login is successfull....");
//             } elseif ($userType == 'admin') {
//                 return redirect()->intended(route("dashboard"))->with("success", "Login is successful.");
//             }
//         }
//         return redirect(route("login"))->with("error", "login details are not valid!.");
//     }
// }



    public function loginpost(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userType = User::where('email', $user->email)->value('user-type');
            $userStatus = User::where('email', $user->email)->value('status');

            if ($userStatus == 'active') {
                if ($userType == 'user') {
                    return redirect()->intended(route("home"))->with("success", "Login is successful.");
                } elseif ($userType == 'admin') {
                    return redirect()->intended(route("dashboard"))->with("success", "Login is successful.");
                }
            } else {
                Auth::logout();
                return redirect(route("login"))->with("error", "Your account is inactive. Please contact the administrator.");
            }
        }

        return redirect(route("login"))->with("error", "Login details are not valid.");
    }
}
