<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tournament') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.tournaments.update', $tournament->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Tournament Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $tournament->name)" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="start_date" :value="__('Start Date')" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', $tournament->start_date)" required />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Active" {{ $tournament->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $tournament->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Completed" {{ $tournament->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t pt-4">
                            <a href="{{ route('admin.tournaments.index') }}" class="text-sm text-gray-600 hover:underline">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('UPDATE TOURNAMENT') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>