<?php

namespace App\Services;
use App\Repositories\Interfaces\Tasks\TaskRepositoryInterface;
use App\Services\NoteService;
use App\Services\AttachmentService;
use App\Traits\ApiResponse;
use Validator;

class TaskService
{

    use ApiResponse;
    /**
     * @var $taskRepository
     */

    /**
     * order constructor.
     *
     * @param Repository $taskRepository
     */

    public function __construct(protected TaskRepositoryInterface $taskRepository,protected NoteService $noteService,protected AttachmentService $attachmentService){}

    public function index($requestData)
    {
        $loginUser = $this->loginUser($requestData);
        $filter = [
            'per_page' => !empty($requestData->per_page) ? $requestData->per_page : 10,
            'search' => !empty($requestData->search) ? $requestData->search : '',
            'status' => !empty($requestData->status) ? $requestData->status : '',
        ];
        $tasks = $this->taskRepository->getUserTaskList($loginUser->id, $filter);
        $response = ['tasks' => $tasks];
        return $this->success(message: 'Your task has been fetched successfully', content: $response);
    }

    /**
     * store task with notes data with authentication
     * @param  \Illuminate\Http\Request
     * @return [json] task data
     */
    public function store($requestData)
    {
        $validateArr = [
            'subject' => 'required|unique:tasks',
            'description' => 'required',
            'start_date' => 'required',
            'due_date' => 'required|after:start_date',
            'status' => 'required',
            // 'note.*.subject' => 'required',
            // 'note.*.attachment.*' => 'max:4096',
        ];
        $validator = Validator::make($requestData->all(), $validateArr);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 401);
        }
        $userId = $requestData->user()->id;
        $taskData['subject'] = $requestData->subject;
        $taskData['description'] = $requestData->description;
        $taskData['start_date'] = $requestData->start_date;
        $taskData['due_date'] = $requestData->due_date;
        $taskData['status'] = $requestData->status;
        $taskData['priority'] = $requestData->priority;
        $taskData['user_id'] = $userId;
        $task = $this->taskRepository->storeTask($taskData);
        if(!empty($requestData->note)){
            $notesData = $requestData->note;
            $noteDataArr=[];
            foreach($notesData as $noteData){
                $noteDataArr = ['subject' => $noteData['subject'], 'note' => $noteData['note']];
                // call noteService for store notes of task   
                $note = $this->noteService->storeTaskNotes($task,$noteDataArr);
                if(!empty($noteData['attachment'])){
                    foreach($noteData['attachment'] as $attachment){
                        $attachmentResult = $this->attachmentService->storeAttachment($requestData,$attachment);  // call attachmentService for attachment upload and store attchemd details 
                        
                        $note->attachments()->save($attachmentResult); // store and make the relationship between note and attachment through the pivot table in attachment_note 
                    }
                }
            }
        }
        $response = ['task' => $task];
        return $this->success(message: 'Your task is created successfully', content: $response, status:201);
    }
}
