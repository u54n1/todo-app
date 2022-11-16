<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task as TaskModel;
use Livewire\WithPagination;

class Task extends Component
{
    use WithPagination;

    public string $description = '';
    public TaskModel $editTask;
    public bool $is_completed = false;
    public bool $showEditTaskModal = false;

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

    public function showEditModal(TaskModel $task)
    {
        $this->editTask = $task;
        $this->description = $this->editTask->description;
        $this->showEditTaskModal = true;
    }

    public function editTask(TaskModel $task)
    {
        $this->validate();

        TaskModel::find($task->id)->update([
            'description' => $this->description,
            'is_completed' => $this->is_completed,
        ]);

        $this->description = '';

        $this->showEditTaskModal = false;

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

        $this->showEditTaskModal = false;
    }

    public function render()
    {
        return view('livewire.task', [
            'pendingTasks' => TaskModel::where('is_completed', false)->latest()->paginate(3, ['*'], 'pendingTasksPage'),
            'completedTasks' => TaskModel::where('is_completed', true)->orderBy('updated_at', 'desc')->paginate(3, ['*'], 'completedTasksPage'),
        ]);
    }
}
