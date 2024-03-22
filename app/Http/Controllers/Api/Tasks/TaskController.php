<?php
namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Validator;
use App\Models\Task; // need remove after code
class TaskController extends Controller
{

    use ApiResponse;
    public function __construct(protected TaskService $taskService){}

    /**
     * Tasks List
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function index(Request $request)
    {
        $task = $this->taskService->index($request);
        $response = ['task' => $task];
        return $this->success(message: 'Tasks have been fetched successfully', content: $response);
    }

    /**
     * Login user and create token, email and password needs to send through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function store(Request $request)
    {
        $validateArr = [
            'subject' => 'required|unique:tasks',
            'description' => 'required',
            'start_date' => 'required',
            'due_date' => 'required|after:start_date',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $validateArr);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 401);
        }
        $task = $this->taskService->store($request); // call task service to store task
        $response = ['task' => $task];
        return $this->success(message: 'Your task is created successfully', content: $response, status:201);
    } 
}
