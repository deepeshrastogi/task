<?php
namespace App\Repositories\Interfaces\Notes;

/*
 * Interface NoteRepositoryInterface
 * @package App\Repositories\Interfaces\Notes
 */
interface NoteRepositoryInterface
{
    public function storeTaskNotes($task,$noteData);
}
