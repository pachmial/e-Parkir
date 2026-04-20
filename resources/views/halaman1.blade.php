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

        <!-- atas/kiri (mobil) -->
        <div class="w-full md:w-1/2 h-1/2 md:h-full relative flex items-center justify-center">

            <!-- shadow -->
            <div class="absolute bottom-10 md:bottom-[120px] w-[300px] md:w-[700px] h-[200px] md:h-[400px] bg-gray-300 opacity-30 rounded-full blur-2xl"></div>

            <!-- mobil -->
            <img 
                src="{{ asset('car.png') }}" 
                class="w-[250px] md:w-[650px] -rotate-90 md:absolute md:left-[-150px]">
        </div>

        <!-- bawah/kanan (content) -->
        <div class="w-full md:w-1/2 h-1/2 md:h-full flex flex-col justify-center px-6 md:px-24">

            <!-- header -->
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                <img src="{{ asset('logo.png') }}" class="w-5 h-4 md:w-6 md:h-5">
                <p>Car Parking</p>
            </div>

            <!-- title -->
            <h1 class="text-lg md:text-5xl font-bold text-gray-800 leading-snug mb-6 md:mb-10">
                Cepat dan simple saat mengatur kendaraan Mu 💪
            </h1>

            <!-- button -->
            <div class="flex gap-3 w-full md:w-80">
                <button class="flex-1 bg-gray-200 text-gray-700 py-2 md:py-3 rounded-lg">
                    Skip
                </button>

                <button class="flex-1 bg-black text-white py-2 md:py-3 rounded-lg">
                    Next
                </button>
            </div>

        </div>
    </div>

</body>
</html>