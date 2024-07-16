<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:8'
        ]);

        if ($validation->fails())
        {
            return redirect()->to('login')->withErrors($validation)
            ->withInput();
        }

        $credentials = $request->only([ 'email', 'password' ]);

        if (Auth::attempt($credentials))
        {

            $user = Auth::user();

            if ($user)
            {
                $request->session()->regenerate();

                return redirect()->intended('/admin');
            }
        }
        else 
        {
            return redirect()->to('login')->withErrors(['invalid' => 'Email atau password salah'])
            ->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
