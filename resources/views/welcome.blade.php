<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IUEA Voting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Hero Section -->
    <div class="min-h-screen flex flex-col justify-center items-center px-6 text-center">
        
        <!-- Logo & Title -->
        <div class="mb-12">
            <img src="{{ asset('images/logo.png') }}" alt="IUEA Logo" class="mx-auto h-20 w-auto">
            <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-gray-900">IUEA Voting System</h1>
            <p class="mt-2 text-lg text-gray-600">Choose your login type to access your dashboard</p>
        </div>

        <!-- Login Options -->
        <div class="flex flex-col sm:flex-row gap-6 sm:gap-10">
            <!-- Voter Login -->
            <a href="{{ url('/voter/login') }}"
               class="flex items-center justify-center gap-2 px-8 py-4 bg-maroon-600 hover:bg-maroon-700 text-white font-semibold rounded-xl shadow-lg transition transform hover:-translate-y-1">
                <!-- Fingerprint Icon (solid) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3 1.343 3 3 3 3-1.343 3-3zM9 8a3 3 0 116 0 3 3 0 01-6 0z" clip-rule="evenodd" />
                    <path d="M12 13v.001M12 15v5M12 20v1M12 21v1" />
                </svg>
                Login as Voter
            </a>

            <!-- Admin Login -->
            <a href="{{ url('/admin/login') }}"
               class="flex items-center justify-center gap-2 px-8 py-4 bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-xl shadow-lg transition transform hover:-translate-y-1">
                <!-- Key Icon (solid) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 8a6 6 0 11-12 0 6 6 0 0112 0zM6 8a6 6 0 1112 0 6 6 0 01-12 0z" />
                    <path fill-rule="evenodd" d="M4.5 13a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v3h2v-1.25a.75.75 0 01.75-.75h2v2.5h-6.5a2 2 0 01-2-2v-1z" clip-rule="evenodd" />
                </svg>
                Login as Admin
            </a>
        </div>
    </div>

    <!-- Custom Colors -->
    <style>
        .bg-maroon-600 { background-color: #800000; }
        .hover\:bg-maroon-700:hover { background-color: #660000; }
    </style>

</body>
</html>
