<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginPetugasController extends Controller
{
    public function loginForm(Request $request)
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credential = $request->only('user', 'password');
        $validator = Validator::make($credential, [
            'user' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();
            // $admin = Auth::guard('web')->user();

            // dd(Auth::user());
            // return redirect()->route('dashboard');
            return redirect()->intended('/');
        }
        return back()->withErrors(['message' => 'Account Not Found!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
