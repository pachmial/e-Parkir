<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

    <div class="w-screen h-screen flex items-center justify-center">

        <!-- container utama -->
        <div class="
            relative bg-white 
            w-[320px] h-[700px] rounded-3xl p-5 pt-16
            sm:w-[400px]
            md:w-[600px] md:h-[80vh] md:rounded-2xl
            lg:w-[800px] lg:h-[85vh]
            xl:w-[1000px]
            flex flex-col overflow-hidden
        ">

            <!-- BACK BUTTON -->
            <div class="fixed top-4 left-4 z-50">
                <button onclick="goBack()" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-md">
                    ←
                </button>
            </div>

            <!-- 🔝 TITLE (SUDAH DITURUNKAN) -->
            <h1 class="text-center text-lg md:text-2xl font-bold mb-6">
                Riwayat Booking
            </h1>

            <!-- 📋 LIST -->
            <div class="flex flex-col gap-4 overflow-y-auto pr-2">

                <!-- CARD -->
                <div onclick="goToDetail()"
                   class="bg-gray-50 p-4 rounded-2xl shadow-sm relative cursor-pointer hover:scale-[1.01] transition">
                    <img src="{{ asset('riwayat.png') }}" 
                        class="absolute top-3 right-3 w-20 h-20 rounded-lg object-cover">

                    <p class="text-sm text-gray-500">Parkir Mall BTM</p>
                    <h2 class="text-xl font-bold mt-1">A-012</h2>
                    <p class="text-sm text-gray-500 mt-1">11:00 - 13:00 (2 jam)</p>
                    <p class="text-right font-semibold mt-2">Rp6.600</p>
                </div>

                <div onclick="goToDetail()"
                    class="bg-gray-50 p-4 rounded-2xl shadow-sm relative cursor-pointer hover:scale-[1.01] transition">
                    <img src="{{ asset('riwayat.png') }}" 
                        class="absolute top-3 right-3 w-20 h-20 rounded-lg object-cover">

                    <p class="text-sm text-gray-500">Parkir Mall BTM</p>
                    <h2 class="text-xl font-bold mt-1">A-012</h2>
                    <p class="text-sm text-gray-500 mt-1">11:00 - 13:00 (2 jam)</p>
                    <p class="text-right font-semibold mt-2">Rp6.600</p>
                </div>

                <div onclick="goToDetail()"
                    class="bg-gray-50 p-4 rounded-2xl shadow-sm relative cursor-pointer hover:scale-[1.01] transition">
                    <img src="{{ asset('riwayat.png') }}" 
                        class="absolute top-3 right-3 w-20 h-20 rounded-lg object-cover">

                    <p class="text-sm text-gray-500">Parkir Mall BTM</p>
                    <h2 class="text-xl font-bold mt-1">A-012</h2>
                    <p class="text-sm text-gray-500 mt-1">11:00 - 13:00 (2 jam)</p>
                    <p class="text-right font-semibold mt-2">Rp6.600</p>
                </div>

            </div>

        </div>

    </div>

<script>
function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        window.location.href = "/beranda";
    }
}

function goToDetail() {
    window.location.href = "/tiket";
}
</script>

</body>
</html>