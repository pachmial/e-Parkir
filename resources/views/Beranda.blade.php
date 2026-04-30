<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parkir App</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f4f4f6;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px 32px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 36px;
}

.user {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user img {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    object-fit: cover;
}

.menu {
    font-size: 24px;
    cursor: pointer;
}

/* ── TAMBAHAN: Stats bar di bawah header ── */
.stats-bar {
    display: flex;
    gap: 14px;
    margin-bottom: 32px;
}

.stat-pill {
    background: white;
    border-radius: 14px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    flex: 1;
}

.stat-pill-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #f0f0f2;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.stat-pill-icon.dark {
    background: #1e1e2f;
    color: white;
}

.stat-pill-label {
    font-size: 11px;
    color: #aaa;
    margin-bottom: 2px;
}

.stat-pill-value {
    font-size: 14px;
    font-weight: 700;
    color: #1e1e2f;
}

/* CONTENT */
.content {
    display: flex;
    align-items: center;        /* ← diubah: dari flex-start jadi center */
    justify-content: space-between;
    gap: 40px;
}

.left {
    flex: 1;
    min-width: 0;
    max-width: 520px;           /* ← diubah: dari default jadi 520px */
}

.left h1 {
    font-size: 44px;            /* ← diubah: dari 40px jadi 44px */
    color: #1e1e2f;
    line-height: 1.2;
    margin-bottom: 10px;
}

.left h1 span {
    font-weight: 900;
}

.left > p {
    color: #888;
    font-size: 14px;
    margin-bottom: 18px;
    max-width: 420px;           /* ← diubah: dari 380px jadi 420px */
}

/* SEARCH BAR */
.search-bar {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 12px;
    padding: 10px 14px;
    gap: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    margin-bottom: 18px;
    max-width: 100%;            /* ← diubah: dari 380px jadi 100% */
}

.search-bar input {
    border: none;
    outline: none;
    flex: 1;
    font-size: 13px;
    color: #444;
    background: transparent;
}

.search-bar input::placeholder {
    color: #bbb;
}

.search-bar .search-icon {
    color: #1e1e2f;
    font-size: 16px;
}

/* HORIZONTAL SCROLL CARDS */
.parking-scroll-wrapper {
    gap; 10px
    max-width: 100%;            /* ← diubah: dari 400px jadi 100% */
    margin-bottom: 24px;
}

/* ── TAMBAHAN: Label section ── */
.section-label {
    font-size: 11px;
    font-weight: 700;
    color: #aaa;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.parking-scroll {
    display: flex;
    gap: 20px !important;
    overflow-x: auto;
    padding-bottom: 8px;
    scrollbar-width: none;
}

.parking-scroll::-webkit-scrollbar {
    display: none;
}

.p-card {
    min-width: 155px;
    background: white;
    border-radius: 14px;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    cursor: pointer;
    transition: transform 0.2s;
}

.p-card:hover {
    transform: translateY(-3px);
}

