<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tournament->name }} - Live Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('public.tournaments.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 mr-4">← Back to Leagues</a>
                    <span class="text-lg font-bold text-gray-900">{{ $tournament->name }} Live Dashboard</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-12">

        <section>
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 uppercase tracking-wider">Tournament Bracket Tree</h2>
            <div class="bracket-container flex flex-row gap-8 p-6 bg-white border border-gray-100 shadow-sm rounded-xl overflow-x-auto">
                @forelse($bracketRounds as $roundNum => $games)
                    <div class="round-column flex flex-col justify-around min-w-[240px]">
                        <h3 class="text-center text-xs font-bold uppercase text-gray-400 mb-3">
                            {{ $games->first()->round_name ?? "Round $roundNum" }}
                        </h3>
                        @foreach($games as $game)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 my-2 shadow-2xl">
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="{{ $game->team1_score > $game->team2_score ? 'font-bold text-indigo-600' : 'text-gray-700' }}">
                                        {{ $game->team1?->name ?? 'TBD' }}
                                    </span>
                                    <span class="font-mono font-bold">{{ $game->team1_score }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="{{ $game->team2_score > $game->team1_score ? 'font-bold text-indigo-600' : 'text-gray-700' }}">
                                        {{ $game->team2?->name ?? 'TBD' }}
                                    </span>
                                    <span class="font-mono font-bold">{{ $game->team2_score }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Bracket structure hasn't been generated yet.</p>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 uppercase tracking-wider">Game Schedules & Match Results</h2>
            <div class="bg-white border border-gray-100 shadow-sm rounded-xl overflow-hidden">
                <table class="min-w-full table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Round</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/2">Matchup</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Score</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/2">Venue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($schedules as $game)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-tight">
                                    {{ $game->round_name ?? "Round $game->round_number" }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="font-bold text-gray-900">
                                        {{ $game->team1?->name ?? 'TBD' }}
                                        <span class="text-xs text-gray-400 font-normal mx-0.5">vs</span>
                                        {{ $game->team2?->name ?? 'TBD' }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-0.5">
                                        {{ $game->match_datetime ? \Carbon\Carbon::parse($game->match_datetime)->format('M d, g:i A') : 'TBD' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($game->status === 'completed')
                                        <span class="inline-block bg-green-50 text-green-700 font-extrabold text-xs px-2 py-0.5 rounded border border-green-100 font-mono">
                                            {{ $game->team1_score }} - {{ $game->team2_score }}
                                        </span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-0.5 rounded uppercase font-mono tracking-tight">
                                            {{ $game->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 truncate">
                                    {{ $game->venue?->name ?? 'Unassigned' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section x-data="{ activeTeam: null }">
    <h2 class="text-xl font-extrabold text-gray-800 mb-2 uppercase tracking-wider">Participating Teams</h2>
    <p class="text-xs text-gray-400 mb-4 font-medium">Click any team card to look up their current registered players roster.</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($teams as $team)
            <div
                @click="activeTeam === {{ $team->id }} ? activeTeam = null : activeTeam = {{ $team->id }}"
                :class="activeTeam === {{ $team->id }} ? 'border-indigo-600 ring-2 ring-indigo-100 bg-indigo-50/30' : 'border-gray-100 bg-white hover:border-indigo-300'"
                class="p-4 border shadow-sm rounded-xl text-center cursor-pointer transition duration-200 select-none transform hover:-translate-y-0.5"
            >
                <div class="font-bold text-base mb-1 text-indigo-600">{{ $team->name }}</div>
                <div class="text-xs text-gray-400">Coach: {{ $team->coach_name ?? '—' }}</div>

                <div class="mt-2 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full inline-block"
                     :class="activeTeam === {{ $team->id }} ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-500'">
                    <span x-text="activeTeam === {{ $team->id }} ? 'Viewing Roster' : 'View Roster'"></span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        @foreach($teams as $team)
            <div
                x-show="activeTeam === {{ $team->id }}"
                x-collapse
                x-cloak
                class="bg-white border border-indigo-100 shadow-md rounded-xl p-6 border-t-4 border-t-indigo-600"
            >
                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900">Roster: {{ $team->name }}</h3>
                        <p class="text-xs text-gray-400">Head Coach: {{ $team->coach_name ?? 'Unassigned' }}</p>
                    </div>
                    <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $team->players->count() }} Total {{ Str::plural('Player', $team->players->count()) }}
                    </span>
                </div>

                @if($team->players->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($team->players as $index => $player)
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="bg-indigo-100 text-indigo-700 font-mono text-xs font-bold h-6 w-6 rounded-full flex items-center justify-center shrink-0">
                                     {{ $player->jersey_number ?? 'N/A' }}
                                </div>
                                <div class="text-sm font-semibold text-gray-800">
                                    {{ $player->first_name }} {{ $player->last_name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-gray-400 text-sm">
                        No players have been registered to this team's roster yet.
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>

    </div>
</body>
</html>
