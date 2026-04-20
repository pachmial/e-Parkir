<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

    <div class="
        bg-white 
        w-[360px] h-[640px] rounded-3xl 
        md:w-screen md:h-screen md:rounded-none 
        flex flex-col md:flex-row 
        overflow-hidden relative
    ">

        <!-- background atas -->
        <div class="absolute top-0 left-0 w-full h-44 md:h-64 bg-gray-200 opacity-40 
        [clip-path:polygon(0_0,100%_0,100%_60%,75%_100%,50%_75%,25%_100%,0_60%)]">
        </div>

        <!-- kiri / atas -->
        <div class="w-full md:w-1/2 h-[48%] md:h-full relative flex items-center justify-center">

            <!-- garis -->
            <div class="absolute left-12 md:left-40 h-44 md:h-96 border-l-2 border-dashed border-gray-300"></div>
            <div class="absolute right-12 md:right-40 h-44 md:h-96 border-l-2 border-dashed border-gray-300"></div>

            <!-- mobil -->
            <img 
                src="{{ asset('car.png') }}" 
                class="w-[140px] md:w-[250px] object-contain">
        </div>

        <!-- kanan / bawah -->
        <div class="w-full md:w-1/2 h-[52%] md:h-full flex flex-col justify-between md:justify-center px-6 md:px-24 pb-6 md:pb-0">

            <!-- teks -->
            <div>
                <div class="flex items-center gap-2 text-xs md:text-sm text-gray-600 mb-3">
                    <img src="{{ asset('logo.png') }}" class="w-5 h-4 md:w-6 md:h-5">
                    <p>Car Parking</p>
                </div>

                <h1 class="text-[32px] md:text-5xl font-bold text-gray-900 leading-tight">
                    Pengalaman parkir yang luar biasa 🧤
                </h1>
            </div>

            <!-- tombol -->
            <div class="flex gap-3 mt-6 md:mt-10">
            <button class="flex-1 bg-gray-200 text-gray-700 py-3 md:py-3 rounded-lg text-sm">
                Skip
            </button>

            <button class="flex-1 bg-black text-white py-3 md:py-3 rounded-lg text-sm">
                Next
            </button>
        </div>
            {{-- <div class="flex gap-3 mt-6 md:mt-10">

                <!-- skip kecil -->
                <button class="px-5 md:px-6 bg-gray-200 text-gray-700 py-3 rounded-xl text-sm">
                    Skip
                </button>

                <!-- next lebih besar -->
                <button class="flex-1 bg-[#1c1b3a] text-white py-3 rounded-xl text-sm">
                    Next
                </button>

            </div> --}}

        </div>

    </div>

</body>
</html>