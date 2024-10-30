<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user
            || !Hash::check($request->password, $user->password)
            || ($this->getSubdomain($request) != null && $user->tenant->domain_name !== $this->getSubdomain($request))
        ) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')]
            ]);
        }

        if($request->has('token')) {
            $user->update(['device_token' => $request->token]);
        }

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

    private function getSubdomain(Request $request)
    {
        // Get the referer header
        $referer = $request->headers->get('referer');

        if ($referer) {
            // Parse the URL to extract the host
            $host = parse_url($referer, PHP_URL_HOST);

            // Split the host by dot (.)
            $hostParts = explode('.', $host);

            // Assuming your domain is "theloctech.com", get the subdomain
            if (count($hostParts) > 2) {
                $subdomain = $hostParts[0]; // This will get "rxa" from "rxa.theloctech.com"
            } else {
                $subdomain = null; // No subdomain present
            }
            return $subdomain;
        }
    }
}
