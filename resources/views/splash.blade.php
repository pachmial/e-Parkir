<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Splash Screen</title>

<style>
body {
  margin: 0;
  height: 100vh;
  background: radial-gradient(circle, #e0e7ff, #636363);
  display: flex;
  justify-content: center;
  align-items: center;
}

.wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.splash {
  position: relative;
  width: 200px;
  height: 200px;
}

.circle {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: rgba(255,255,255,0.3);
  animation: ripple 2s infinite;
}

.circle:nth-child(2) { animation-delay: 0.5s; }
.circle:nth-child(3) { animation-delay: 1s; }

.icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  width: 100px;
  height: 100px;
  background: white;
  border-radius: 50%;

  display: flex;
  justify-content: center;
  align-items: center;

  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.icon img {
  width: 80px;
}

.title {
  margin-top: 40px;
  color: white;
  font-weight: 600;
}

@keyframes ripple {
  0% {
    transform: scale(0.5);
    opacity: 1;
  }
  100% {
    transform: scale(2.5);
    opacity: 0;
  }
}
</style>
</head>

<body>

<div class="wrapper">
  <div class="splash">
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="icon">
      <img src="{{ asset('logo1.png') }}">
    </div>
  </div>

  <h2 class="title">e-Parkir</h2>
</div>

<script>
setTimeout(() => {
  window.location.href = "/halaman1";
}, 3000);
</script>

</body>
</html>