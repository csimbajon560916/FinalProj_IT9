<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Current Standings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Use @forelse to handle cases where there is no data yet --}}
            @forelse($standings->groupBy('tournament_id') as $tournamentId => $group)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4 text-blue-600">
                        {{-- Safely get the tournament name from the first item in the group --}}
                        {{ $group->first()->tournament->name ?? 'Unknown Tournament' }}
                    </h3>
                    
                    <table class="min-w-full text-center border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Team</th>
                                <th class="px-4 py-2">P</th>
                                <th class="px-4 py-2">W</th>
                                <th class="px-4 py-2">D</th>
                                <th class="px-4 py-2">L</th>
                                <th class="px-4 py-2 font-bold">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group as $standing)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-4 py-2 text-left font-medium">{{ $standing->team->name ?? 'Deleted Team' }}</td>
                                <td class="px-4 py-2">{{ $standing->played }}</td>
                                <td class="px-4 py-2 text-green-600">{{ $standing->won }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $standing->draws }}</td>
                                <td class="px-4 py-2 text-red-600">{{ $standing->lost }}</td>
                                <td class="px-4 py-2 font-bold">{{ $standing->points }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                {{-- This displays if $standings is empty --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500 text-lg italic">
                        No standings data available. 
                        <br>
                        <span class="text-sm text-gray-400">Make sure you have created Tournaments, added Teams, and recorded Game scores.</span>
                    </p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>