<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md text-center">
        <h1 class="text-3xl font-bold mb-4">Thank You!</h1>
        <p class="mb-6">Your vote has been successfully submitted.</p>
        <a href="{{ route('voting.start') }}"
           class="px-6 py-3 bg-maroon-600 hover:bg-maroon-700 text-white font-semibold rounded-xl transition">
            Back to Home
        </a>
    </div>

    <style>
        .bg-maroon-600 { background-color: #800000; }
        .hover\:bg-maroon-700:hover { background-color: #660000; }
    </style>

</body>
</html>
