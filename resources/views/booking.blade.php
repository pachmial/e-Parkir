<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Parkir · Booking</title>

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #0f1117;
            --surface: #1a1d27;
            --surface2: #22263a;
            --accent: #4ade80;
            --accent2: #22d3ee;
            --text: #f0f2f8;
            --text-muted: #8b91a8;
            --border: rgba(255,255,255,0.08);
            --shadow: 0 24px 64px rgba(0,0,0,0.6);
            --radius: 20px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* ── MAP ── */
        #map {
            width: 100%;
            height: 100vh;
            z-index: 1;
            transition: all 0.5s cubic-bezier(0.32, 0.72, 0, 1);
        }

        /* ── HEADER PILL ── */
        .header-pill {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow);
            transition: left 0.5s cubic-bezier(0.32, 0.72, 0, 1), transform 0.5s cubic-bezier(0.32, 0.72, 0, 1);
        }

        .booking-open .header-pill {
            left: 25%;
            transform: translateX(-50%);
        }

        .header-pill .dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.3); }
        }

        .header-pill span {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.02em;
        }

        /* ── BACK BUTTON ── */
        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 100;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 16px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
            backdrop-filter: blur(20px);
        }
        .back-btn:hover { background: var(--surface2); color: var(--text); }
        .back-btn svg { width: 16px; height: 16px; }

        /* ── MAIN LAYOUT ── */
        .main-layout {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            pointer-events: none;
        }

        /* ── LEFT PANEL ── */
        .panel-left {
            width: 420px;
            flex-shrink: 0;
            height: 100%;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            pointer-events: all;
            transform: translateX(-100%);
            transition: transform 0.5s cubic-bezier(0.32, 0.72, 0, 1);
            box-shadow: 4px 0 40px rgba(0,0,0,0.5);
        }

        .panel-left.active {
            transform: translateX(0);
        }

        .panel-left-inner {
            padding: 28px 24px 24px;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .panel-top {
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .panel-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 4px;
        }

        .panel-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            font-family: 'DM Mono', monospace;
            letter-spacing: 0.04em;
        }

        /* ── SLOT GRID ── */
        .slot-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            overflow-y: auto;
            flex: 1;
            padding-right: 4px;
            padding-bottom: 8px;
        }

        .slot-grid::-webkit-scrollbar { width: 4px; }
        .slot-grid::-webkit-scrollbar-track { background: transparent; }
        .slot-grid::-webkit-scrollbar-thumb { background: var(--border); border-radius: 100px; }

        .slot-card {
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 16px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .slot-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(74,222,128,0.08), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .slot-card:hover::before { opacity: 1; }
        .slot-card:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .slot-card.selected {
            border-color: var(--accent);
            background: rgba(74,222,128,0.1);
        }

        .slot-card.occupied {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
        }

        .slot-card-id {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            font-weight: 500;
            color: var(--text);
        }

        .slot-card-status {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent);
        }

        .slot-card.occupied .slot-card-status { color: #f87171; }

        .panel-footer {
            margin-top: 16px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-footer-info {
            font-size: 12px;
            color: var(--text-muted);
        }

        .panel-footer-info span {
            color: var(--accent);
            font-weight: 700;
        }

        /* ── TICKET PANEL ── */
.ticket-section {
    margin-bottom: 20px;
}

.ticket-section-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 12px;
}

.vehicle-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 12px;
}

.vehicle-icon {
    width: 42px;
    height: 42px;
    background: var(--surface2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.vehicle-icon svg {
    width: 22px;
    height: 22px;
    color: var(--accent);
}

.vehicle-name {
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
}

.vehicle-type {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

.ticket-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
}

.ticket-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}

.ticket-icon {
    width: 32px;
    height: 32px;
    background: rgba(74,222,128,0.15);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ticket-icon svg {
    width: 16px;
    height: 16px;
    color: var(--accent);
}

.ticket-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
}

.ticket-subtitle {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 1px;
    font-family: 'DM Mono', monospace;
}

.ticket-rows {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.ticket-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ticket-row-label {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 600;
}

.ticket-row-value {
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
    font-family: 'DM Mono', monospace;
}

.ticket-row-value.badge {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 3px 10px;
    font-size: 11px;
}

.ticket-divider {
    height: 1px;
    background: var(--border);
    margin: 12px 0;
}

.ticket-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 16px;
}

.ticket-price {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-muted);
}

.ticket-price span {
    font-size: 18px;
    color: var(--accent);
    font-family: 'DM Mono', monospace;
}

