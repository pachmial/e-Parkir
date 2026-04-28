<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Parking</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.page {
    position: absolute;
    inset: 0;
}

/* TEXT */
.fade-out {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s ease;
}

/* WRAPPER MOBIL */
.car-wrapper {
    position: absolute;
    top: 50%;
    left: 60px;
    transform: translateY(-50%);
    transition: all 1s cubic-bezier(0.22,1,0.36,1);
}

/* MOBILE DEFAULT */
@media (max-width: 500px) {
    .car-wrapper {
        top: 42%;
        left: 0;
        transform: translateY(-60%) scale(0.9);
    }
}

/* GARIS */
.line {
    position: absolute;
    top: 50%;
    height: 200px;
    border-left: 2px dashed #d1d5db;
    transform: translateY(-50%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.line.left { left: -40px; }
.line.right { right: -40px; }

/* DESKTOP GARIS */
@media (min-width: 768px) {
    .line {
        height: 380px;
    }
}

/* 🔥 BREAKPOINT 500PX (PAKSA JADI DESKTOP STYLE) */
@media (min-width: 500px) {

    #page1, #page2 {
        flex-direction: row !important;
        align-items: center !important;
    }

    #page1 > div:first-child,
    #page2 > div:first-child {
        width: 50% !important;
    }

    #content1, #content2 {
        width: 50% !important;
        margin-top: 0 !important;
        padding-left: 4rem !important;
        padding-right: 4rem !important;
    }

    .car-wrapper {
        top: 50% !important;
        left: 60px !important;
        transform: translateY(-50%) !important;
    }
}

/* tombol */
button:active {
    transform: scale(0.95);
}
</style>
</head>

<body class="bg-white overflow-hidden">

<div class="w-screen h-screen relative overflow-hidden">

    <!-- MOBIL + GARIS -->
    <div id="carWrapper" class="car-wrapper">

        <div id="lineLeft" class="line left"></div>

        <img 
            id="car"
            src="{{ asset('car.png') }}" 
            class="w-[200px] md:w-[320px] rotate-90 transition-all duration-700"
        >

        <div id="lineRight" class="line right"></div>

    </div>

    <!-- PAGE 1 -->
    <div id="page1" class="page flex flex-col md:flex-row items-start md:items-center justify-between">

        <div class="w-full md:w-1/2"></div>

        <div id="content1"
            class="w-full md:w-1/2 flex flex-col justify-between md:justify-center px-5 md:px-24 pb-6 mt-10 md:mt-0">

            <div>
                <div class="flex items-center gap-2 text-xs md:text-sm text-gray-600 mb-2">
                    <img src="{{ asset('logo.png') }}" class="w-5 h-4 md:w-6 md:h-5">
                    <p>Car Parking</p>
                </div>

                <h1 class="md:text-6xl text-4xl font-bold text-gray-800 leading-snug">
                    Cepat dan simple saat mengatur kendaraan Mu 💪
                </h1>
            </div>

            <div class="flex gap-3 mt-6 md:mt-10">
                <button onclick="goHome()" class="flex-1 bg-gray-200 py-3 rounded-lg text-sm">
                    Skip
                </button>

                <button onclick="nextPage()" class="flex-1 bg-black text-white py-3 rounded-lg text-sm">
                    Next
                </button>
            </div>

        </div>
    </div>

    <!-- PAGE 2 -->
    <div id="page2" class="page flex flex-col md:flex-row items-start md:items-center justify-between opacity-0 pointer-events-none">

        <div class="w-full md:w-1/2"></div>

        <div id="content2"
            class="w-full md:w-1/2 flex flex-col justify-between md:justify-center px-6 md:px-24 pb-6 mt-10 md:mt-0">

            <div>
                <div class="flex items-center gap-2 text-xs md:text-sm text-gray-600 mb-3">
                    <img src="{{ asset('logo.png') }}" class="w-5 h-4 md:w-6 md:h-5">
                    <p>Car Parking</p>
                </div>

                <h1 class="text-[32px] md:text-5xl font-bold text-gray-900 leading-tight">
                    Pengalaman parkir yang luar biasa 🧤
                </h1>
            </div>

            <div class="flex gap-3 mt-6 md:mt-10">
                <button onclick="goHome()" class="flex-1 bg-gray-200 py-3 rounded-lg text-sm">
                    Skip
                </button>

                <button onclick="goHome()" class="flex-1 bg-black text-white py-3 rounded-lg text-sm">
                    next
                </button>
            </div>

        </div>
    </div>

</div>

<script>
function animateTextOut(container) {
    container.querySelectorAll("*").forEach(el => {
        el.classList.add("fade-out");
    });
}

function animateTextIn(container) {
    container.querySelectorAll("*").forEach((el, i) => {
        el.style.opacity = "0";
        el.style.transform = "translateY(20px)";
        setTimeout(() => {
            el.style.transition = "all 0.6s cubic-bezier(0.22,1,0.36,1)";
            el.style.opacity = "1";
            el.style.transform = "translateY(0)";
        }, i * 80);
    });
}

function nextPage() {

    const carWrap = document.getElementById("carWrapper");
    const car = document.getElementById("car");
    const page2 = document.getElementById("page2");

    const lineLeft = document.getElementById("lineLeft");
    const lineRight = document.getElementById("lineRight");

    animateTextOut(document.getElementById("content1"));

    // tampilkan garis
    lineLeft.style.opacity = "1";
    lineRight.style.opacity = "1";

    // rotasi mobil ke atas
    car.classList.remove("rotate-90");
    car.classList.add("rotate-0");

    if (window.innerWidth < 500) {
        carWrap.style.left = "50%";
        carWrap.style.transform = "translate(-40%, -50%) scale(0.95)";
    } else {
        carWrap.style.left = "60px";
        carWrap.style.transform = "translate(160px, -50%) scale(0.95)";
    }

    setTimeout(() => {
        page2.style.opacity = "1";
        page2.style.pointerEvents = "auto";
        animateTextIn(document.getElementById("content2"));
    }, 400);
}

function goHome() {
    window.location.href = "/login";
}
</script>

</body>
</html>