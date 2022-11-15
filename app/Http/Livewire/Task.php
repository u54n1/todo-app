<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task as TaskModel;
use Livewire\WithPagination;

class Task extends Component
{
    use WithPagination;

    public string $description = '';
    public bool $is_completed = false;

    protected $rules = [
        'description' => 'required|min:3|max:100'
    ];

    public function addTask()
    {
        $this->validate();
        TaskModel::create([
            'description' => $this->description,
        ]);
        $this->description = '';
    }

    public function completeTask(TaskModel $task)
    {
        TaskModel::find($task->id)->update([
            'is_completed' => true,
        ]);
    }

    public function removeTask(TaskModel $task)
    {
        TaskModel::find($task->id)->delete();
    }

    public function render()
    {
        return view('livewire.task', [
            'tasks' => TaskModel::where('is_completed', false)->latest()->paginate(3, ['*'], 'pendingTasksPage'),
            'completedTasks' => TaskModel::where('is_completed', true)->orderBy('updated_at', 'desc')->paginate(3, ['*'], 'completedTasksPage'),
        ]);
    }
}
