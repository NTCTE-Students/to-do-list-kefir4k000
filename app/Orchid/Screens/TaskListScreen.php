<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Models\Task;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class TaskListScreen extends Screen
{
    public $name = 'Список задач';

    public function query(): iterable
    {
        return [
            'tasks' => Task::all(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Создать задачу')
                ->icon('plus')
                ->route('platform.task.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('tasks', [
                TD::make('title', 'Название')
                    ->render(function (Task $task) {
                        return Link::make($task->title)
                            ->route('platform.task.edit', $task);
                    }),
                TD::make('completed', 'Выполнено')
                    ->render(function (Task $task) {
                        return $task->completed ? 'Да' : 'Нет';
                    }),
            ]),
        ];
    }
}
