<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Parkir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center">

    <div class="w-full max-w-sm min-h-screen bg-white relative overflow-hidden">

        <!-- 🗺️ BACKGROUND MAP -->
        <div class="h-52 bg-cover bg-center relative" 
     style="background-image: url('{{ asset('map.jpeg') }}')">
     <div class="absolute inset-0 bg-black/20"></div>
            <!-- tombol back -->
            <div class="absolute top-4 left-4 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow">
                ←
            </div>

            <!-- title kecil -->
            <p class="absolute top-4 left-14 text-white font-semibold">
                Lokasi Parkir
            </p>
        </div>

        <!-- 📄 PANEL -->
        <div class="bg-white rounded-t-3xl p-4 -mt-6 relative z-10">

            <!-- judul -->
            <h1 class="text-lg font-bold mb-1">Pilih tempat Parkir</h1>
            <p class="text-sm text-gray-500 mb-4">
                Zone A - Parkir Mall BTM
            </p>

            <!-- 🚗 GRID SLOT -->
            <div class="grid grid-cols-3 gap-3">

                <!-- contoh unavailable -->
                <div class="bg-gray-300 text-gray-500 py-4 rounded-lg text-center">A-001</div>
                <div class="bg-gray-300 text-gray-500 py-4 rounded-lg text-center">A-002</div>
                <div class="bg-gray-300 text-gray-500 py-4 rounded-lg text-center">A-003</div>

                <!-- available -->
                <div class="bg-white border border-gray-300 py-4 rounded-lg text-center">A-004</div>
                <div class="bg-white border border-gray-300 py-4 rounded-lg text-center">A-005</div>

                <!-- unavailable -->
                <div class="bg-gray-300 text-gray-500 py-4 rounded-lg text-center">A-006</div>

                <!-- available -->
                <div class="bg-white border border-gray-300 py-4 rounded-lg text-center">A-007</div>

                <!-- unavailable -->
                <div class="bg-gray-300 text-gray-500 py-4 rounded-lg text-center">A-008</div>

                <!-- available -->
                <div class="bg-white border border-gray-300 py-4 rounded-lg text-center">A-009</div>

                <!-- unavailable -->
                <div class="bg-gray-300 text-gray-500 py-4 rounded-lg text-center">A-010</div>
                <div class="bg-gray-300 text-gray-500 py-4 rounded-lg text-center">A-011</div>

                <!-- available -->
                <div class="bg-white border border-gray-300 py-4 rounded-lg text-center">A-012</div>

            </div>

            <!-- next kecil -->
            <p class="text-right text-sm text-gray-500 mt-3">
                Selanjutnya >
            </p>

        </div>

        <!-- 🔘 BUTTON BAWAH -->
        <div class="absolute bottom-0 left-0 w-full p-4 bg-white">
            <button class="w-full py-3 rounded-xl text-white font-semibold bg-[#1C1F4A]">
                Selanjutnya
            </button>
        </div>

    </div>

</body>
</html>