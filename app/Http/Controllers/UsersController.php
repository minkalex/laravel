<?php

namespace App\Http\Controllers;

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
            ->orderBy('last_name')
            ->orderBy('name')
            ->full_name;
        return view('authors')
            ->with('objUsers', $objUsers);
    }

    /**
     * @return View
     */
    public function login(): View
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
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255|email:rfc,dns',
            'password' => 'required|max:255',
        ],
        $messages = [
            'required' => 'Поле обязательно для заполнения.',
            'max' => "Максимальная длина поля :max символов.",
            'email.unique' => 'Пользователь с таким e-mail уже существует.',
            'email.email' => 'Введите корректный e-mail.',
        ]);

        if ($validator->fails()) {
            return redirect('/signup')
                ->withErrors($validator)
                ->withInput();
        }

        User::create($request->all());
        return redirect('/');
    }

    public function profile($data = null)
    {
        return view('profile')
            ->with('objUser', $data);
    }

    public function authenticate(Request $request): View|RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $objUsers = User::where('email', $request->input('email'))
            ->get();
        $objUser = $objUsers->first();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if ($request->input('remember-me')) {
                Auth::login($objUser, true);
            } else {
                Auth::login($objUser);
            }
            return redirect()->route('profile')->with('user_id', $objUser->id);
        }

        return back()->withErrors([
            'email' => 'Неверный логин и/или пароль.',
        ])->onlyInput('email');
    }
}
