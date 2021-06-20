<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {

        $role = Auth::user()->role;

        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }

        switch ($role->slug) {
            case 'student':
                return redirect()->intended('/mon-compte');
            case 'host':
                return redirect()->intended('/host/dashboard');
            default:
                return redirect('/');
        }
    }

}