.next-btn {
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--accent), #16a34a);
    color: #0f1117;
    border: none;
    border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    transition: all 0.2s;
}

.next-btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(74,222,128,0.3);
}

/* Transisi panel kanan */
.panel-right-inner {
    transition: opacity 0.3s ease;
}

.panel-right-inner.fade-out {
    opacity: 0;
}

        /* ── RIGHT PANEL (BOOKING DETAIL) ── */
        .panel-right {
            width: 340px;
            flex-shrink: 0;
            height: 100%;
            background: rgba(15, 17, 23, 0.85);
            backdrop-filter: blur(24px);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: center;
            pointer-events: all;
            padding: 36px 28px;
            margin-left: auto;
            transform: translateX(100%);
            transition: transform 0.5s cubic-bezier(0.32, 0.72, 0, 1);
            box-shadow: -4px 0 40px rgba(0,0,0,0.5);
        }

        .panel-right.active {
            transform: translateX(0);
        }

        .booking-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.3;
            margin-bottom: 28px;
        }

        .booking-title b {
            font-weight: 800;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .booking-info-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 20px;
        }

        .booking-location {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .booking-location svg {
            width: 14px;
            height: 14px;
            color: var(--accent);
            flex-shrink: 0;
        }

        .booking-slot-code {
            font-family: 'DM Mono', monospace;
            font-size: 36px;
            font-weight: 500;
            color: var(--text);
            letter-spacing: 0.04em;
            margin-bottom: 16px;
            line-height: 1;
        }

        .booking-divider {
            height: 1px;
            background: var(--border);
            margin: 16px 0;
        }

        .booking-detail-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .booking-detail-item {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .booking-detail-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .booking-detail-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            font-family: 'DM Mono', monospace;
        }

        .booking-detail-value.green {
            color: var(--accent);
        }

        .booking-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--accent), #16a34a);
            color: #0f1117;
            border: none;
            border-radius: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.01em;
        }

        .booking-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(74,222,128,0.3);
        }

        .booking-btn:active {
            transform: translateY(0);
        }

        /* ── STATE: booking open = map shrinks ── */
        body.booking-open #map {
            /* map stays fullscreen, panels overlay it */
        }

        /* ── FORMULIR PANEL ── */
.formulir-wrap {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.formulir-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 6px;
    flex-shrink: 0;
}

.formulir-main-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--text);
}

.formulir-sub-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 16px;
    flex-shrink: 0;
}

.close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--surface2);
    border: 1px solid var(--border);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
    color: var(--text-muted);
}

.close-btn:hover { background: var(--border); color: var(--text); }
.close-btn svg { width: 14px; height: 14px; }

.formulir-inputs {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px;
    flex-shrink: 0;
}

.formulir-input {
    width: 100%;
    background: var(--surface2);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 13px 16px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px;
    color: var(--text);
    outline: none;
    transition: border-color 0.2s;
}

.formulir-input::placeholder { color: var(--text-muted); }
.formulir-input:focus { border-color: var(--accent); }

.formulir-summary {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 16px;
    flex-shrink: 0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.summary-row:last-child { margin-bottom: 0; }

.summary-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
}

.summary-value {
    font-size: 12px;
    color: var(--text-muted);
    font-family: 'DM Mono', monospace;
}

.formulir-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    flex-shrink: 0;
}

.footer-total-label {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 600;
    margin-bottom: 3px;
}

.footer-total-value {
    font-size: 20px;
    font-weight: 800;
    color: var(--text);
    font-family: 'DM Mono', monospace;
}
    </style>
</head>
<body>

    {{-- Header Pill --}}
    <div class="header-pill">
        <div class="dot"></div>
        <span>e-Parkir · Booking</span>
    </div>

    {{-- Back Button --}}
    <a href="{{ url('/map') }}" class="back-btn">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    {{-- Map Background --}}
    <div id="map"></div>

    {{-- Main Layout --}}
    <div class="main-layout" id="mainLayout">

        {{-- LEFT PANEL: Pilih Slot --}}
        <div class="panel-left active" id="panelLeft">
            <div class="panel-left-inner">
                <div class="panel-top">
                    <div class="panel-title">Pilih tempat Parkir</div>
                    <div class="panel-subtitle" id="panelSubtitle">Zone A · Parkir Mall BTM</div>
                </div>

                <div class="slot-grid" id="slotGrid">
                    {{-- JS generated --}}
                </div>

                <div class="panel-footer">
                    <div class="panel-footer-info">
                        Dipilih: <span id="selectedLabel">—</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL: Booking Detail --}}
        {{-- RIGHT PANEL: Booking Detail / Ticket --}}
