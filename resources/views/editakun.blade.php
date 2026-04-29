<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profil</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
input:focus {
    outline: none;
    ring: 2px solid #1C1F4A;
}

/* animasi halus */
.fade-in {
    animation: fadeIn 0.5s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px);}
    to { opacity: 1; transform: translateY(0);}
}
</style>
</head>

<body class="bg-white flex items-center justify-center min-h-screen fade-in">

<div class="w-full max-w-sm md:max-w-xl bg-white rounded-3xl shadow-md p-5 md:p-8">

    <!-- BACK -->
    <div class="fixed top-4 left-4 z-50">
        <button onclick="goBack()" 
            class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-md active:scale-95">
            ←
        </button>
    </div>

    <!-- MENU -->
    <div class="fixed top-4 right-4 z-50">
        <button class="text-2xl">⋮</button>
    </div>

    <!-- TITLE -->
    <h1 class="text-lg md:text-xl font-semibold mb-6">
        Edit Profil
    </h1>

    <!-- FOTO -->
    <div class="flex flex-col items-center mb-6">
        <div class="w-24 h-24 md:w-28 md:h-28 rounded-xl overflow-hidden bg-gray-200">
            <img src="{{ asset('avatar1.png') }}" class="w-full h-full object-cover">
        </div>

        <button class="mt-3 text-sm text-blue-600 font-medium">
            Ganti foto profil
        </button>
    </div>

    <!-- FORM -->
    <form onsubmit="fakeSubmit(event)">
        <div class="flex flex-col gap-4">

            <input type="text" 
                placeholder="Nama lengkap"
                value="Agus"
                class="bg-gray-100 px-4 py-3 rounded-xl">

            <input type="email" 
                placeholder="Email"
                value="agus@gmail.com"
                class="bg-gray-100 px-4 py-3 rounded-xl">

            <input type="text" 
                placeholder="jenis kendaraan"
                class="bg-gray-100 px-4 py-3 rounded-xl">

            <input type="text" 
                placeholder="plat nomor"
                class="bg-gray-100 px-4 py-3 rounded-xl">

            <input type="password" 
                placeholder="Password baru"
                class="bg-gray-100 px-4 py-3 rounded-xl">

            <input type="password" 
                placeholder="Konfirmasi password"
                class="bg-gray-100 px-4 py-3 rounded-xl">

        </div>

        <!-- BUTTON -->
        <div class="flex gap-3 mt-8">

            <button type="button" onclick="goBack()"
                class="flex-1 bg-gray-200 py-3 rounded-xl active:scale-95">
                Cancel
            </button>

            <button id="saveBtn"
                class="flex-1 bg-[#1C1F4A] text-white py-3 rounded-xl active:scale-95">
                Save
            </button>

        </div>
    </form>

</div>

<!-- SUCCESS POPUP -->
<div id="successPopup"
class="fixed inset-0 flex items-center justify-center bg-black/40 opacity-0 pointer-events-none transition">

    <div class="bg-white px-6 py-5 rounded-2xl shadow-xl text-center">
        <p class="font-semibold text-lg">Berhasil disimpan 🎉</p>
    </div>

</div>

<script>
function goBack() {
    window.history.back();
}

// fake submit (biar keliatan real)
function fakeSubmit(e) {
    e.preventDefault();

    const btn = document.getElementById("saveBtn");
    btn.innerText = "Menyimpan...";
    btn.disabled = true;

    setTimeout(() => {
        btn.innerText = "Save";
        btn.disabled = false;

        const popup = document.getElementById("successPopup");
        popup.style.opacity = "1";
        popup.style.pointerEvents = "auto";

        setTimeout(() => {
            popup.style.opacity = "0";
            popup.style.pointerEvents = "none";
        }, 1500);

    }, 1200);
}
</script>

</body>
</html>