<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center">

    <div class="bg-white w-[320px] h-[700px] rounded-3xl p-5 flex flex-col">

        <!-- 🔝 HEADER -->
        <div class="flex items-center gap-3 mb-6">
            <!-- tombol back -->
            <div class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full">
                ←
            </div>

            <!-- title -->
            <h1 class="text-lg font-bold">Riwayat Booking</h1>
        </div>

        <!-- 📋 LIST CARD -->
        <div class="flex flex-col gap-4">

            <!-- CARD 1 -->
            <div class="bg-gray-50 p-4 rounded-2xl shadow-sm relative">

                <!-- map icon -->
                <img src="{{ asset('riwayat.png') }}" 
                     class="absolute top-3 right-3 w-20 h-20 rounded-lg object-cover">

                <!-- lokasi -->
                <p class="text-sm text-gray-500">Parkir Mall BTM</p>

                <!-- kode -->
                <h2 class="text-xl font-bold mt-1">A-012</h2>

                <!-- waktu -->
                <p class="text-sm text-gray-500 mt-1">
                    11:00 - 13:00 (2 jam)
                </p>

                <!-- harga -->
                <p class="text-right font-semibold mt-2">
                    Rp6.600
                </p>
            </div>

            <!-- CARD 2 -->
            <div class="bg-gray-50 p-4 rounded-2xl shadow-sm relative">
                <img src="{{ asset('riwayat.png') }}" 
                     class="absolute top-3 right-3 w-20 h-20 rounded-lg object-cover">

                <p class="text-sm text-gray-500">Parkir Mall BTM</p>
                <h2 class="text-xl font-bold mt-1">A-012</h2>
                <p class="text-sm text-gray-500 mt-1">11:00 - 13:00 (2 jam)</p>
                <p class="text-right font-semibold mt-2">Rp6.600</p>
            </div>

            <!-- CARD 3 -->
            <div class="bg-gray-50 p-4 rounded-2xl shadow-sm relative">
                <img src="{{ asset('riwayat.png') }}" 
                     class="absolute top-3 right-3 w-20 h-20 rounded-lg object-cover">

                <p class="text-sm text-gray-500">Parkir Mall BTM</p>
                <h2 class="text-xl font-bold mt-1">A-012</h2>
                <p class="text-sm text-gray-500 mt-1">11:00 - 13:00 (2 jam)</p>
                <p class="text-right font-semibold mt-2">Rp6.600</p>
            </div>

        </div>

    </div>

</body>
</html>