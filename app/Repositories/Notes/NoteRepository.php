<?php
namespace App\Repositories\Notes;
use App\Repositories\Interfaces\Notes\NoteRepositoryInterface;

class NoteRepository implements NoteRepositoryInterface
{

    /**
     * stor note details.
     *  @param [object,array] of [$task, $noteData]
     *  @return object of $taskNotes;
     */
    public function storeTaskNotes($task,$noteData)
    {
        $taskNotes = $task->notes()->create($noteData);
        return $taskNotes;
    }
}
