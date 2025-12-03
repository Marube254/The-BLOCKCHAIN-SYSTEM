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

        <!-- Logo + Title -->
        <div class="mb-12">
            <img src="{{ asset('images/logo.png') }}" alt="IUEA Logo" class="mx-auto h-24 w-auto">

            <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">
                IUEA Voting System
            </h1>

            <p class="mt-4 text-lg text-gray-600">
                Secure access for system administrators
            </p>
        </div>

        <!-- Admin Login Button -->
        <div>
            <a href="{{ url('/admin/login') }}"
               class="flex items-center justify-center gap-3 px-10 py-4
                      bg-gray-900 hover:bg-gray-800 text-white font-semibold
                      rounded-xl shadow-lg transition-all transform hover:-translate-y-1">

                <!-- Lock Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     viewBox="0 0 24 24"
                     fill="currentColor">
                    <path d="M12 1a5 5 0 00-5 5v4H6a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2v-9a2 2 0 00-2-2h-1V6a5 5 0 00-5-5zm-3 9V6a3 3 0 016 0v4H9z"/>
                </svg>

                Admin Access
            </a>
        </div>
    </div>

</body>
</html>
