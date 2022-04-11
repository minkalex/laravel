<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Request;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $objUsers = User::all()
            ->orderBy('last_name')
            ->orderBy('name')
            ->full_name;
        return view('authors')
            ->with('objUsers', $objUsers);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('login');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function signUp()
    {
        return view('registration');
    }


    public function validation(Request $request)
    {
        $result = $request->all();
        dump($result);
    }
}
