<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponserTrait;

/**
 * Class UserService
 * 
 * This service handles user-related operations such as registration and login.
 */
class UserService
{
    use ApiResponserTrait;

    /**
     * Register a new user.
     * 
     * @param Request $request
     * The request object containing user registration data.
     * 
     * @return array
     * An array containing the user resource and a newly generated API token.
     */
    public function RegisterUser(Request $request): array
    {
        // Create a new user with the provided data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the 'user' role to the newly created user
        $user->assignRole('user');

        // Prepare the response data
        $data = [
            'data' => new UserResource($user),
            'user-token' => $user->createToken("API TOKEN")->plainTextToken,
        ];

        // Return the data array
        return $data;
    }

    /**
     * Log in a user.
     * 
     * @param Request $request
     * The request object containing user login credentials.
     * 
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * If the credentials do not match any user records.
     * 
     * @return array
     * An array containing the user resource and a newly generated API token.
     */
    public function LoginUser(Request $request): array
    {
        // Attempt to log in the user with the provided credentials
        if (!Auth::attempt($request->only(['email', 'password']))) {
            abort(400, 'Email & Password do not match our records.');
        }

        // Retrieve the authenticated user by email
        $user = User::where('email', $request->email)->first();

        // Prepare the response data
        $data = [
            'data' => new UserResource($user),
            'user-token' => $user->createToken("API TOKEN")->plainTextToken,
        ];

        // Return the data array
        return $data;
    }
}
