<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class AuthorizationController extends BaseController
{
    public function getLoginForm()
    {
        return view('pages.login');
    }

    public function performLogin(Request $request)
    {

        $email = $request->loginEmail;
        $password = $request->loginPassword;
        $stayLoggedIn = $request->loginStayLoggedIn;
        $stayLogged = false;

        if ($stayLoggedIn == null) {
            $stayLogged = false;
        } else {
            $stayLogged = true;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            parent::writeToLog('error', 'User ' . $email . ' doesn\'t exist. ip(' . $request->ip() . ")");
            return redirect()->back()->with('error-msg', 'User with that email does not exist.');
        }

        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->with('error-msg', 'Wrong password.');
        }   

        Auth::login($user, $stayLogged);

        parent::writeToLog('info', 'User { ' . $user->id . ' }  logged in.');
        return redirect()->route('home');
    }

    public function performLogout()
    {
        $id = Auth::user()->id;
        parent::writeToLog('info', 'User { ' . $id . ' } logged out.');
        Auth::logout();
        return redirect('/');
    }
}
