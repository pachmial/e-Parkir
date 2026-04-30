<div>

<!-- OVERLAY -->
<div id="overlay"
    onclick="closeSidebar()"
    class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition duration-300 z-40">
</div>

<!-- SIDEBAR -->
<div id="sidebar"
    class="fixed top-0 right-0 h-full w-[280px] bg-white shadow-xl
    transform translate-x-full transition duration-300 flex flex-col justify-between z-50">


    <!-- MENU -->
    <div class="px-5 flex flex-col">

    <h2 class="font-semibold text-lg mb-6">Menu</h2>

    <div class="flex flex-col gap-5">

        <a href="/akun" class="menu-item">Akun Anda</a>
        <a href="/tiket" class="menu-item">Detail Tiket</a>
        <a href="/riwayat" class="menu-item">Riwayat Parkir</a>

    </div>

</div>
    <!-- LOGOUT -->
    <div class="p-5 border-t">
        <a href="/logout" class="text-red-500 font-semibold">
            Logout
        </a>
    </div>

</div>

<style>
.menu-item {
    padding: 10px;
    border-radius: 10px;
    transition: 0.2s;
}
.menu-item:hover {
    background: #f3f4f6;
}
.active {
    background: #e5e7eb;
    font-weight: 600;
}
</style>

<script>
function openSidebar() {
    document.getElementById("sidebar").classList.remove("translate-x-full");
    document.getElementById("overlay").classList.remove("opacity-0","pointer-events-none");
}

function closeSidebar() {
    document.getElementById("sidebar").classList.add("translate-x-full");
    document.getElementById("overlay").classList.add("opacity-0","pointer-events-none");
}
</script>

</div>