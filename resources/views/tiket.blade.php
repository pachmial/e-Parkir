<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parking Ticket</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-white min-h-screen flex justify-center items-center">

<!-- BACK BUTTON -->
<div class="fixed top-4 left-4 z-50">
<button onclick="goBack()" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-md">
    ←
  </button>
</div>

<!-- WRAPPER -->
<div class="w-full min-h-screen flex justify-center items-start pt-16">

  <!-- CONTAINER -->
  <div class="
    w-full min-h-screen bg-white flex flex-col

    /* DESKTOP */
    [@media(min-width:400px)]:min-h-0
    [@media(min-width:400px)]:w-[420px]
    [@media(min-width:400px)]:rounded-2xl
    [@media(min-width:400px)]:shadow-[0_10px_25px_rgba(0,0,0,0.15)]
    [@media(min-width:400px)]:border
  ">

    <!-- HEADER -->
<div class="flex justify-end px-4 pt-4">
    <span class="text-green-600 font-semibold text-sm flex items-center gap-1">
        <i class="bi bi-arrow-down-short"></i>
        Struk
    </span>
</div>
    <!-- CONTENT -->
    <div class="flex-1 px-4 mt-4 pb-28">

      <!-- TITLE -->
      <div class="flex justify-between items-start mb-5">
        <h1 class="text-2xl font-semibold text-gray-800 leading-tight">
          Parking<br>ticket details
        </h1>

        <div class="w-16 h-18 bg-white rounded-xl flex items-center justify-center">
          <img src="{{ asset('riwayat.png') }}">
        </div>
      </div>

      <!-- CARD -->
      <div class="bg-[#f9f9f9] border rounded-2xl p-4 mb-6">
        <div class="flex items-center gap-3">
          <div class="relative">
            <div class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
              P
            </div>
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
          </div>

          <div>
            <p class="font-semibold text-gray-700">F 6797 OB</p>
            <p class="text-sm text-gray-500">BYD M6</p>
          </div>
        </div>

        <p class="text-sm text-gray-500 mt-3">
          Zone A-012 - Parking Mall BTM Muhammad
        </p>
      </div>

      <!-- LOG -->
      <div>
        <h3 class="font-semibold text-gray-700 mb-3">Log activities</h3>

        <div class="flex gap-3">
          <div class="flex flex-col items-center mt-1">
            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
            <div class="w-[2px] h-8 bg-gray-300"></div>
            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
          </div>

          <div class="text-gray-700 text-sm">
            <p class="font-semibold">
              11:00 
              <span class="text-gray-400 text-xs ml-2">03.06.2022</span>
            </p>
            <p class="mt-4 font-semibold">
              13:00 
              <span class="text-gray-400 text-xs ml-2">03.06.2022</span>
            </p>
          </div>
        </div>
      </div>

    </div>

    <!-- PAYMENT -->
    <div class="
      bg-white p-4 border-t

      fixed bottom-0 left-0 w-full z-50

      [@media(min-width:400px)]:static
      [@media(min-width:400px)]:w-auto
      [@media(min-width:400px)]:rounded-b-2xl
    ">
      <p class="text-gray-700 font-medium text-sm">Payment Successfully</p>

      <div class="flex justify-between items-center mt-2">
        <div>
          <p class="text-xs text-gray-400">Total</p>
          <p class="font-semibold text-lg">Rp. 6.600</p>
        </div>

        <button class="bg-green-500 text-white w-10 h-10 rounded-lg flex items-center justify-center">
          ✓
        </button>
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