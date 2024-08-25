<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponserTrait;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;

/**
 * Class AuthController
 * 
 * This controller handles user authentication-related actions, 
 * including registration, login, and logout.
 */
class AuthController extends Controller
{
    use ApiResponserTrait;

    /**
     * @var UserService
     * The service instance to handle user-related logic.
     */
    protected $UserService;

    /**
     * AuthController constructor.
     * 
     * @param UserService $UserService
     * The service that handles user operations.
     */
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    /**
     * Register a new user.
     * 
     * @param RegisterUserRequest $request
     * The validated request object containing registration data.
     * 
     * @return \Illuminate\Http\JsonResponse
     * A success response on successful registration or an error response on failure.
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            $request->validated();
            $validatedUser = $this->UserService->RegisterUser($request);
            return $this->successResponse($validatedUser, 'User Created Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Server error probably.', [$e->getMessage()], 500);
        }
    }

    /**
     * Log in a user.
     * 
     * @param LoginUserRequest $request
     * The validated request object containing login credentials.
     * 
     * @return \Illuminate\Http\JsonResponse
     * A success response on successful login or an error response on failure.
     */
    public function login(LoginUserRequest $request)
    {
        try {
            $request->validated();
            $validatedUser = $this->UserService->LoginUser($request);
            return $this->successResponse($validatedUser, 'User logged-in Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Server error probably.', [$e->getMessage()], 500);
        }
    }

    /**
     * Log out the authenticated user.
     * 
     * @param Request $request
     * The request object, used to retrieve the current user.
     * 
     * @return \Illuminate\Http\JsonResponse
     * A success response indicating the user has logged out successfully.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse([], 'Logged out successfully', 200);
    }

    /**
     * Handle an exception and return a formatted error response.
     * 
     * @param \Exception $e
     * The caught exception.
     * 
     * @param string $message
     * A custom message to include in the response.
     * 
     * @return \Illuminate\Http\JsonResponse
     * A JSON response containing the error message and details.
     */
    protected function handleException(\Exception $e, string $message)
    {
        // Log the error for debugging purposes
        Log::error($e->getMessage());

        return response()->json([
            'message' => $message,
            'error' => $e->getMessage(),
        ], 500);
    }
}
