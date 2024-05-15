<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function register(Request $request){


        // data validation
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'bio' => 'nullable|max:150',
            'genres' => [
                'nullable',
                'regex:/^(\s*\b[\w-]+\b\s*(?:,\s*)?){0,5}$/'
            ]

        ]);

        $this->userService->registerUser([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'bio' => $request->bio,
            'genres' => $request->genres


        ]);

        return response()->json([
            'statusCode' => 201,
            'success' => true,
            'message' => 'User registered successfully'

        ]);
    }
    // web route
    public function verifyByEmail($token){

        $verifyToken = $this->userService->verify($token);
        if($verifyToken){

            return view('auth.successfully_password_verification', ['msg' => 'Your account has been successfully verified']);
        }else return view('auth.successfully_password_verification', ['msg' => 'Something went wrong']);



    }


    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'statusCode' => 404,
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'statusCode' => 401,
                'success' => false,
                'message' => 'Please confirm your email'
            ]);
        }


        $token = JWTAuth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$token) {
            return response()->json([
                'statusCode' => 401,
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
        }


        return response()->json([
            'statusCode' => 200,
            'success' => true,
            'token' => $token,
            'message' => 'User logged in successfully'
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out',
            'statusCode' => 200,

            'success' => true]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        if ($this->userService->resetPassword($request->email)){
            return response()->json([
                'statusCode' => 200,
                'success' => true,
                'message' => 'Password reset email sent successfully'
            ]);
        }else
            return response()->json([
                'statusCode' => 401,
                'success' => false,
                'message' => "User not found or hasn't verified email"
            ]);
    }
    // web route
    public function passwordResetSubmit(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $result = $this->userService->passwordResetSubmitService(
            $request);

        if($result){

            return view('auth.successfully_password_reset', ['msg' => 'Your Password Has Been Successfully Changed.']);
        }else return view('auth.successfully_password_reset', ['msg' => 'Failed to Change Password']);



    }

    // web route
    public function passwordResetForm($token)
    {
        return view('auth.reset_password_form', ['token' => $token]);
    }

    public function profile(Request $request): JsonResponse{

        $userdata = auth()->user();
        $user = User::with(['profile', 'threads', 'comments'])->find($userdata->user_id);

        return response()->json([
            "statusCode" => 200,
            "message" => "Profile data",
            "data" => $user
        ]);
    }

    public function refreshToken(){

        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New access token",
            "token" => $newToken
        ]);
    }



}

