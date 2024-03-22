<?php
namespace App\Repositories\Interfaces\Tasks;

/*
 * Interface TaskRepositoryInterface
 * @package App\Repositories\Interfaces\Tasks
 */
interface TaskRepositoryInterface
{
    public function storeTask($taskData);
    public function getUserTaskList($loginUserId,$filter);
}
