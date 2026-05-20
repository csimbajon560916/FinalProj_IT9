<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Leagues & Tournaments</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8 text-center">🏆 Live Tournament Center</h1>

        <div class="grid md:grid-cols-2 gap-6">
            @foreach($tournaments as $tournament)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $tournament->name }}</h2>
                        <p class="text-sm text-gray-500">Click below to see the live schedules, team rosters, and bracket pairings.</p>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('public.tournaments.show', $tournament->id) }}" class="inline-block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition text-sm">
                            View Tournament Dashboard
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
