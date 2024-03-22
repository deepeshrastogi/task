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

    /**
     * get tasks list.
     *  @param [int,array] of [$loginUserId,$filter]
     *  @return object of $tasks list
     */

    public function getUserTaskList($loginUserId,$filter)
    {
        $notesFilter = "";
        if(!empty($filter['notes'])){
            $notesFilter = $filter['notes'];
        }
        $tasks = Task::withCount('notes')
        ->with(['notes.attachments'])
        ->where('user_id',$loginUserId);
        if (!empty($notesFilter)) {
            $relationShipconditions = ['with','whereHas'];
            foreach($relationShipconditions as $condition){
                $tasks = $tasks->$condition('notes',function($q) use($notesFilter){
                    $q->where('note', 'like', '%' . $notesFilter . '%');
                });
            }
        }
        
        if(!empty($filter['status'])){
            $tasks = $tasks->where('status',$filter['status']);
        }
        if(!empty($filter['due_date'])){
            $tasks = $tasks->where('due_date',$filter['due_date']);
        }
        if(!empty($filter['priority'])){
            $tasks = $tasks->where('priority',$filter['priority']);
        }
        $tasks = $tasks->having('notes_count','>',0)
        ->priority('high')
        ->orderBy('notes_count', 'desc')
        ->get();
        return $tasks;
    }
}
