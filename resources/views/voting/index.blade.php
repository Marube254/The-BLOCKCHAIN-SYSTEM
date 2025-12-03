<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10">

    <h1 class="text-3xl font-bold mb-2">Hello, {{ $voter->name }}</h1>
    <p class="mb-8 text-gray-700 text-center max-w-xl">Please select one candidate per sector and scan your fingerprint to submit your vote.</p>

    <form action="{{ route('voting.submit') }}" method="POST" class="flex flex-col gap-6 w-full max-w-4xl">
        @csrf

        @foreach($candidates as $sector => $sectorCandidates)
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">{{ $sector }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($sectorCandidates as $candidate)
                        <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:shadow-lg transition">
                            <input type="radio" name="votes[{{ $sector }}]" value="{{ $candidate->id }}" required class="form-radio h-5 w-5 text-maroon-600">
                            <span class="text-gray-900 font-medium">{{ $candidate->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="mt-6">
            <input type="text" name="fingerprint_data" placeholder="Scan fingerprint or enter template"
                   class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-maroon-600 mb-4" required>
            <button type="submit"
                    class="w-full px-6 py-3 bg-maroon-600 hover:bg-maroon-700 text-white font-semibold rounded-xl transition">
                Submit Vote
            </button>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mt-4">
                {{ $errors->first() }}
            </div>
        @endif
    </form>

    <style>
        .bg-maroon-600 { background-color: #800000; }
        .hover\:bg-maroon-700:hover { background-color: #660000; }
        input.form-radio:checked { accent-color: #800000; }
    </style>

</body>
</html>
