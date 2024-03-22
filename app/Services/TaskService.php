<?php

namespace App\Services;
use App\Repositories\Interfaces\Tasks\TaskRepositoryInterface;
use App\Services\NoteService;
use App\Services\AttachmentService;

class TaskService
{
    /**
     * order constructor.
     *
     * @param Repository $taskRepository
     */

    public function __construct(protected TaskRepositoryInterface $taskRepository,protected NoteService $noteService,protected AttachmentService $attachmentService){}

    public function index($requestData)
    {
        $loginUserId = $requestData->user()->id;
        $filter = [
            'status' => !empty($requestData->status) ? $requestData->status : '',
            'due_date' => !empty($requestData->due_date) ? $requestData->due_date : '',
            'priority' => !empty($requestData->priority) ? $requestData->priority : '',
            'notes' => !empty($requestData->notes) ? $requestData->notes : '',
        ];
        $tasks = $this->taskRepository->getUserTaskList($loginUserId, $filter);
        return $tasks;
    }

    /**
     * store task with notes data with authentication
     * @param  \Illuminate\Http\Request
     * @return [json] task data
     */
    public function store($requestData)
    {
        $userId = $requestData->user()->id;
        $taskData['subject'] = $requestData->subject;
        $taskData['description'] = $requestData->description;
        $taskData['start_date'] = $requestData->start_date;
        $taskData['due_date'] = $requestData->due_date;
        $taskData['status'] = $requestData->status;
        $taskData['priority'] = $requestData->priority;
        $taskData['user_id'] = $userId;
        $task = $this->taskRepository->storeTask($taskData); //store task in database
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
        return $task;
    }
}
