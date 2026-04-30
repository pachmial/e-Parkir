<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan Akun</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white flex items-center justify-center min-h-screen">

<div class="w-full max-w-sm md:max-w-xl bg-white rounded-3xl shadow-md p-5 md:p-8">

    <!-- BACK -->
    <div class="fixed top-4 left-4 z-50">
        <button onclick="goBack()" class="w-10 h-10 bg-white rounded-xl shadow-md">←</button>
    </div>

    <!-- HEADER -->
    <h1 class="font-semibold text-lg md:text-xl mb-6">Pengaturan Akun</h1>

    <!-- FOTO -->
    <div class="flex flex-col items-center mb-6">
        <div class="w-24 h-24 rounded-xl overflow-hidden">
            <img src="{{ asset('avatar1.png') }}" class="w-full h-full object-cover">
        </div>
        <p class="mt-3 text-sm text-gray-600">Lengkapi Profil anda</p>
    </div>

    <!-- DATA USER -->
    <div class="flex flex-col gap-3 mb-5">
        <input type="text" value="{{ $user->nama }}" readonly class="bg-gray-100 p-3 rounded-xl">
        <input type="email" value="{{ $user->email }}" readonly class="bg-gray-100 p-3 rounded-xl">
        <input type="password" value="********" readonly class="bg-gray-100 p-3 rounded-xl">
    </div>

    <!-- NOTIF -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM KENDARAAN -->
   <form action="/save-kendaraan" method="POST">
        @csrf

        <p class="text-sm text-blue-600 mb-2">Lengkapi Data Kendaraan</p>

        <select name="jenis_kendaraan" class="bg-gray-100 p-3 rounded-xl w-full mb-2">
            <option disabled {{ !$kendaraan ? 'selected' : '' }}>Jenis Kendaraan</option>

            <option value="motor" {{ ($kendaraan->jenis ?? '') == 'motor' ? 'selected' : '' }}>Motor</option>
            <option value="mobil" {{ ($kendaraan->jenis ?? '') == 'mobil' ? 'selected' : '' }}>Mobil</option>
            <option value="truck" {{ ($kendaraan->jenis ?? '') == 'truck' ? 'selected' : '' }}>Truck</option>
            <option value="bus"   {{ ($kendaraan->jenis ?? '') == 'bus'   ? 'selected' : '' }}>Bus</option>
        </select>

        <input type="text" name="plat_nomor"
            value="{{ $kendaraan->plat_nomor ?? '' }}"
            placeholder="Plat Nomor Kendaraan"
            class="bg-gray-100 p-3 rounded-xl w-full mb-4">

        <!-- BUTTON -->
        <div class="flex gap-3">
            <button type="button" onclick="resetForm()"
                class="flex-1 bg-gray-200 py-3 rounded-xl">
                Cancel
            </button>

            <button type="submit"
                class="flex-1 bg-[#1C1F4A] text-white py-3 rounded-xl">
                Save
            </button>
        </div>

    </form>

</div>

<script>

function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        window.location.href = "/beranda";
    }
}

function openSidebar() {
    document.getElementById("sidebar").style.transform = "translateX(0)";
    document.getElementById("overlay").style.opacity = "1";
    document.getElementById("overlay").style.pointerEvents = "auto";
}

function closeSidebar() {
    document.getElementById("sidebar").style.transform = "translateX(100%)";
    document.getElementById("overlay").style.opacity = "0";
    document.getElementById("overlay").style.pointerEvents = "none";
}
function resetForm() {
    document.querySelectorAll('input').forEach(input => input.value = '');
    document.querySelector('select').value = '';
}
</script>

</body>
</html>