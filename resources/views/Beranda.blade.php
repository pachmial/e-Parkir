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
    padding: 20px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
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

/* CONTENT */
.content {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 30px;
}

.left {
    flex: 1;
    min-width: 0;
}

.left h1 {
    font-size: 40px;
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
    max-width: 380px;
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
    max-width: 380px;
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
    max-width: 400px;
    margin-bottom: 24px;
}

.parking-scroll {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding-bottom: 8px;
    scrollbar-width: none;
}

.parking-scroll::-webkit-scrollbar {
    display: none;
}

.p-card {
    min-width: 150px;
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
    height: 90px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    overflow: hidden;
}

.p-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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
    display: flex;
    justify-content: center;
    align-items: center;
}
.parking-area {
    position: relative;
    display: flex;
    align-items: center;
    gap: 20px;

    transform: translateX(-120px); /* geser ke kiri bareng semua */
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
}
@media (max-width: 768px) {

    /* ===== LAYOUT ===== */
    .content {
        flex-direction: column;
        position: relative;
    }

    .left {
        display: flex;
        flex-direction: column;
        width: 100%;
        z-index: 3;
    }

    /* ===== URUTAN ===== */
    .left h1 { order: 1; }
    .vehicle { order: 2; }
    .search-bar { order: 3; }
    .parking-scroll-wrapper { order: 4; }

    /* ===== HIDE DESKRIPSI ===== */
    .left > p {
        display: none;
    }

    /* ===== TEXT ===== */
    .left h1 {
        font-size: 30px;
        margin-bottom: 10px;
    }

    /* ===== SPACING ===== */
    .vehicle {
        margin-top: 15px;
    }

    .search-bar {
        margin-top: 10px;
    }

    .parking-scroll-wrapper {
        margin-top: 15px;
        position: relative;
        z-index: 2;
    }

    /* ===================================== */
    /* 🔥 BAGIAN PENTING: MOBIL TENGAH BAWAH */
    /* ===================================== */

    .right {
        position: absolute;
        left: 50%;
        bottom: -90px; /* ⬅️ bikin dia agak turun */

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

        /* ❗ HAPUS offset lama */
        transform: none;
    }

    /* ===== MOBIL ===== */
    .parking-area img {
        width: 160px;
        max-width: 45vw;

        position: relative;
        bottom: 0;
    }

    /* ===== GARIS ===== */
    .line {
        height: 220px;
    }

    /* ===== TOMBOL ===== */
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
        <a href="/logout">Logout</a>
    </div>

</div>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div class="user">
            <img src="{{ asset('avatar1.png') }}">
            <span>Hello, Agus</span>
        </div>

        <!-- TITIK 3 -->
        <div class="menu" onclick="openSidebar()">⋮</div>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- KIRI -->
        <div class="left">
            <h1>Permudah Metode <br><span>Parkir</span> Mu !</h1>
            <p>Parkir jadi lebih mudah, cepat, dan tanpa ribet.</p>

            <!-- SEARCH BAR -->
            <div class="search-bar center">
                <input type="text" placeholder="Search Parking Location...">
                <i class="bi bi-search search-icon"></i>
            </div>

            <!-- HORIZONTAL SCROLL PARKIR -->
            <div class="parking-scroll-wrapper">
                <div class="parking-scroll">

                    @php
                        $parkirList = [
                            ['nama' => 'Mall BTM',     'lokasi' => 'Bogor, ID', 'harga' => 'Rp3.000/jam', 'rating' => '4.3', 'icon' => '🏬'],
                            ['nama' => 'Boxies 123',   'lokasi' => 'Bogor, ID', 'harga' => 'Rp2.000/jam', 'rating' => '4.1', 'icon' => '🛍️'],
                            ['nama' => 'Lippo Plaza',  'lokasi' => 'Bogor, ID', 'harga' => 'Rp3.000/jam', 'rating' => '4.4', 'icon' => '🏢'],
                            ['nama' => 'Botani Square','lokasi' => 'Bogor, ID', 'harga' => 'Rp3.000/jam', 'rating' => '4.5', 'icon' => '🌿'],
                            ['nama' => 'Ekalokasari',  'lokasi' => 'Bogor, ID', 'harga' => 'Rp2.000/jam', 'rating' => '4.0', 'icon' => '🏪'],
                            ['nama' => 'Jambu Dua',    'lokasi' => 'Bogor, ID', 'harga' => 'Rp2.000/jam', 'rating' => '4.2', 'icon' => '🏙️'],
                        ];
                    @endphp

                    @foreach ($parkirList as $parkir)
                    <div class="p-card">
                        <div class="p-card-img">{{ $parkir['icon'] }}</div>
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

                <button class="start-btn">
                    Mulai<br>parkir
                </button>
            </div>
        </div>

    </div>
</div>
<script>
function selectVehicle(el) {
    const mainImg = document.getElementById('mainVehicle');

    document.querySelectorAll('.card').forEach(card => {
        card.classList.remove('active');
    });

    el.classList.add('active');

    const type = el.dataset.type;

    if (type === 'motorcycle') {
        mainImg.src = mainImg.dataset.motorcycle;
    } else {
        mainImg.src = mainImg.dataset.car;
    }
}

/* SIDEBAR */
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
</script>
</body>
</html>