<div class="panel-right" id="panelRight">
    {{-- Konten ini akan di-toggle oleh JS --}}
    <div id="viewBooking">
        <div class="booking-title">
            Booking Tempat<br><b>Parkir Mu !</b>
        </div>

        <div class="booking-info-card">
            <div class="booking-location">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span id="bookingLocation">Parkir Mall BTM</span>
            </div>

            <div class="booking-slot-code" id="bookingSlotCode">—</div>

            <div class="booking-divider"></div>

            <div class="booking-detail-row">
                <div class="booking-detail-item">
                    <div class="booking-detail-label">Mulai Parkir</div>
                    <div class="booking-detail-value" id="bookingTime">—</div>
                </div>
                <div class="booking-detail-item" style="text-align:right">
                    <div class="booking-detail-label">Tarif</div>
                    <div class="booking-detail-value green">Rp3.000/Jam</div>
                </div>
            </div>
        </div>

        <button class="booking-btn" id="bookingBtn" onclick="submitBooking()">
            Mulai Booking →
        </button>
    </div>

    {{-- TICKET VIEW (muncul setelah klik Mulai Booking) --}}
    <div id="viewTicket" style="display:none;">
        <div class="booking-title" style="margin-bottom:20px;">
            Tiket <b>Parkir Mu !</b>
        </div>

        {{-- Kendaraan --}}
        <div class="ticket-section">
            <div class="ticket-section-label">Kendaraan</div>
            <div class="vehicle-card">
                <div class="vehicle-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 6H5l-2 6h16l-1.5-6H13z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12v4a1 1 0 001 1h1M17 17h2a1 1 0 001-1v-4"/>
                    </svg>
                </div>
                <div>
                    <div class="vehicle-name">BYD M6</div>
                    <div class="vehicle-type">Kendaraan Pribadi</div>
                </div>
            </div>
        </div>

        {{-- Ticket Details --}}
        <div class="ticket-section">
            <div class="ticket-section-label">Ticket details</div>
            <div class="ticket-card">
                <div class="ticket-header">
                    <div class="ticket-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ticket-title">Reget Tiket</div>
                        <div class="ticket-subtitle" id="ticketSlotZone">Zone A · A-012</div>
                    </div>
                </div>

                <div class="ticket-rows">
                    <div class="ticket-row">
                        <div class="ticket-row-label">Waktu</div>
                        <div class="ticket-row-value" id="ticketTime">00:00–23:59</div>
                    </div>
                    <div class="ticket-row">
                        <div class="ticket-row-label">No. Seri</div>
                        <div class="ticket-row-value badge" id="ticketSerial">No. 502</div>
                    </div>
                </div>

                <div class="ticket-divider"></div>

                <div class="ticket-footer">
                    <div class="ticket-price">
                        <span id="ticketPrice">Rp3.000</span>/jam
                    </div>
                    <button class="next-btn" onclick="goToConfirm()">
                        Selanjutnya →
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- FORMULIR VIEW (muncul setelah klik Selanjutnya di ticket) --}}
<div id="viewFormulir" style="display:none;">
    <div class="formulir-wrap">

        <div class="formulir-header">
            <div class="formulir-main-title">Formulir booking</div>
            <button class="close-btn" onclick="closeFormulir()">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="formulir-sub-title">Ticket details</div>

        <div class="formulir-inputs">
            <input class="formulir-input" type="text"
                placeholder="Konfirmasi nama anda."
                id="inputNama">

            <input class="formulir-input" type="text"
                placeholder="Masukan plat nomor."
                id="inputPlat"
                oninput="this.value=this.value.toUpperCase()">

            <input class="formulir-input" type="time"
                id="inputJamAwal"
                oninput="hitungDurasi()">

            <input class="formulir-input" type="time"
                id="inputJamAkhir"
                oninput="hitungDurasi()">
        </div>

        <div class="formulir-summary">
            <div class="summary-row">
                <span class="summary-label">Durasi Parkir</span>
                <span class="summary-value" id="summaryDurasi">– WIB</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total Durasi</span>
                <span class="summary-value" id="summaryTotalDurasi">– jam</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Harga per/jam</span>
                <span class="summary-value">Rp 3.000/Jam</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">PPN/Pajak</span>
                <span class="summary-value" id="summaryPajak">Rp. 000</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Total</span>
                <span class="summary-value" id="summaryTotal">Rp. 000/Jam</span>
            </div>
        </div>

        <div class="formulir-footer">
            <div>
                <div class="footer-total-label">Total</div>
                <div class="footer-total-value" id="footerTotal">Rp0</div>
            </div>
            <button class="booking-btn" style="width:auto; padding:14px 28px;" onclick="submitFormulir()">
                Selanjutnya
            </button>
        </div>

    </div>
