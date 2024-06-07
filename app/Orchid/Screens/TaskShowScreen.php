<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Task;
use Orchid\Support\Facades\Layout;

class TaskShowScreen extends Screen
{
    public $name = 'Просмотр задачи';

    public function query(Task $task): iterable
    {
        return [
            'task' => $task,
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('task', [
                'title'       => 'Название',
                'description' => 'Описание',
                'completed'   => 'Выполнено',
            ]),
        ];
    }
}
