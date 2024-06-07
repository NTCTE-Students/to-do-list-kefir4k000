<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use App\Models\Task;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Switcher;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TaskEditScreen extends Screen
{
    public $name = 'Редактировать задачу';
    public $description = 'Создание и редактирование задач';

    private $exists = false;

    public function query(Task $task = null): iterable
    {
        $this->exists = $task->exists;

        return [
            'task' => $task ?? new Task(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
            Button::make('Удалить')
                ->icon('trash')
                ->confirm('Вы уверены, что хотите удалить эту задачу?')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('task.title')
                    ->title('Название')
                    ->placeholder('Введите название задачи')
                    ->required(),

                Input::make('task.description')
                    ->title('Описание')
                    ->placeholder('Введите описание задачи'),

                Switcher::make('task.completed')
                    ->sendTrueOrFalse()
                    ->title('Выполнено'),
            ]),
        ];
    }

    public function save(Task $task)
    {
        $task->fill(request()->get('task'))->save();

        Alert::info('Задача сохранена успешно.');

        return redirect()->route('platform.task.list');
    }

    public function remove(Task $task)
    {
        $task->delete();

        Alert::info('Задача удалена успешно.');

        return redirect()->route('platform.task.list');
    }
}
