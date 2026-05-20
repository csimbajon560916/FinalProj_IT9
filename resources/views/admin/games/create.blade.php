<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule a New Game') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.games.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="tournament_id" :value="__('Tournament')" />
                        <select name="tournament_id" id="tournament_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($tournaments as $tournament)
                                <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="team1_id" :value="__('Home Team')" />
                            <select name="team1_id" id="team1_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- TBD (Winner from previous round) --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="team2_id" :value="__('Away Team')" />
                            <select name="team2_id" id="team2_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- TBD (Winner from previous round) --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="match_datetime" :value="__('Match Date & Time')" />
                            <x-text-input id="match_datetime" class="block mt-1 w-full" type="datetime-local" name="match_datetime" required />
                        </div>
                        <div>
                            <x-input-label for="venue_id" :value="__('Venue')" />
                            <select name="venue_id" id="venue_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Venue</option>
                                @foreach($venues as $venue)
                                    <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="round_name" :value="__('Round Name (e.g. Semi-Finals, Week 1)')" />
                        <x-text-input id="round_name" name="round_name" type="text" class="block mt-1 w-full" placeholder="Elimination Round" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="round_number" :value="__('Tree Position (Round Number)')" />
                        <select name="round_number" id="round_number" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="1">1 (Far Left / First Round)</option>
                            <option value="2">2 (Quarter Finals)</option>
                            <option value="3">3 (Semi-Finals)</option>
                            <option value="4">4 (Finals)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">This determines which column the match appears in on the bracket tree.</p>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.games.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>
                            {{ __('Schedule Game') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
document.getElementById('tournament_id').addEventListener('change', function() {
    const tournamentId = this.value;
    const teamA = document.getElementById('team1_id');
    const teamB = document.getElementById('team2_id');

    // Clear the current options
    teamA.innerHTML = '<option value="">Loading...</option>';
    teamB.innerHTML = '<option value="">Loading...</option>';

    if (!tournamentId) {
        teamA.innerHTML = '<option value="">Select Tournament First</option>';
        teamB.innerHTML = '<option value="">Select Tournament First</option>';
        return;
    }

    // Fetch the filtered teams
    fetch(`/admin/get-teams/${tournamentId}`)
        .then(response => response.json())
        .then(data => {
            let options = '<option value="">Select Team</option>';
            data.forEach(team => {
                options += `<option value="${team.id}">${team.name}</option>`;
            });
            teamA.innerHTML = options;
            teamB.innerHTML = options;
        });
});
</script>
</x-app-layout>