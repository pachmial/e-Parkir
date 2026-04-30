<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk Parkir - ZI PARK</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&family=Bebas+Neue&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg: #f0f1f3;
  --card: #ffffff;
  --text: #1a1d23;
  --muted: #8a8f9c;
  --border: #e2e4e8;
  --accent: #1a1d23;
  --green: #3dba7e;
}

/* 🔥 FULL SCREEN FIX */
body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  height: 100vh;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* BG */
.map-bg {
  position: fixed;
  inset: 0;
  background:
    linear-gradient(rgba(240,241,243,0.92), rgba(240,241,243,0.92)),
    repeating-linear-gradient(0deg, transparent, transparent 40px, rgba(0,0,0,0.03) 40px, rgba(0,0,0,0.03) 41px),
    repeating-linear-gradient(90deg, transparent, transparent 40px, rgba(0,0,0,0.03) 40px, rgba(0,0,0,0.03) 41px);
}

.map-bg::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    linear-gradient(135deg, transparent 30%, rgba(200,200,200,0.18) 30%, rgba(200,200,200,0.18) 32%, transparent 32%),
    linear-gradient(45deg, transparent 60%, rgba(200,200,200,0.12) 60%, rgba(200,200,200,0.12) 63%, transparent 63%);
}

/* 🔥 SHEET COMPACT */
.sheet {
  background: white;
  border-radius: 24px;
  width: 100%;
  max-width: 380px;
  height: 85vh;
  padding: 10px 14px 12px;
  box-shadow: 0 4px 32px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  z-index: 2;
}

.sheet-handle {
  width: 40px;
  height: 4px;
  background: #ddd;
  border-radius: 99px;
  margin: 0 auto 8px;
}

/* HEADER */
.car-title {
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 2px;
}

.car-sub {
  font-size: 11px;
  color: var(--muted);
  margin-bottom: 10px;
}

/* 🔥 RECEIPT */
.receipt {
  background: white;
  border: 1.5px solid var(--border);
  border-radius: 14px;
  flex: 1;
  overflow: hidden; /* ❗ no scroll */
}

/* RECEIPT HEADER */
.receipt-header {
  background: var(--accent);
  padding: 10px 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.park-icon {
  width: 32px;
  height: 32px;
  background: white;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  font-weight: 900;
  color: var(--accent);
  position: relative;
}

.park-icon::after {
  content: '🚗';
  font-size: 10px;
  position: absolute;
  bottom: -2px;
  right: -2px;
}

.brand-name {
  font-family: 'Bebas Neue', sans-serif;
  font-size: 18px;
  color: white;
}

.brand-name span {
  font-size: 8px;
  color: rgba(255,255,255,0.6);
}

/* DIVIDER */
.divider-line {
  height: 2px;
  background: repeating-linear-gradient(90deg, var(--accent) 0 6px, transparent 6px 12px);
  opacity: 0.15;
}

/* 🔥 QR */
.receipt-qr {
  padding: 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  background: #fafafa;
}

.qr-label {
  font-size: 10px;
  color: var(--muted);
}

.qr-wrapper {
  width: 105px;
  height: 105px;
  border: 2px solid var(--accent);
  border-radius: 10px;
  padding: 6px;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* BODY */
.receipt-body {
  padding: 10px 12px 12px;
}

.receipt-row {
  display: flex;
  justify-content: space-between;
  padding: 4px 0;
  border-bottom: 1px dashed var(--border);
  font-size: 12px;
}

.receipt-row:last-child {
  border-bottom: none;
}

.label {
  color: var(--muted);
}

.value {
  font-family: 'DM Mono', monospace;
  font-size: 11px;
}

/* TOTAL */
.total-row {
  background: var(--accent);
  margin: 10px -12px -12px;
  padding: 8px 12px;
  display: flex;
  justify-content: space-between;
  border-radius: 0 0 12px 12px;
}

.t-label {
  color: rgba(255,255,255,0.7);
  font-size: 12px;
}

.t-amount {
  color: white;
  font-weight: 700;
  font-size: 13px;
}

/* FOOTER */
.receipt-footer {
  padding: 8px;
  text-align: center;
  font-size: 10px;
  color: var(--muted);
}

/* BUTTON */
.next-btn {
  margin-top: 10px;
  padding: 12px;
  background: #19183B;
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  flex-shrink: 0;
}

.next-btn:hover {
  opacity: 0.9;
}
</style>
</head>
<body>

<div class="map-bg"></div>

<!-- Bottom Sheet -->
<div class="sheet">

  <div class="car-title">BYD M6</div>
  <div class="car-sub">Muhammad Car</div>

  <!-- Receipt -->
  <div class="receipt">
    <!-- Header -->
    <div class="receipt-header">
      <div class="park-logo">
        <div class="park-icon">P</div>
      </div>
      <div class="brand-name">
        ZI PARK
        <span>Smart Parking Solution</span>
      </div>
    </div>

    <div class="divider-line"></div>

    <!-- QR -->
    <div class="receipt-qr">
      <span class="qr-label">Scan untuk verifikasi</span>
      <div class="qr-wrapper">
        <!-- Generated QR-like SVG pattern -->
         {{ QrCode::size(200)->generate('https://example.com'); }}
      </div>
    </div>

    <div class="receipt-divider"><span>Bukti Pembayaran</span></div>

    <!-- Body -->
    <div class="receipt-body">
      <div class="receipt-row">
        <span class="label">Durasi Parkir</span>
        <span class="value">11:00 – 13:00 WIB</span>
      </div>
      <div class="receipt-row">
        <span class="label">Harga per jam</span>
        <span class="value">Rp 3.000/Jam</span>
      </div>
      <div class="receipt-row">
        <span class="label">PPN</span>
        <div class="tax-block">
          <div class="tax-line">
            <span class="t-label">PPN</span>
            <span class="t-val">10%</span>
          </div>
          <div class="tax-line">
            <span class="t-label">Total</span>
            <span class="t-val">Rp 6.600/2Jam</span>
          </div>
        </div>
      </div>

      <div class="total-row">
        <span class="t-label">Total Bayar</span>
        <span class="t-amount">Rp 6.600</span>
      </div>
    </div>

    <!-- Footer -->
    <div class="receipt-footer">
      Terimakasih telah memilih parkir anda !<br>
      Silakan Simpan struk ini.
    </div>
  </div>

  <button onclick="goHome()" class="next-btn">Next</button>
</div>

<script>
function goHome() {
    window.location.href = "/beranda";
}
</script>
</body>

</html>