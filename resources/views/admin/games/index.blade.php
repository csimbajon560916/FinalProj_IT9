<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Game Schedules & Results') }}
            </h2>
            <a href="{{ route('admin.games.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                + Schedule Game
            </a>
        </div>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @foreach($groupedGames as $tournamentName => $games)
            <div class="mb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-blue-600 mb-4 pb-2 border-b">
                    {{ $tournamentName }}
                </h3>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Round</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matchup</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Venue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($games as $game)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">
                                    {{ $game->round_name ?? "Round $game->round_number" }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold {{ $game->status === 'completed' && $game->team1_score > $game->team2_score ? 'text-green-600' : '' }}">
                                            {{ $game->team1?->name ?? 'TBD' }}
                                        </span>
                                        <span class="text-gray-400 text-xs">vs</span>
                                        <span class="font-bold {{ $game->status === 'completed' && $game->team2_score > $game->team1_score ? 'text-green-600' : '' }}">
                                            {{ $game->team2?->name ?? 'TBD' }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($game->match_datetime)->format('M d y, g:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 font-mono">
                                    {{ $game->team1_score }} - {{ $game->team2_score }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $game->venue->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $game->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($game->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right flex justify-end gap-3">
                                    @if($game->status !== 'completed')
                                        <a href="{{ route('admin.games.edit', $game->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                    @else
                                        <span class="text-gray-400 text-sm italic">Finalized</span>
                                    @endif

                                    <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>
</x-app-layout>
