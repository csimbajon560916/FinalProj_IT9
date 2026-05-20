<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Player Info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.players.update', $player->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" 
                                :value="old('first_name', $player->first_name)" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" 
                                :value="old('last_name', $player->last_name)" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tournament_id" :value="__('Tournament')" />
                            <select name="tournament_id" id="tournament_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($tournaments as $tournament)
                                    <option value="{{ $tournament->id }}" {{ $player->team->tournament_id == $tournament->id ? 'selected' : '' }}>
                                        {{ $tournament->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="team_id" :value="__('Team')" />
                            <select name="team_id" id="team_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $player->team_id == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t pt-4">
                            <a href="{{ route('admin.players.index') }}" class="text-sm text-gray-600 hover:underline">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('UPDATE PLAYER INFO') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>