<x-app-layout>
    <style>
        /* This wrapper allows horizontal scrolling if the bracket is wide */
        .bracket-wrapper { 
            display: flex; 
            gap: 40px; 
            padding: 50px; 
            overflow-x: auto; 
            background-color: #f8fafc;
            align-items: center; /* This helps center the final match vertically */
        }
        
        /* Each round becomes its own vertical column */
        .round-column { 
            display: flex; 
            flex-direction: column; 
            justify-content: space-around; 
            min-width: 240px; 
            min-height: 500px;
        }

        .match-box { 
            position: relative; 
            background: white; 
            border: 1px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 16px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin: 15px 0;
        }

        /* Connector Lines - Points to the next match */
        .match-box::after {
            content: ""; 
            position: absolute; 
            right: -42px; 
            top: 50%;
            width: 40px; 
            height: 2px; 
            background: #cbd5e0;
        }
        .round-column:last-child .match-box::after { display: none; }
    </style>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bracket-wrapper">
                    @php
                        // Group games by round_number (1, 2, 3...)
                        // This forces Round 1 to the left, Round 2 next, etc.
                        $rounds = $tournament->games->groupBy('round_number')->sortKeys();
                    @endphp

                    @forelse($rounds as $roundNum => $games)
                        <div class="round-column">
                            <h3 class="text-center text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                                {{ $games->first()->round_name ?? "Round $roundNum" }}
                            </h3>
                            
                            @foreach($games as $game)
                                <div class="match-box">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-sm {{ $game->team1_score > $game->team2_score ? 'font-bold text-indigo-600' : 'text-gray-600' }}">
                                            {{ $game->team1?->name ?? 'TBD' }}
                                        </span>
                                        <span class="text-xs font-mono font-bold bg-gray-50 px-2 py-1 rounded">
                                            {{ $game->team1_score }}
                                        </span>
                                    </div>

                                    <div class="border-t border-gray-100 my-2"></div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-sm {{ $game->team2_score > $game->team1_score ? 'font-bold text-indigo-600' : 'text-gray-600' }}">
                                            {{ $game->team2?->name ?? 'TBD' }}
                                        </span>
                                        <span class="text-xs font-mono font-bold bg-gray-50 px-2 py-1 rounded">
                                            {{ $game->team2_score }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-4 pt-2 border-t border-gray-50 flex justify-between items-center">
                                        <span class="text-[10px] uppercase font-semibold text-gray-300">
                                            {{ $game->status }}
                                        </span>
                                        <a href="{{ route('admin.games.edit', $game->id) }}" class="text-[10px] text-indigo-500 hover:underline font-bold uppercase">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="w-full text-center py-20 text-gray-400">
                            No matches created. Start by scheduling games for Round 1!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>