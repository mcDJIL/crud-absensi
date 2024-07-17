<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{

    protected $userModel;
    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:5|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|alphaNum|min:8|confirmed',
            'password_confirmation' => 'required',
            'terms' => 'accepted'
        ]);

        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        };

        $user = collect($request->only($this->userModel->getFillable()))
        ->put('password', Hash::make($request->password))
        ->toArray();

        $register = $this->userModel->create($user);

        if ($register)
        {
            $request->session()->regenerate();

            return redirect()->intended('/login');
        }
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

                if ($user->role === 'admin')
                {
                    return redirect()->intended('/admin');
                } else {
                    return redirect()->intended('/dashboard');
                }
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
