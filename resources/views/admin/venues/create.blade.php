<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add New Venue') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.venues.store') }}">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Venue Name')" />
                        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" placeholder="e.g. Central Gym" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="address" :value="__('Address/Location')" />
                        <x-text-input id="address" name="address" type="text" class="block mt-1 w-full" placeholder="e.g. 123 Sports Way" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>Save Venue</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>