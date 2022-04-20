<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $objUsers = User::all()
            ->orderBy('last_nam')
            ->orderBy('name')
            ->full_name;
        return view('authors')
            ->with('objUsers', $objUsers);
    }

    /**
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('login');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('signup');
    }

    /**
     * @param  StoreUserRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->all();
        $validated['password'] = Hash::make($request->password);
        User::create($validated);
        return redirect('/login');
    }

    /**
     * @param  User  $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.profile_info');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if (false !== str_contains(url()->previous(), 'profile')) {
            return redirect()->route('main');
        } else {
            return back();
        }
    }

    /**
     * @param  Request  $request
     * @return View|RedirectResponse
     */
    public function authenticate(Request $request): View|RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($request->input('remember-me')) {
            $needUserRemember = true;
        } else {
            $needUserRemember = false;
        }

        if (Auth::attempt($credentials, $needUserRemember)) {
            $request->session()->regenerate();
            return redirect()->route('main');
        }

        return back()->withErrors([
            'email' => 'Неверный логин и/или пароль.',
        ])->onlyInput('email');
    }
}
