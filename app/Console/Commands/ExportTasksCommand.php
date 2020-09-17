<?php

namespace App\Console\Commands;

use App\Mail\TaskReminder;
use App\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ExportTasksCommand extends Command
{

    protected $signature = 'task-manager:reminders';

    protected $description = 'Send task reminders';


    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {
        $today = Carbon::now()->toDateString();

        Task::where('end_date', $today)->chunk(50, function($tasks) {
            $tasks->each(function($task){
                $this->sendReminder($task);
            });
        });
    }

    private function sendReminder($task)
    {
        $user = $task->assignee;

        Mail::to($user->email)
            ->cc('admin@task-manager.com')
            ->queue(new TaskReminder($task));
    }
}
