<div class="space-y-6">
    <div class="bg-white px-4 py-5 sm:px-6">
        <h1 class="text-2xl font-bold leading-6 text-gray-900">My Tasks</h1>
    </div>

    <div class="space-y-6 w-3/4 mx-auto">
        <div class="">
            <h1 class="text-md font-bold leading-6 text-gray-400">TO-DO</h1>
            <div class="overflow-hidden rounded-lg border border-gray-300 bg-white mt-2 mb-4">
                <ul role="list" class="divide-y divide-gray-300">
                    @forelse($pendingTasks as $pendingTask)
                        <li class="flex justify-between items-center px-6 py-2 space-x-8">
                            <p>{{ $pendingTask->description }}</p>
                            <div class="items-center flex">
                                <div class="mr-4">
                                    <input wire:click="completeTask({{ $pendingTask->id }})" type="checkbox">
                                </div>
                                <x-button wire:click="showEditModal({{ $pendingTask->id }})" info flat icon="pencil-alt" />
                            </div>
                        </li>
                    @empty
                        <p class="flex justify-center px-6 py-4">
                            You have no new task, add a task to continue.
                        </p>
                    @endforelse
                </ul>
            </div>
            {{ $pendingTasks->links() }}
        </div>

        <div class="pt-4">
            <h1 class="text-md font-bold leading-6 text-gray-400">COMPLETED</h1>
            <div class="overflow-hidden rounded-lg border border-gray-300 bg-white mt-2 mb-4">
                <ul role="list" class="divide-y divide-gray-300">
                    @forelse($completedTasks as $completedTask)
                        <li class="flex justify-between items-center space-x-2 px-6 py-2">
                            <p class="text-gray-400 line-through hover:no-underline">{{ $completedTask->description }}</p>
                            <div class="items-center flex">
                                <x-button wire:click="undoTaskCompletion({{ $completedTask->id }})" flat icon="refresh" />
                                <x-button wire:click="removeTask({{ $completedTask->id }})" negative flat icon="trash" />
                            </div>
                        </li>
                    @empty
                        <p class="flex justify-center px-6 py-4">
                            You have no completed tasks.
                        </p>
                    @endforelse
                </ul>
            </div>
            {{ $completedTasks->links() }}
        </div>
    </div>

    <div class="bg-gray-200 px-6 py-6">
        <form wire:submit.prevent="addTask">
            <label for="description" class="block text-sm font-bold text-gray-700">New Task</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input wire:model="description" type="text" name="description" id="description" class="block w-full rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Task description">
                <button type="submit" class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                    <span>Add</span>
                </button>
            </div>
            @error('description') <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
        </form>
    </div>

    <x-modal.card title="Edit Task" blur wire:model.defer="showEditTaskModal">
        <div class="space-y-4">
            <x-input wire:model="description" label="Task" />
            <div class="flex justify-end pt-4">
                <x-checkbox lg id="left-label" left-label="Mark task as complete" wire:model.defer="is_completed" />
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <x-button flat negative label="Delete" wire:click="removeTask({{ $editTask->id ?? '' }})" />

                <div class="flex">
                    <x-button flat label="Cancel" wire:click="$toggle('showEditTaskModal')" />
                    <x-button primary label="Save" wire:click="editTask({{ $editTask->id ?? '' }})" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
