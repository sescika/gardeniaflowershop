<?php

namespace App\Http\Controllers;


use App\Models\Roles;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class UserController extends BackendController
{
    /**
     * Display a listing of the resource.
     */
    public function getAllRolesJson()
    {
        $roles = Roles::all();
        return response()->json(["roles" => $roles]);
    }

    public function getAllUsersJson()
    {
        $users = User::with('role')->orderByDesc('role_id')->paginate(10);
        $users->withPath('/admin/users');
        $links = (string)$users->links();
        $data = [
            'users' => $users,
            'links' => $links
        ];

        return response()->json($data);
    }

    public function getUserJson($id)
    {
        $user = User::with('role')->where('id', $id)->first();


        return response()->json($user);
    }

    public function index()
    {
        $users = User::with('role')->orderByDesc('role_id')->paginate(10);
        $roles = Roles::all();

        $data = [
            'roles' => $roles,
            'users' => $users,
        ];
        return view('pages.admin.users', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            User::create([
                'first_name' => $request->get("registerFirstName"),
                'last_name' => $request->get("registerLastName"),
                'password' => Hash::make($request->get("registerPassword")),
                'email' => $request->get("registerEmail"),
            ]);
            parent::writeToLog('info', 'User' . $request->get('registerEmail') . ' registered.');
            return redirect()->back()->with("registration-success", " registered.");
        } catch (Exception $e) {
            parent::writeToLog('error', $e);
            return redirect()->back()->with("registration-error", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $user = User::with('role')->where('id', $request->get("id"))->first();
        return view('pages.user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "first_name" => "required|string|min:3|max:20",
            "last_name" => "required|string|min:3|max:20",
            'email' => 'required|email:rfc',
            'role_id' => 'required|in:1,2'
        ]);
        if ($validated) {
            try {
                $user = User::find($id);

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->role_id = $request->role_id;

                if ($request->password) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                parent::writeToLog('info', "User{ " . $id . " }  updated");
                return redirect()->route('profile');
            } catch (Exception $e) {
                parent::writeToLog('error', $e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    public function sendEmail(Request $request)
    {
        // dd($request->all());
        $request->validate(['updateUserEmail' => 'required|email']);
        $email = [
            'email' => $request->only('updateUserEmail')
        ];
        $status = Password::sendResetLink(
            $email
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
    public function updatePassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function resetPasswordSendEmailForm()
    {
        return view('pages.user.resetPasswordSendEmailForm');
    }

    public function resetPasswordForm()
    {
        return view('pages.user.resetPasswordForm');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userToDelete = User::find($id);

        try {
            $userToDelete->delete();
            parent::writeToLog('info', "User{ " . $id . " }  deleted");
        } catch (Exception $e) {
            parent::writeToLog('error', $e->getMessage());
        }

        return redirect(route('admin.users.getAll'));
    }
}
