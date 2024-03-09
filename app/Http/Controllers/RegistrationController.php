<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\error;

class RegistrationController extends BaseController
{
    public function getRegisterForm()
    {
        return view('pages.registration');
    }

    public function store(Request $request)
    {
        try {
            User::create([
                'first_name' => $request->get("first_name"),
                'last_name' => $request->get("last_name"),
                'password' => Hash::make($request->get("password")),
                'email' => $request->get("email"),
            ]);

            parent::writeToLog('info', 'User { '. $request->get('email') . ' }  registered.');
            return redirect()->back()->with("registration-success", " registered.");
        } catch (Exception $e) {
            parent::writeToLog('error', $e);
            return redirect()->back()->with("registration-error", 'There was a problem with registration.');
        }
    }
}
