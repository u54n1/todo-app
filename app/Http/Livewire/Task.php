<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task as TaskModel;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Task extends Component
{
    use WithPagination, Actions;

    public string $description = '';
    public string $addNewTaskDescription = '';
    public TaskModel $editTask;
    public bool $is_completed = false;
    public bool $showEditTaskModal = false;

    protected $rules = [
        'addNewTaskDescription' => 'required|min:3|max:100',
    ];

    public function addTask()
    {
        // Validate inputs
        $this->validate();
        // Create task
        TaskModel::create([
            'description' => $this->addNewTaskDescription,
        ]);
        // Reset description state
        $this->addNewTaskDescription = '';
        // notify new task added
        $this->notification()->success(
            $description = 'Your task was added successfully.'
        );
    }

    public function showEditModal(TaskModel $task)
    {
        $this->editTask = $task;
        $this->description = $this->editTask->description;
        $this->showEditTaskModal = true;
    }

    public function editTask(TaskModel $task)
    {
        $validatedData = $this->validate([
            'description' => 'required|min:3|max:100',
            'is_completed' => 'boolean',
        ]);

        TaskModel::find($task->id)->update($validatedData);
        $this->is_completed = false;

        $this->showEditTaskModal = false;

        $this->notification()->success(
            $description = 'Your task was updated successfully.'
        );

    }

    public function completeTask(TaskModel $task)
    {
        TaskModel::find($task->id)->update([
            'is_completed' => true,
        ]);

        $this->notification()->success(
            $description = 'Your task was completed successfully.'
        );
    }

    public function undoTaskCompletion(TaskModel $task)
    {
        TaskModel::find($task->id)->update([
            'is_completed' => false,
        ]);
    }

    public function removeTask(TaskModel $task)
    {
        TaskModel::find($task->id)->delete();

        $this->showEditTaskModal = false;

        $this->notification([
            'description' => 'Your task was deleted successfully.',
            'icon'        => 'trash',
        ]);
    }

    public function render()
    {
        return view('livewire.task', [
            'pendingTasks' => TaskModel::where('is_completed', false)->latest()->paginate(3, ['*'], 'pendingTasksPage'),
            'completedTasks' => TaskModel::where('is_completed', true)->orderBy('updated_at', 'desc')->paginate(3, ['*'], 'completedTasksPage'),
        ]);
    }
}