</div>
</div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // ── DATA (dari query string atau bisa dari Laravel controller) ──
        const urlParams   = new URLSearchParams(window.location.search);
        const locationId  = urlParams.get('location') || 'btm';
        const preselected = urlParams.get('slot') || null;

        const locationsData = {
            btm:        { name: 'Mall BTM (Bogor Trade Mall)', zone: 'Zone A', lat: -6.5975, lng: 106.7974, slots: generateSlots('A', 12, [3, 7, 11]) },
            boxies:     { name: 'Boxies 123 Mall',             zone: 'Zone B', lat: -6.6112, lng: 106.8214, slots: generateSlots('B', 12, [1, 5, 9, 12]) },
            lippo:      { name: 'Lippo Plaza Bogor',           zone: 'Zone C', lat: -6.6021, lng: 106.8103, slots: generateSlots('C', 12, [2, 8]) },
            botani:     { name: 'Botani Square',               zone: 'Zone D', lat: -6.5940, lng: 106.7990, slots: generateSlots('D', 12, []) },
            ekalokasari:{ name: 'Ekalokasari Plaza',           zone: 'Zone E', lat: -6.5963, lng: 106.8195, slots: generateSlots('E', 12, [4, 6, 10]) },
            jambu2:     { name: 'Jambu Dua Square',            zone: 'Zone F', lat: -6.5615, lng: 106.7923, slots: generateSlots('F', 12, [0, 3, 7, 11]) },
        };

        function generateSlots(zoneCode, count, occupiedIndexes) {
            return Array.from({ length: count }, (_, i) => ({
                id: `${zoneCode}-${String(i + 1).padStart(3, '0')}`,
                occupied: occupiedIndexes.includes(i)
            }));
        }

        // ── MAP ──
        const currentLoc = locationsData[locationId] || locationsData['btm'];

        const map = L.map('map', {
            center: [currentLoc.lat, currentLoc.lng],
            zoom: 15,
            zoomControl: false,
            dragging: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
        });

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap © CARTO',
            maxZoom: 19
        }).addTo(map);

        // Marker lokasi saat ini
        const markerHtml = `
            <div style="
                width:36px;height:36px;
                border-radius:50% 50% 50% 0;
                transform:rotate(-45deg);
                background:linear-gradient(135deg,#4ade80,#16a34a);
                border:2px solid rgba(255,255,255,0.3);
                display:flex;align-items:center;justify-content:center;
                box-shadow:0 4px 16px rgba(74,222,128,0.4);
            ">
                <span style="transform:rotate(45deg);font-size:14px;">🅿</span>
            </div>`;

        L.marker([currentLoc.lat, currentLoc.lng], {
            icon: L.divIcon({ html: markerHtml, className: '', iconSize: [36,36], iconAnchor: [18,36] })
        }).addTo(map);

        // ── INIT PANEL ──
        document.getElementById('panelSubtitle').textContent =
            `${currentLoc.zone} · ${currentLoc.name}`;
        document.getElementById('bookingLocation').textContent = currentLoc.name;

        renderSlots(currentLoc.slots);

        // Pre-select slot jika ada dari URL
        if (preselected) {
            setTimeout(() => selectSlot(preselected), 100);
        }

        // ── RENDER SLOTS ──
        function renderSlots(slots) {
            const grid = document.getElementById('slotGrid');
            grid.innerHTML = slots.map(slot => `
                <div
                    class="slot-card ${slot.occupied ? 'occupied' : ''}"
                    id="slot-${slot.id}"
                    onclick="selectSlot('${slot.id}')"
                >
                    <div class="slot-card-id">${slot.id}</div>
                    <div class="slot-card-status">${slot.occupied ? 'Penuh' : 'Kosong'}</div>
                </div>
            `).join('');
        }

        // ── SELECT SLOT ──
        let selectedSlot = null;

        function selectSlot(slotId) {
            document.querySelectorAll('.slot-card.selected')
                .forEach(el => el.classList.remove('selected'));

            const card = document.getElementById(`slot-${slotId}`);
            if (!card || card.classList.contains('occupied')) return;

            card.classList.add('selected');
            selectedSlot = slotId;

            document.getElementById('selectedLabel').textContent = slotId;
            document.getElementById('bookingSlotCode').textContent = slotId;

            // Set waktu sekarang
            const now = new Date();
            const jam  = now.getHours().toString().padStart(2, '0');
            const mnt  = now.getMinutes().toString().padStart(2, '0');
            document.getElementById('bookingTime').textContent = `${jam}:${mnt} Kedepan`;

            // Tampilkan panel kanan
            document.getElementById('panelRight').classList.add('active');
        }

        // ── SUBMIT BOOKING ──
        function submitBooking() {
    if (!selectedSlot) return;

    // Isi data tiket
    const now = new Date();
    const jam = now.getHours().toString().padStart(2, '0');
    const mnt = now.getMinutes().toString().padStart(2, '0');

    document.getElementById('ticketSlotZone').textContent =
        `${currentLoc.zone} · ${selectedSlot}`;
    document.getElementById('ticketTime').textContent =
        `${jam}:${mnt} – 23:59`;
    document.getElementById('ticketSerial').textContent =
        'No. ' + Math.floor(Math.random() * 900 + 100);

    // Fade out booking, fade in ticket
    const booking = document.getElementById('viewBooking');
    const ticket  = document.getElementById('viewTicket');

    booking.style.transition = 'opacity 0.25s';
    booking.style.opacity = '0';

    setTimeout(() => {
        booking.style.display = 'none';
        ticket.style.display  = 'block';
        ticket.style.opacity  = '0';
        ticket.style.transition = 'opacity 0.25s';
        requestAnimationFrame(() => {
            ticket.style.opacity = '1';
        });
    }, 250);
}

