<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tournament Hub') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach($tournaments as $tournament)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-indigo-700">{{ $tournament->name }}</h3>
                                <p class="text-sm text-gray-500">Starts: {{ $tournament->start_date }}</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('admin.games.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Game Schedules
                                </a>
                                <a href="{{ route('admin.tournaments.brackets', $tournament->id) }}" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                                        View Brackets
                                </a>
                            </div>
                        </div>

                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Participating Teams</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($tournament->teams as $team)
                                <button onclick="openTeamDetails('{{ $team->name }}', '{{ $team->coach_name }}', {{ $team->players }})" 
                                    class="flex flex-col items-center p-4 bg-gray-50 rounded-xl border border-transparent hover:border-indigo-300 hover:bg-white transition-all text-left shadow-sm">
                                    <span class="text-lg font-bold text-gray-900">{{ $team->name }}</span>
                                    <span class="text-xs text-indigo-600 font-medium">View Roster</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="teamModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modalTeamName"></h3>
                            <div class="mt-2 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-500 italic">Head Coach: <span id="modalCoach" class="text-gray-900 font-semibold not-italic"></span></p>
                            </div>
                            <div class="mt-4">
                                <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Player Roster</h4>
                                <ul id="playerList" class="divide-y divide-gray-100 max-h-60 overflow-y-auto"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTeamDetails(name, coach, players) {
            document.getElementById('modalTeamName').innerText = name;
            document.getElementById('modalCoach').innerText = coach || 'Not Assigned';
            
            const list = document.getElementById('playerList');
            list.innerHTML = '';
            
            players.forEach(p => {
                const li = document.createElement('li');
                li.className = "py-2 flex justify-between";
                li.innerHTML = `<span class="text-sm font-medium text-gray-700">${p.first_name} ${p.last_name}</span> <span class="text-xs text-gray-400">#${p.jersey_number || '--'}</span>`;
                list.appendChild(li);
            });

            document.getElementById('teamModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('teamModal').classList.add('hidden');
        }
    </script>
</x-app-layout>