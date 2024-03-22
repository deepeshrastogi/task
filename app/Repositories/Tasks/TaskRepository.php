<?php
namespace App\Repositories\Tasks;

use App\Models\Task;
use App\Repositories\Interfaces\Tasks\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{

    /**
     * stor task details.
     *  @param array of $taskData
     *  @return object of created $task
     */
    public function storeTask($taskData)
    {
        $task = Task::create($taskData);
        return $task;
    }

    public function getUserTaskList($loginUserId,$filter)
    {
        $notesFilter = "";
        if(!empty($filter['notes'])){
            $notesFilter = $filter['notes'];
        }
        $taskData = Task::withCount('notes')
        ->with(['notes.attachments'])
        ->where('user_id',$loginUserId);
        if (!empty($notesFilter)) {
            $relationShipconditions = ['with','whereHas'];
            foreach($relationShipconditions as $condition){
                $taskData = $taskData->$condition('notes',function($q) use($notesFilter){
                    $q->where('note', 'like', '%' . $notesFilter . '%');
                });
            }
        }
        
        if(!empty($filter['status'])){
            $taskData = $taskData->where('status',$filter['status']);
        }
        if(!empty($filter['due_date'])){
            $taskData = $taskData->where('due_date',$filter['due_date']);
        }
        if(!empty($filter['priority'])){
            $taskData = $taskData->where('priority',$filter['priority']);
        }
        $taskData = $taskData->having('notes_count','>',0)
        ->priority('high')
        ->orderBy('notes_count', 'desc')
        ->get();
        return $taskData;
    }
}
