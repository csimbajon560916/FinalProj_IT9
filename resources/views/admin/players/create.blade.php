<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Register Player') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.players.store') }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="block mt-1 w-full" required />
                        </div>
                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="block mt-1 w-full" required />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="team_id" :value="__('Assign to Team')" />
                        <select name="team_id" id="team_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Select Team --</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->tournament->name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="jersey_number" :value="__('Jersey #')" />
                        <x-text-input id="jersey_number" name="jersey_number" type="number" class="block mt-1 w-full" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                         <a href="{{ route('admin.players.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>Save Player</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
