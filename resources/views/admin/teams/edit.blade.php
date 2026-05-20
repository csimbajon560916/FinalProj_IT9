<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Team') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.teams.update', $team->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Team Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $team->name)" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tournament_id" :value="__('Tournament')" />
                            <select name="tournament_id" id="tournament_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($tournaments as $tournament)
                                    <option value="{{ $tournament->id }}" {{ $team->tournament_id == $tournament->id ? 'selected' : '' }}>
                                        {{ $tournament->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="coach_name" :value="__('Coach Name')" />
                            <x-text-input id="coach_name" name="coach_name" type="text" class="mt-1 block w-full" :value="old('coach_name', $team->coach_name)" />
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t pt-4">
                            <a href="{{ route('admin.teams.index') }}" class="text-sm text-gray-600 hover:underline">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('UPDATE TEAM INFO') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>