// Tombol Selanjutnya di ticket → buka formulir
function goToConfirm() {
    const ticket   = document.getElementById('viewTicket');
    const formulir = document.getElementById('viewFormulir');

    ticket.style.transition = 'opacity 0.25s';
    ticket.style.opacity = '0';

    setTimeout(() => {
        ticket.style.display   = 'none';
        formulir.style.display = 'block';
        formulir.style.opacity = '0';
        formulir.style.transition = 'opacity 0.25s';
        requestAnimationFrame(() => {
            formulir.style.opacity = '1';
        });
    }, 250);
}

// Tombol X di formulir → kembali ke ticket
function closeFormulir() {
    const ticket   = document.getElementById('viewTicket');
    const formulir = document.getElementById('viewFormulir');

    formulir.style.transition = 'opacity 0.25s';
    formulir.style.opacity = '0';

    setTimeout(() => {
        formulir.style.display = 'none';
        ticket.style.display   = 'block';
        ticket.style.opacity   = '0';
        ticket.style.transition = 'opacity 0.25s';
        requestAnimationFrame(() => {
            ticket.style.opacity = '1';
        });
    }, 250);
}

// Hitung durasi otomatis
function hitungDurasi() {
    const awal  = document.getElementById('inputJamAwal').value;
    const akhir = document.getElementById('inputJamAkhir').value;
    if (!awal || !akhir) return;

    const [ah, am] = awal.split(':').map(Number);
    const [bh, bm] = akhir.split(':').map(Number);
    const totalMenit = (bh * 60 + bm) - (ah * 60 + am);
    if (totalMenit <= 0) return;

    const jam   = Math.ceil(totalMenit / 60);
    const tarif = 3000;
    const pajak = Math.round(jam * tarif * 0.1);
    const total = jam * tarif + pajak;

    document.getElementById('summaryDurasi').textContent      = `${awal} – ${akhir} WIB`;
    document.getElementById('summaryTotalDurasi').textContent = `${jam} jam`;
    document.getElementById('summaryPajak').textContent       = `Rp. ${pajak.toLocaleString('id-ID')}`;
    document.getElementById('summaryTotal').textContent       = `Rp. ${total.toLocaleString('id-ID')}/Jam`;
    document.getElementById('footerTotal').textContent        = `Rp${total.toLocaleString('id-ID')}`;
}

// Tombol Selanjutnya di formulir → submit ke Laravel
function submitFormulir() {
    const nama  = document.getElementById('inputNama').value;
    const plat  = document.getElementById('inputPlat').value;
    const awal  = document.getElementById('inputJamAwal').value;
    const akhir = document.getElementById('inputJamAkhir').value;

    if (!nama || !plat || !awal || !akhir) {
        alert('Lengkapi semua data terlebih dahulu!');
        return;
    }

    window.location.href =
        `/booking/confirm?slot=${encodeURIComponent(selectedSlot)}&location=${encodeURIComponent(locationId)}&nama=${encodeURIComponent(nama)}&plat=${encodeURIComponent(plat)}&awal=${encodeURIComponent(awal)}&akhir=${encodeURIComponent(akhir)}`;
}
    </script>
</body>
</html>