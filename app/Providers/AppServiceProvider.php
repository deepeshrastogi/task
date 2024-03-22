<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Users\UserRepository;
use App\Repositories\Interfaces\Users\UserRepositoryInterface;
use App\Repositories\Tasks\TaskRepository;
use App\Repositories\Interfaces\Tasks\TaskRepositoryInterface;
use App\Repositories\Notes\NoteRepository;
use App\Repositories\Interfaces\Notes\NoteRepositoryInterface;
use App\Repositories\Attachments\AttachmentRepository;
use App\Repositories\Interfaces\Attachments\AttachmentRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerUserRepo();
        $this->registerTaskRepo();
        $this->registerNoteRepo();
        $this->registerAttachmentRepo();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }


    public function registerUserRepo() {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function registerTaskRepo() {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    public function registerNoteRepo() {
        $this->app->bind(NoteRepositoryInterface::class, NoteRepository::class);
    }

    public function registerAttachmentRepo() {
        $this->app->bind(AttachmentRepositoryInterface::class, AttachmentRepository::class);
    }
}
