<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Tournament Teams Management</h2>
                <a href="{{ route('admin.teams.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow">
                    + Add New Team
                </a>
            </div>

            @forelse($groupedTournaments as $tournamentName => $teams)
                <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100 p-6">
                    <div class="border-b border-gray-100 pb-3 mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-extrabold text-indigo-600 uppercase tracking-wider">
                            {{ $tournamentName }}
                        </h3>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2.5 py-1 rounded-full">
                            {{ $teams->count() }} {{ Str::plural('Team', $teams->count()) }}
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">#</th>

            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/3">Team Name</th>

            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/3">Coach</th>

            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-44">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-100">
        @foreach($teams as $index => $team)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-400 font-mono">
                    {{ $index + 1 }}
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                    <span class="text-indigo-600">{{ $team->name }}</span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                    {{ $team->coach_name ?? 'No Coach Assigned' }}
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-right space-x-3">
                    <a href="{{ route('admin.teams.edit', $team->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>

                    <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
                    </div>
                </div>
            @empty
                <div class="bg-white text-center py-12 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-gray-400 text-sm">No leagues or teams found. Get started by clicking "+ Add New Team".</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
