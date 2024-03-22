<?php
namespace App\Http\Controllers\Api\Notes;

use App\Http\Controllers\Controller;
use App\Services\NoteService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    use ApiResponse;

    public function __construct(protected NoteService $noteService){}

    /**
     * Tasks List
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function index(Request $request)
    {
        return $this->noteService->index($request);
    }

    /**
     * Login user and create token, email and password needs to send through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function store(Request $request)
    {
        return $this->noteService->store($request);
    }

    /**
     * Tasks List
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function show(Request $request, string $id)
    {
        return $this->noteService->show($request,$id);
    }


    /**
     * destroy through get
     * @return [json] \Illuminate\Http\Response
     */
    public function destroy(Request $request, string $id)
    {
        return $this->noteService->destroy($request,$id);
    }

     /**
     * update task status through patch
     * @return [json] \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        return $this->noteService->updateTaskStatus($request,$id);
    }

    /**
     * getTaskNameList through get
     * @return [json] \Illuminate\Http\Response
     */
    public function getTaskNameList(Request $request)
    {
        return $this->noteService->getTaskNameList($request);
    }

    /**
     * trashTasks through get
     * @return [json] \Illuminate\Http\Response
     */
    public function trashedTasks(Request $request)
    {
        return $this->noteService->trashedTasks($request);
    }

    
}
