<?php
namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserAuthController extends Controller
{

    use ApiResponse;

    public function __construct(protected UserService $userService){}

    /**
     * Login user and create token, email and password needs to send through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:filter',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 401);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->error(['error' => 'Unauthorized'], 401);
        }
        $response = $this->userService->login($request);
        return $this->success(message: 'You are successfully logged in', content: $response);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 401);
        }
        $response = $this->userService->signup($request);
        return $this->success(message: 'Your account is created successfully', content: $response);
    }

    /**
     * Logout through get
     * @return [json] \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->userService->logout($request);
        return $this->success(message: 'You are successfully logged out', content: []);
    }
}
