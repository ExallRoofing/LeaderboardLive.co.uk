<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Join weekly golf competitions from your local club and compete nationally. Powered by LeaderboardLive."/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LeaderboardLive - Compete Nationally from Your Local Club</title>

    <!-- Fonts/CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/prelaunch.css', 'resources/js/app.js', 'resources/js/subscribe.js'])
</head>

<body class="bg-image text-white">

<!-- Top and Bottom Gradient Overlays -->
<div class="top-fade"></div>
<div class="bottom-darken"></div>

<!-- Content Layer -->
<div class="min-h-screen w-full flex flex-col justify-between content-wrapper overflow-hidden">

    <!-- Logo -->
    <div class="w-full h-1/4 flex justify-center items-start mt-28 sm:mt-40">
        <img src="/images/logo.png" alt="LeaderboardLive Logo" class="h-40 sm:h-48">
    </div>

    <!-- Hero Section -->
    <div class="flex-grow flex flex-col items-center justify-center px-4 text-center">
        <h1 class="text-3xl sm:text-4xl font-bold mb-4 text-white drop-shadow-lg">
            Play Locally, Compete Nationally.
        </h1>
        <p class="text-lg sm:text-xl mb-6 text-white drop-shadow-lg">
            Launching at clubs across the UK in July 2025.
        </p>

        <form id="subscribeForm" class="flex flex-col sm:flex-row gap-4 items-center justify-center max-w-md w-full">
            <div class="bg-black bg-opacity-40 p-4 rounded-lg backdrop-blur-sm flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
            <input id="emailInput" type="email" placeholder="Your email"
                       class="flex-1 w-full sm:w-auto p-3 rounded-md border border-white bg-white bg-opacity-90 text-black focus:outline-none"
                       required>
                <button class="w-full sm:w-auto min-w-[140px] whitespace-nowrap bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition">
                    Notify Me
                </button>

            </div>
        </form>

        <p id="responseMessage" class="text-sm text-white mt-4 text-center w-full"></p>
    </div>
    <!-- Footer -->
    <div class="text-center py-4">
        <p class="text-sm text-white text-opacity-90">
            &copy; 2025 LeaderboardLive.co.uk
        </p>
    </div>
</div>
</body>
</html>
