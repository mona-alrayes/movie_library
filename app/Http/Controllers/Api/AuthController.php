<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponserTrait;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponserTrait;

    public function register(RegisterUserRequest $request)
    {
        try {
            $request->validated();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $data = [
                'data' => new UserResource($user),
                'user-token' => $user->createToken("API TOKEN")->plainTextToken,
            ];
            return $this->successResponse($data, 'User Created Successfully');

        } catch (Throwable $th) {
            
            return $this->errorResponse('server error probably.',[$th->getMessage()], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return $this->errorResponse('Validation Error.', [$validateUser->errors()], 400);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->errorResponse('Email & Password does not match with our record.', [], 400);
            }

            $user = User::where('email', $request->email)->first();
            $data = [
                'data' => new UserResource($user),
                'user-token' => $user->createToken("API TOKEN")->plainTextToken,
            ];
            return $this->successResponse($data, 'User logged-in Successfully');
        } catch (Throwable $th) {
            return $this->errorResponse('sever error probably', [$th->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse([], 'Logged out successfully', 200);
    }
}
