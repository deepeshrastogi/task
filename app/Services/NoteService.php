<?php

namespace App\Services;
use App\Repositories\Interfaces\Notes\NoteRepositoryInterface;
use App\Traits\ApiResponse;

class NoteService
{

    use ApiResponse;
    /**
     * @var $noteRepository
     */

    /**
     * order constructor.
     *
     * @param Repository $noteRepository
     */

    public function __construct(protected NoteRepositoryInterface $noteRepository){}

    public function storeTaskNotes($task,$noteData)
    {
        $taskNotes = $this->noteRepository->storeTaskNotes($task,$noteData);
        return $taskNotes;
    }

}
