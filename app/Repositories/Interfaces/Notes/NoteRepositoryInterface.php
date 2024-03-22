<?php
namespace App\Repositories\Interfaces\Notes;

/*
 * Interface NoteRepositoryInterface
 * @package App\Repositories
 */
interface NoteRepositoryInterface
{
    public function storeTaskNotes($task,$noteData);
}
