<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-[320px] h-[700px] rounded-3xl flex flex-col justify-between relative overflow-hidden">

        <!-- background circle -->
        <div class="absolute top-[-80px] left-1/2 -translate-x-1/2 w-[400px] h-[450px] bg-gray-300 opacity-40 rounded-full"></div>
    
        <!-- 🚗 BAGIAN ATAS (mobil + jalan) -->
            <!-- garis kiri -->
            <div class="absolute left-14 top-20 -translate-y- h-32 border-l-2 border-dashed border-gray-400"></div>

            <!-- garis kanan -->
            <div class="absolute right-14 top-20 -translate-y- h-32 border-l-2 border-dashed border-gray-400"></div>

        <!-- image -->
         <div class="relative h-60 flex items-center justify-center">
            <img 
                src="{{ asset('car.png') }}" 
                class="absolute top-14 w-72 rotate-180">
        </div>
        <!-- content -->
        <div class="p-4">
        <div class="relative px-2">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <img src="{{ asset('logo.png') }}" class="w-6 h-5">
                    <p>Car Parking</p>
            </div>

            <h1 class="text-xl font-bold text-gray-800 leading-snug">
                Pengalaman parkir yang luar biasa 🧤
            </h1>
        </div>
        </div>

        <!-- button -->
        <div class="p-6">
        <div class="flex gap-2">
            <button class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg">
                Skip
            </button>

            <button class="flex-1 bg-[black] text-white py-2 rounded-lg">
                Next
            </button>
         </div>
        </div>
    </div>


</body>
</html>