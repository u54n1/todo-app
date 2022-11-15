<div class="space-y-6">
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
        <h1 class="text-lg font-bold leading-6 text-gray-900">My Tasks</h1>
    </div>

    <div class="space-y-6 w-1/2 mx-auto">
        <div class="">
            <h1 class="text-md font-bold leading-6 text-gray-400">TO-DO</h1>
            <div class="overflow-hidden rounded-lg border border-gray-300 bg-white mt-2 mb-4">
                <ul role="list" class="divide-y divide-gray-300">
                    @forelse($tasks as $task)
                        <li class="flex justify-between items-center px-6 py-2">
                            <p>{{ $task->description }}</p>
                            <div class="items-center flex space-x-8">
                                <div>
                                    <input wire:click="completeTask({{ $task->id }})" type="checkbox">
                                </div>
                                <button wire:click="removeTask({{ $task->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </li>
                    @empty
                        <p class="flex justify-center px-6 py-4">
                            You have no new task, add a task to continue.
                        </p>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="pt-6">
            <h1 class="text-md font-bold leading-6 text-gray-400">COMPLETED</h1>
            <div class="overflow-hidden rounded-lg border border-gray-300 bg-white mt-2 mb-4">
                <ul role="list" class="divide-y divide-gray-300">
                    @forelse($completedTasks as $completedTask)
                        <li class="flex justify-between items-center space-x-2 px-6 py-2">
                            <p class="text-gray-400 line-through">{{ $completedTask->description }}</p>
                            <button wire:click="removeTask({{ $completedTask->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </li>
                    @empty
                        <p class="flex justify-center px-6 py-4">
                            You have no completed tasks.
                        </p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-gray-200 px-6 py-6">
        <form wire:submit.prevent="addTask">
            <label for="description" class="block text-sm font-medium text-gray-700">New Task</label>
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
</div>
