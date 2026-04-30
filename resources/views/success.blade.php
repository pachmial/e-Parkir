@php
    // Ambil order_id dari URL (misal: /success?order_id=ORDER-123)
    $orderId = request()->get('order_id');
    
    // Ambil data pembayaran dari database berdasarkan nomor referensi
    // Sesuai dengan tabel yang kamu miliki di phpMyAdmin
    $pembayaran = \DB::table('pembayaran')
        ->where('referensi_pembayaran', $orderId)
        ->first();
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran Berhasil</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --green: #3dba7e;
    --green-light: #e8f7f0;
    --green-dark: #28a065;
    --bg: #f0f1f3;
    --card: #f5f6f8;
    --text: #1a1d23;
    --muted: #8a8f9c;
    --border: rgba(0,0,0,0.07);
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
    color: var(--text);
  }

  .back-btn {
    align-self: flex-start;
    width: 44px; height: 44px;
    background: white;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    margin-bottom: 32px;
    transition: transform 0.15s;
  }
  .back-btn:hover { transform: translateX(-2px); }
  .back-btn svg { width: 18px; height: 18px; stroke: #555; }

  .card {
    background: var(--card);
    border-radius: 24px;
    width: 100%;
    max-width: 660px;
    padding: 52px 40px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.06);
    margin-bottom: 20px;
  }

  /* SUCCESS CARD */
  .success-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
  }

  .check-ring {
    width: 72px; height: 72px;
    background: var(--green-light);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both;
  }
  .check-ring svg {
    width: 34px; height: 34px;
    stroke: var(--green);
    stroke-width: 2.5;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
  }
  .check-ring svg path {
    stroke-dasharray: 50;
    stroke-dashoffset: 50;
    animation: drawCheck 0.4s 0.35s ease forwards;
  }

  .success-label {
    font-size: 15px;
    color: var(--muted);
    font-weight: 400;
    letter-spacing: 0.01em;
    animation: fadeUp 0.5s 0.3s ease both;
  }

  .amount {
    font-size: 36px;
    font-weight: 700;
    letter-spacing: -0.02em;
    animation: fadeUp 0.5s 0.4s ease both;
  }

  /* DETAIL CARD */
  .detail-card {
    padding: 36px 40px;
    animation: fadeUp 0.5s 0.5s ease both;
  }

  .detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
  }
  .detail-header h2 {
    font-size: 17px;
    font-weight: 600;
  }
  .detail-header svg {
    width: 20px; height: 20px;
    stroke: var(--muted);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
  }

  .detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
  }
  .detail-row:last-child { border-bottom: none; padding-bottom: 0; }
  .detail-row:first-of-type { padding-top: 0; }

  .row-label {
    font-size: 14px;
    color: var(--muted);
    font-weight: 400;
  }

  .row-value {
    font-size: 14px;
    font-weight: 500;
    text-align: right;
  }

  .badge-success {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--green);
    font-weight: 500;
    font-size: 14px;
  }
  .badge-success svg {
    width: 16px; height: 16px;
    fill: var(--green);
  }

  .row-total .row-label,
  .row-total .row-value {
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
  }

  .mono { font-family: 'DM Mono', monospace; font-size: 13px; }

  /* REDIRECT BAR */
  .redirect-bar {
    width: 100%;
    max-width: 660px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 18px 24px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    animation: fadeUp 0.5s 0.7s ease both;
  }

  .next-btn {
    width: 100%;
    max-width: 200px;
    height: 48px;
    background: #19183B;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
  }

  .next-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
  }

  /* ANIMATIONS */
  @keyframes popIn {
    from { transform: scale(0.5); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }
  @keyframes drawCheck {
    to { stroke-dashoffset: 0; }
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
</head>
<body>

<button class="back-btn" onclick="window.history.back()">
  <svg viewBox="0 0 24 24" fill="none"><polyline points="15 18 9 12 15 6"/></svg>
</button>

<div class="card success-card">
  <div class="check-ring">
    <svg viewBox="0 0 24 24">
      <path d="M5 13l4 4L19 7"/>
    </svg>
  </div>
  <span class="success-label">Pembayaran berhasil !</span>
  
  <span class="amount">
    Rp {{ $pembayaran ? number_format($pembayaran->jumlah, 0, ',', '.') : '0' }}
  </span>

  <p>Ref Number: {{ $orderId }}</p>
</div>

<div class="card detail-card">
  <div class="detail-header">
    <h2>Detail Pembayaran</h2>
    <svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
  </div>

  <div class="detail-row">
    <span class="row-label">Ref Number</span>
    <span class="row-value mono">{{ $pembayaran->referensi_pembayaran ?? '-' }}</span>
  </div>

  <div class="detail-row">
    <span class="row-label">Payment Status</span>
    <span class="row-value">
        <span class="badge-success">
            <svg viewBox="0 0 24 24" style="width:16px; fill:currentColor;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            {{ ucfirst($pembayaran->status ?? 'Berhasil') }}
        </span>
    </span>
  </div>

  <div class="detail-row">
    <span class="row-label">Payment Time</span>
    <span class="row-value mono">
        {{ ($pembayaran && $pembayaran->dibayar_pada) 
            ? \Carbon\Carbon::parse($pembayaran->dibayar_pada)->format('d-m-Y H:i:s') 
            : now()->format('d-m-Y H:i:s') }}
    </span>
  </div>

  <div class="detail-row row-total">
    <span class="row-label">Total Payment</span>
    <span class="row-value">
        Rp {{ $pembayaran ? number_format($pembayaran->jumlah, 0, ',', '.') : '0' }}
    </span>
  </div>
</div>

<div class="redirect-bar">
    <button onclick="goqrcode()" class="next-btn">Next</button>
</div>

<script>
    function goqrcode() {
        window.location.href = "/qrcode";
    }
</script>
</body>
</html>