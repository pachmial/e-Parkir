<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

    <div class="w-screen h-screen flex flex-col md:flex-row overflow-hidden">

    <!-- mobil -->
    <div class="w-full md:w-1/2 h-[45%] md:h-full relative flex items-center overflow-hidden">

        <!-- shadow -->
        <div class="absolute bottom-6 md:bottom-[120px] w-[220px] md:w-[700px] h-[120px] md:h-[400px] bg-gray-300 opacity-30 rounded-full blur-2xl"></div>

        <!-- mobil -->
        <img 
        src="{{ asset('car.png') }}" 
        class="absolute left-[-40px] md:left-[-40px] w-[200px] md:w-[350px] rotate-90">
        </div>

    <!-- content -->
    <div class="w-full md:w-1/2 h-[55%] md:h-full flex flex-col justify-between md:justify-center px-5 md:px-24 pb-6 md:pb-0">

        <!-- atas -->
        <div>
            <div class="flex items-center gap-2 text-xs md:text-sm text-gray-600 mb-2">
                <img src="{{ asset('logo.png') }}" class="w-5 h-4 md:w-6 md:h-5">
                <p>Car Parking</p>
            </div>

            <h1 class="md:text-6xl text-4xl font-bold text-gray-800 leading-snug">
                Cepat dan simple saat mengatur kendaraan Mu 💪
            </h1>
        </div>

       <div class="flex gap-3 mt-6 md:mt-10">
    <a href="{{ url('/halaman3') }}" class="flex-1 bg-gray-200 text-gray-700 py-5 md:py-3 rounded-lg text-sm flex items-center justify-center">
        Skip
    </a>

    <a href="{{ url('/halaman2') }}" class="flex-1 bg-black text-white py-5 md:py-3 rounded-lg text-sm flex items-center justify-center">
        Next
    </a>
</div>

    </div>
</div>