 {{-- Table View Task  list with filter by status and action to edit and delete task --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Task List') }}
        </h2>
        <div class="flex justify-end mt-2">
            <x-nav-link :href="route('task.create')" :active="request()->routeIs('task.create')">
                <x-primary-button>
                    {{ __('Create Task') }}
                </x-primary-button>
            </x-nav-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- filter by status with functionality --}}
                <div class="mb-4">
                    <form method="GET" action="{{ route('task.index') }}" class="flex items-center space-x-4">
                        <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Filter by Status') }}</label>
                        <select id="status" name="status" class="block w-full border-gray-300 rounded-md shadow-sm sm:w-auto dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>{{ __('All') }}</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>{{ __('Overdue') }}</option>
                        </select>
                        <label for="due_date" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Due Date') }}</label>
                        <select id="due_date" name="due_date" class="block w-full border-gray-300 rounded-md shadow-sm sm:w-auto dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-400 dark:focus:border-indigo-400">
                            <option value="" {{ request('due_date') == '' ? 'selected' : '' }}>{{ __('All') }}</option>
                            <option value="7_days" {{ request('due_date') == '7_days' ? 'selected' : '' }}>{{ __('Due In 7 Days') }}</option>
                            <option value="30_days" {{ request('due_date') == '30_days' ? 'selected' : '' }}>{{ __('Due In 30 Days') }}</option>
                        </select>
                        <x-primary-button type="submit">{{ __('Filter') }}</x-primary-button>
                    </form>
                </div>

                <!-- Task List -->
                {{-- diplay width 100%  --}}
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('S.No') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Title') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Description') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Due Date') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach($tasks as $task)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $task->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $task->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $task->due_date ? $task->due_date : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                       <span
                                            @class([
                                                'px-2 py-1 rounded-full text-sm font-medium',
                                                'bg-yellow-100 text-yellow-800' => $task->status === 'pending',
                                                'bg-green-100 text-green-800' => $task->status === 'completed',
                                                'bg-blue-100 text-blue-800' => $task->status === 'in progress',
                                                'bg-gray-100 text-gray-800' => !in_array($task->status, ['pending', 'completed', 'in progress']),
                                            ])
                                        >
                                            {{ ucwords($task->status) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap ">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('task.edit', $task->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a4 4 0 00-5.464 0L3 12.586V17h4.414l6.768-6.768a4 4 0 000-5.464z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('task.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($tasks->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                                    No tasks found.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
