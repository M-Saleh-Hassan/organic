<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (
            !$user
            || !Hash::check($request->password, $user->password)
        ) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')]
            ]);
        }

        return $this->handleResponse(new LoginResource($user));
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'role_id'      => Role::where('name', 'client')->first()?->id,
            'full_name'    => $request->full_name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'id_type'      => $request->id_type,
            'id_number'    => $request->id_number,
        ]);

        return $this->handleResponse(new LoginResource($user));
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->handleResponseMessage('Email reset sent successfully');
        }

        return response()->json(['message' => 'Unable to send reset link.'], 500);
    }

    /**
     * Handle a reset password request to the application.
     *
     * @param  ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->handleResponseMessage('Password has been successfully reset.');
        }

        return response()->json(['message' => 'Failed to reset password.'], 500);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('password.success')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
