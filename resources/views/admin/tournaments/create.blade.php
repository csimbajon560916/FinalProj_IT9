<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Tournament') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.tournaments.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Tournament Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="start_date" :value="__('Start Date')" />
                        <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="location" :value="__('Main Location (City/State)')" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.tournaments.index') }}" class="text-sm text-gray-600 underline hover:text-gray-900 mr-4">Cancel</a>
                        <x-primary-button>
                            {{ __('Save Tournament') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>