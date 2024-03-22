<?php
namespace App\Repositories\Notes;

use App\Models\Note;
use App\Repositories\Interfaces\Notes\NoteRepositoryInterface;

class NoteRepository implements NoteRepositoryInterface
{

    /**
     * stor note details.
     *  @param array of $noteData
     *  @return object of created $note
     */
    public function storeTaskNotes($task,$noteData)
    {
        $taskNotes = $task->notes()->create($noteData);
        return $taskNotes;
    }
}
