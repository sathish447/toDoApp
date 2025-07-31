<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-2">
                    <div>
                        <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('Task Status Overview') }}</h3>
                        <canvas id="myChart"></canvas>
                    </div>
                    <table class="hidden">
                        <tr>
                            <td>
                                <h3 class="text-lg font-semibold text-center">{{ __('Total Tasks') }}</h3>
                                <p class="text-2xl font-bold text-center">{{ $taskCount }}</p>
                            </td>
                            <td>
                                <h3 class="text-lg font-semibold text-center">{{ __('Completed Tasks') }}</h3>
                                <p class="text-2xl font-bold text-center">{{ $taskCountByStatus['completed'] ?? 0 }}</p>
                            </td>
                            <td>
                                <h3 class="text-lg font-semibold text-center">{{ __('Total Overdue Tasks') }}</h3>
                                <p class="text-2xl font-bold text-center">{{ $taskCountByStatus['overdue'] ?? 0 }}</p>
                            </td>
                            <td>
                                <h3 class="text-lg font-semibold text-center">{{ __('Total Pending Tasks') }}</h3>
                                <p class="text-2xl font-bold text-center">{{ $taskCountByStatus['pending'] ?? 0 }}</p>
                            </td>
                        </tr>
                    </table>

                    <div class="grid grid-cols-1 gap-4 mt-6 md:grid-cols-2 lg:grid-cols-4">
                        <div class="text-center">
                            <h3 class="text-lg font-semibold">{{ __('Total Tasks') }}</h3>
                            <p class="text-2xl font-bold">{{ $taskCount }}</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold">{{ __('Completed Tasks') }}</h3>
                            <p class="text-2xl font-bold">{{ $taskCountByStatus['completed'] ?? 0 }}</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold">{{ __('Overdue Tasks') }}</h3>
                            <p class="text-2xl font-bold">{{ $taskCountByStatus['overdue'] ?? 0 }}</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold">{{ __('Pending Tasks') }}</h3>
                            <p class="text-2xl font-bold">{{ $taskCountByStatus['pending'] ?? 0}}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
    ctx.height = 400;
    ctx.width = 400;
    ctx.style.width = '100%';
    ctx.style.height = '400px';
    ctx.style.maxWidth = '400px';
    ctx.style.maxHeight = '400px';
    ctx.style.margin = '0 auto';

  new Chart(ctx, {

    type: 'pie',
    data: {
      labels: ['Complete', 'Pending', 'Overdue'],
      datasets: [{
        label: 'Tasks',
        data: [
          {{ $taskCountByStatus['completed'] ?? 0 }},
          {{ $taskCountByStatus['pending'] ?? 0 }},
          {{ $taskCountByStatus['overdue'] ?? 0 }}
        ],
         hoverOffset: 4
      }]
    },

  });
</script>
