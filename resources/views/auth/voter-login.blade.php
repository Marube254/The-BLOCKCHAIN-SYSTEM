<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Login | IUEA Voting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">

    <!-- Login Card -->
    <div class="bg-white shadow-2xl rounded-3xl p-10 w-full max-w-md">
        
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="IUEA Logo" class="mx-auto h-20 w-auto">
            <h1 class="mt-4 text-3xl font-bold text-gray-900">IUEA Voting System</h1>
            <p class="text-gray-600 mt-2">Voter Login</p>
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                <!-- Back Arrow Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0L3.586 10l4.707-4.707a1 1 0 111.414 1.414L6.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M13 10a1 1 0 01-1 1H7a1 1 0 110-2h5a1 1 0 011 1z" clip-rule="evenodd"/>
                </svg>
                Back to Welcome
            </a>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('voter.login.submit') }}" class="space-y-6">
            @csrf

            <!-- Voter ID -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Voter ID</label>
                <input type="text" name="voter_id" required
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-maroon-600 focus:ring focus:ring-maroon-200 focus:ring-opacity-50 px-4 py-2 text-gray-900">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Password (optional)</label>
                <input type="password" name="password"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-maroon-600 focus:ring focus:ring-maroon-200 focus:ring-opacity-50 px-4 py-2 text-gray-900">
            </div>

            <!-- Fingerprint -->
            <div>
                <p class="text-sm text-gray-500 mb-2">Or use Fingerprint:</p>
                <input type="hidden" name="fingerprint_data" id="fingerprint_data">
                <button type="button" onclick="captureFingerprint()"
                        class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                    <!-- Fingerprint Icon (solid) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5a1 1 0 10-2 0v2a1 1 0 102 0zm-1 1a1 1 0 011 1v4a1 1 0 11-2 0V9a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Scan Fingerprint
                </button>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                        class="w-full py-3 px-4 bg-maroon-600 hover:bg-maroon-700 text-white font-semibold rounded-lg shadow-md transition transform hover:-translate-y-1">
                    Login
                </button>
            </div>
        </form>

        <!-- Optional Footer -->
        <div class="mt-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} IUEA Voting System. All rights reserved.
        </div>
    </div>

    <script>
        function captureFingerprint() {
            alert('Connect your fingerprint scanner — this will use WebUSB or SDK integration.');
            document.getElementById('fingerprint_data').value = 'sample_fingerprint_hash';
        }
    </script>

    <style>
        .bg-maroon-600 { background-color: #800000; }
        .hover\:bg-maroon-700:hover { background-color: #660000; }
    </style>
</body>
</html>