.p-card-img {
    width: 100%;
    height: 100px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.p-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.p-card:hover .p-card-img img {
    transform: scale(1.05);
}

.p-card-body {
    padding: 8px 10px 10px;
}

.p-card-name {
    font-size: 12px;
    font-weight: 600;
    color: #1e1e2f;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.p-card-loc {
    font-size: 10px;
    color: #aaa;
    display: flex;
    align-items: center;
    gap: 3px;
    margin-bottom: 6px;
}

.p-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.p-card-price {
    font-size: 11px;
    font-weight: 600;
    color: #444;
}

.p-card-btn {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #1e1e2f;
    color: white;
    border: none;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.p-card-rating {
    font-size: 10px;
    color: #F59E0B;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 2px;
}

/* VEHICLE CARDS */
.vehicle {
    display: flex;
    gap: 14px;
    margin-top: 4px;
}

/* ── TAMBAHAN: Label di atas vehicle ── */
.vehicle-label {
    font-size: 11px;
    font-weight: 700;
    color: #aaa;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 10px;
    margin-top: 4px;
}

.card {
    width: 110px;
    height: 90px;
    border-radius: 15px;
    background: #eee;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: 0.3s;
    font-size: 13px;
    gap: 6px;
}

.card img {
    width: 28px;
    height: 28px;
    transition: 0.3s;
}

.card.active {
    background: #1e1e2f;
    color: white;
}

.card.active img {
    filter: brightness(0) invert(1);
}

.card:hover {
    transform: translateY(-3px);
}

/* RIGHT - PARKING VISUAL */
.right {
    flex: 0 0 auto;             /* ← diubah: tambah flex: 0 0 auto */
    display: flex;
    justify-content: center;
    align-items: center;
}

.parking-area {
    position: relative;
    display: flex;
    align-items: center;
    gap: 20px;
    transform: translateX(-60px); /* ← diubah: dari -120px jadi -60px */
}

.parking-area img {
    width: 230px;
}

.line {
    width: 2px;
    height: 320px;
    border-left: 2px dashed #ccc;
}

.start-btn {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: none;
    background: #1e1e2f;
    color: white;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    z-index: 2;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.start-btn:hover {
    background: #2d2d4a;
}

/* ── TAMBAHAN: Quick info di sebelah kanan bawah ── */
.quick-info {
    position: absolute;
    bottom: -10px;
    right: -20px;
    background: white;
    border-radius: 14px;
    padding: 12px 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    min-width: 140px;
    z-index: 3;
}

.quick-info-title {
    font-size: 10px;
    color: #aaa;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 6px;
}

.quick-info-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 4px;
}

.quick-info-row:last-child {
    margin-bottom: 0;
}

.quick-info-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.quick-info-dot.green { background: #22c55e; }
.quick-info-dot.yellow { background: #f59e0b; }
.quick-info-dot.red { background: #ef4444; }

.quick-info-text {
    font-size: 11px;
    font-weight: 600;
    color: #1e1e2f;
}

.quick-info-sub {
    font-size: 10px;
    color: #aaa;
    margin-left: auto;
}

/* SIDEBAR */
.overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    opacity: 0;
    pointer-events: none;
    transition: 0.3s;
    z-index: 40;
}

.sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 260px;
    height: 100%;
    background: white;
    transform: translateX(100%);
    transition: 0.3s;
    z-index: 50;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.sidebar .menu-list {
    padding: 50px 20px 20px;
}

.sidebar .menu-list h3 {
    margin-bottom: 30px;
    font-size: 18px;
}

.sidebar a {
    display: block;
    padding: 12px;
    border-radius: 10px;
    text-decoration: none;
    color: #333;
    margin-bottom: 8px;
    transition: 0.2s;
}

.sidebar a:hover {
    background: #f3f4f6;
}

.sidebar .logout {
    padding: 20px;
    border-top: 1px solid #eee;
}

.sidebar .logout a {
    color: red;
    font-weight: bold;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .content {
        flex-direction: column;
        align-items: flex-start;
    }

    .left h1 {
        font-size: 28px;
    }

    .parking-scroll-wrapper,
    .search-bar {
        max-width: 100%;
    }

    .parking-area img {
        width: 150px;
    }

    .start-btn {
        width: 110px;
        height: 110px;
        font-size: 13px;
    }

    .right {
        width: 100%;
    }

    /* Sembunyikan quick info di mobile */

    /* ── MOBILE: Parking cards jadi grid 2 kolom ── */
    .parking-scroll-wrapper {
        max-width: 100%;
    }

    .parking-scroll {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        overflow-x: unset;
        gap: 10px;
        padding-bottom: 0;
    }

    .p-card {
        min-width: unset;
        width: 100%;
    }

    .p-card-img {
        height: 80px;
    }

    /* Stats bar mobile - tampilkan 2 kolom */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .stat-pill {
        padding: 10px 14px;
    }


    .quick-info { display: none; }
}

@media (max-width: 768px) {
    .content {
        flex-direction: column;
        position: relative;
    }

    .left {
        display: flex;
        flex-direction: column;
        width: 100%;
        z-index: 3;
        max-width: 100%;
    }

    .left h1 { order: 1; }
    .vehicle-label { order: 2; }
    .vehicle { order: 3; }
    .search-bar { order: 4; }
    .parking-scroll-wrapper { order: 5; }

    .left > p { display: none; }

    .left h1 {
        font-size: 30px;
        margin-bottom: 10px;
    }

    .vehicle { margin-top: 15px; }
    .search-bar { margin-top: 10px; }
    .parking-scroll-wrapper { margin-top: 15px; position: relative; z-index: 2; }

    .right {
        position: absolute;
        left: 50%;
        bottom: -90px;
        transform: translateX(-50%);
        width: 100%;
        display: flex;
        justify-content: center;
        z-index: 1;
        pointer-events: none;
    }

    .parking-area {
        position: relative;
        width: 100%;
        max-width: 300px;
        height: 240px;
        display: flex;
        justify-content: center;
        align-items: flex-end;
        margin: 0 auto;
        transform: none;
    }

    .parking-area img {
        width: 160px;
        max-width: 45vw;
        position: relative;
        bottom: 0;
    }

    .line { height: 220px; }

    .start-btn {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        width: 90px;
        height: 90px;
        font-size: 13px;
        z-index: 3;
    }
}
</style>
</head>

<body>

<!-- OVERLAY -->
<div id="overlay" class="overlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
    <div class="menu-list" style="padding-top:50px">
        <h3 style="margin-bottom:40px;">Menu</h3>
        <div class="flex flex-col gap-5">
            <a href="/akun" class="menu-item">Akun Anda</a>
            <a href="/riwayat" class="menu-item">Riwayat Parkir</a>
        </div>
    </div>
    <div style="padding:20px;border-top:1px solid #eee;">
        <a href="/logout" style="color:red;font-weight:bold;text-decoration:none;">Logout</a>
    </div>
</div>

<div class="container">

@if(session('success'))
    <div style="
        background:#dcfce7;
        color:#16a34a;
        padding:12px 20px;
        border-radius:12px;
        margin-bottom:16px;
        font-size:13px;
        font-weight:600;
        display:flex;
        align-items:center;
        gap:8px;
    ">
        ✅ {{ session('success') }}
    </div>
@endif

    <!-- HEADER -->
    <div class="header">
        <div class="user">
            <img src="{{ asset('avatar1.png') }}">
<span>Hello, {{ optional(Auth::user())->nama }}
</span>        
</div>
        <div class="menu" onclick="openSidebar()">⋮</div>
    </div>

    {{-- ── TAMBAHAN: Stats bar ── --}}
    <div class="stats-bar">
        <div class="stat-pill">
            <div class="stat-pill-icon dark">
                <i class="bi bi-p-square-fill" style="font-size:18px;"></i>
            </div>
            <div>
                <div class="stat-pill-label">Total Lokasi</div>
                <div class="stat-pill-value">{{ $totalLokasi }} Tempat</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-icon">
                <i class="bi bi-clock-history" style="color:#1e1e2f;font-size:16px;"></i>
            </div>
            <div>
                <div class="stat-pill-label">Riwayat Parkir</div>
                <div class="stat-pill-value">3 Sesi</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-icon">
                <i class="bi bi-geo-alt-fill" style="color:#1e1e2f;font-size:16px;"></i>
            </div>
            <div>
                <div class="stat-pill-label">Lokasi</div>
                <div class="stat-pill-value">Bogor, ID</div>
            </div>
        </div>
        <div class="stat-pill">
            <div class="stat-pill-icon">
                <i class="bi bi-wallet2" style="color:#1e1e2f;font-size:16px;"></i>
            </div>
            <div>
                <div class="stat-pill-label">Tarif Mulai</div>
                <div class="stat-pill-value">Rp3.300/jam</div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- KIRI -->
        <div class="left">
            <h1>Permudah Metode <br><span>Parkir</span> Mu !</h1>
            <p>Parkir jadi lebih mudah, cepat, dan tanpa ribet.</p>

            <!-- SEARCH BAR -->
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search Parking Location..." oninput="searchParkir(this.value)">
                <i class="bi bi-search search-icon"></i>
            </div>

            <!-- HORIZONTAL SCROLL PARKIR -->
            <div class="parking-scroll-wrapper">
                {{-- ── TAMBAHAN: Label section ── --}}
                <div class="section-label">Lokasi Tersedia</div>

               <div class="parking-scroll">

                    @foreach ($parkirList as $parkir)

                    <div class="p-card" onclick="window.open('/booking?location={{ $parkir['param'] }}')">
                        <div class="p-card-img">
                            <img src="{{ asset($parkir['foto']) }}" alt="{{ $parkir['nama'] }}">
                        </div>
                        <div class="p-card-body">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
                                <p class="p-card-name">{{ $parkir['nama'] }}</p>
                                <span class="p-card-rating">
                                    <i class="bi bi-star-fill"></i> {{ $parkir['rating'] }}
                                </span>
                            </div>
                            <p class="p-card-loc">
                                <i class="bi bi-geo-alt-fill" style="color:#1e1e2f;font-size:10px;"></i>
                                {{ $parkir['lokasi'] }}
                            </p>
                            <div class="p-card-footer">
                                <span class="p-card-price">{{ $parkir['harga'] }}</span>
                                <button class="p-card-btn">
                                    <i class="bi bi-arrow-up-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            {{-- ── TAMBAHAN: Label vehicle ── --}}
            <div class="vehicle-label">Jenis Kendaraan</div>

            <!-- VEHICLE SELECTOR -->
            <div class="vehicle">
                <div class="card active" onclick="selectVehicle(this)" data-type="car">
                    <img src="{{ asset('mobil.png') }}" alt="mobil">
                    <span>Mobil</span>
                </div>
                <div class="card" onclick="selectVehicle(this)" data-type="motorcycle">
                    <img src="{{ asset('motor.png') }}" alt="motor">
                    <span>Motor</span>
                </div>
            </div>
        </div>

        <!-- KANAN - TAMPILAN PARKIR -->
        <div class="right">
            <div class="parking-area">
                <div class="line"></div>

                <img id="mainVehicle"
                     src="{{ asset('car.png') }}"
                     data-car="{{ asset('car.png') }}"
                     data-motorcycle="{{ asset('motorcycle.png') }}"
                     alt="kendaraan">

                <div class="line"></div>

                <button class="start-btn" onclick="window.location.href='/map'">
                    Mulai<br>parkir
                </button>
        </div>
    </div>
</div>

<script>
function selectVehicle(el) {
    const mainImg = document.getElementById('mainVehicle');
    document.querySelectorAll('.card').forEach(card => card.classList.remove('active'));
    el.classList.add('active');
    const type = el.dataset.type;
    if (type === 'motorcycle') {
        mainImg.src = mainImg.dataset.motorcycle;
    } else {
        mainImg.src = mainImg.dataset.car;
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

function searchParkir(keyword) {
    const q = keyword.toLowerCase().trim();
    const cards = document.querySelectorAll('.p-card');
    const emptyMsg = document.getElementById('emptySearch');
    let found = 0;

    cards.forEach(card => {
        const nama = card.dataset.nama.toLowerCase();
        if (q === '' || nama.includes(q)) {
            card.style.display = '';
            found++;
        } else {
            card.style.display = 'none';
        }
    });

    // Tampilkan pesan kosong jika tidak ada hasil
    if (emptyMsg) {
        emptyMsg.style.display = found === 0 ? 'block' : 'none';
    }
}

// Inject data-nama ke setiap p-card dari nama yang ada di p-card-name
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.p-card').forEach(card => {
        const nama = card.querySelector('.p-card-name');
        if (nama) card.dataset.nama = nama.textContent.trim();
    });

    // Tambah empty message element
    const wrapper = document.querySelector('.parking-scroll');
    if (wrapper) {
        const msg = document.createElement('p');
        msg.id = 'emptySearch';
        msg.style.cssText = 'display:none;font-size:13px;color:#aaa;padding:16px 0;grid-column:1/-1;text-align:center;';
        msg.textContent = 'Lokasi tidak ditemukan.';
        wrapper.appendChild(msg);
    }
});
</script>
</body>
</html>