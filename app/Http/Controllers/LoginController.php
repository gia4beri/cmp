<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        $validated = $request->validated();

        $result = Auth::attempt(
            [
                'username' => $validated['username'],
                'password' => $validated['password']
            ],
            $request->remember
        );

        if($result){
            return redirect('/dashboard');
        } else {
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
