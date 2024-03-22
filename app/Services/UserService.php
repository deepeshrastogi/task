<?php

namespace App\Services;

use App\Repositories\Interfaces\Users\UserRepositoryInterface;
use App\Repositories\Interfaces\Tasks\TaskRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;


class UserService
{

    use ApiResponse;

    /**
     * order constructor.
     *
     * @param Repository $userRepository
     */

    public function __construct(protected UserRepositoryInterface $userRepository, protected TaskRepositoryInterface $taskRepository){}

    /**
     * Login user and create token, email and password needs to send through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function login($requestData)
    {
        $user = $requestData->user();
        $tokenResult = $user->createToken('user_access_token');
        $token = $tokenResult->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return $response;
    }

    /**
     * singup user and create token, name,email,password and confirm_password needs to send through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function signup($requestData)
    {
        $userData['name'] = $requestData->name;
        $userData['email'] = $requestData->email;
        $userData['password'] = Hash::make($requestData->password);
        $user = $this->userRepository->storeUser($userData);
        $tokenResult = $user->createToken('user_access_token');
        $token = $tokenResult->plainTextToken;
        $response = ['user' => $user, 'token' => $token];
        return $response;
    }

    /**
     * Logout through get
     * @return [json] \Illuminate\Http\Response
     */
    public function logout($requestData)
    {
        $requestData->user()->tokens()->delete();
    }

}
