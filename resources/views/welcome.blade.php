<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Join weekly golf competitions from your local club and compete nationally. Powered by LeaderboardLive."/>
    <title>LeaderboardLive - Compete Nationally from Your Local Club</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Rajdhani', sans-serif;
            overflow: hidden;
            touch-action: none;
        }
        body{
            overflow: hidden;
            position: relative;
        }

        .bg-image {
            position: relative;
            background-image: url('/images/hero-image.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .top-fade {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 40vh;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0));
            z-index: 1;
            pointer-events: none;
        }

        .bottom-darken {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60vh;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0));
            z-index: 1;
            pointer-events: none;
        }

        .content-wrapper {
            position: relative;
            z-index: 2;
        }
        .top-fade,
        .bottom-darken {
            pointer-events: none;
            overflow: hidden;
        }
    </style>
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
        <h1 class="text-3xl sm:text-5xl font-bold mb-4 text-white drop-shadow-lg">
            Play Locally, Compete Nationally.
        </h1>
        <p class="text-lg sm:text-xl mb-6 text-white drop-shadow-lg">
            Launching at clubs across the UK in July 2025.
        </p>

        <form class="flex flex-col sm:flex-row gap-4 items-center justify-center max-w-md w-full">
            <div class="bg-black bg-opacity-40 p-4 rounded-lg backdrop-blur-sm inline-flex items-center gap-2">
                <input type="email" placeholder="Your email" class="flex-1 p-3 rounded-md border border-white bg-white bg-opacity-90 text-black focus:outline-none" required>
                <button class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition">
                    Notify Me
                </button>
            </div>
        </form>
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
