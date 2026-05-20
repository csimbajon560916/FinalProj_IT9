<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Match Score</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.games.update', $game->id) }}">
    @csrf @method('PATCH')

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label>{{ $game->team1?->name }} Score</label>
            <x-text-input name="team1_score" type="number" value="{{ $game->team1_score }}" class="w-full text-center" />
        </div>
        <div>
            <label>{{ $game->team2?->name }} Score</label>
            <x-text-input name="team2_score" type="number" value="{{ $game->team2_score }}" class="w-full text-center" />
        </div>
    </div>

    <div class="mb-6">
        <x-input-label for="status" value="Game Status" />
        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
            <option value="scheduled" {{ $game->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="ongoing" {{ $game->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="completed" {{ $game->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $game->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>

    <div class="mt-4">
    <x-input-label for="next_game_id" :value="__('Winner Advances To (Next Match)')" />
    <select name="next_game_id" id="next_game_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
        <option value="">-- No Next Round (Finals) --</option>
        @foreach($tournament->games as $futureGame)
            {{-- Prevents a game from pointing to itself --}}
            @if($futureGame->id !== $game->id)
                <option value="{{ $futureGame->id }}" {{ $game->next_game_id == $futureGame->id ? 'selected' : '' }}>
                    {{ $futureGame->round_name }}: #{{ $futureGame->id }}
                    ({{ $futureGame->teamA->name ?? 'TBD' }} vs {{ $futureGame->teamB->name ?? 'TBD' }})
                </option>
            @endif
        @endforeach
    </select>
    <p class="text-xs text-gray-500 mt-1">Select the match in the next round where the winner of this game should go.</p>
</div>

     <a href="{{ route('admin.games.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
    <x-primary-button>Update Game Details</x-primary-button>
</form>
            </div>
        </div>
    </div>
</x-app-layout>
