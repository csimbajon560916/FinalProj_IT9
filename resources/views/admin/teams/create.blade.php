<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register a New Team') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('admin.teams.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Team Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="tournament_id" :value="__('Assign to Tournament')" />
                        <select name="tournament_id" id="tournament_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($tournaments as $tournament)
                                <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="coach_name" :value="__('Coach Name')" />
                        <x-text-input id="coach_name" class="block mt-1 w-full" type="text" name="coach_name" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                         <a href="{{ route('admin.teams.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>
                            {{ __('Register Team') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
