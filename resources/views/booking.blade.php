@php
    $user = auth()->user();
    $kendaraan = $user ? \App\Models\Kendaraan::where('pengguna_id', $user->id)->first() : null;
@endphp

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
    --bg: #f0f2f5;
    --surface: #ffffff;
    --surface2: #f0f2f5;
    --accent: #1a1d27;
    --accent2: #22d3ee;
    --text: #1a1d27;
    --text-muted: #8b91a8;
    --border: rgba(0,0,0,0.08);
    --shadow: 0 24px 64px rgba(0,0,0,0.12);
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
    padding: 80px 24px 24px;  /* tambah padding top biar turun */
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
}

.panel-top {
    margin-bottom: 16px;
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
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;  /* dari 10px jadi 6px */
    overflow-y: auto;
    flex: ;
    padding-right: 4px;
    padding-bottom: 8px;
}


        .slot-grid::-webkit-scrollbar { width: 4px; }
        .slot-grid::-webkit-scrollbar-track { background: transparent; }
        .slot-grid::-webkit-scrollbar-thumb { background: var(--border); border-radius: 100px; }

        .slot-card {
    background: var(--surface2);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 10px 6px;  /* dari 16px 8px jadi lebih kecil */
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
    gap: 3px;
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
    background: linear-gradient(135deg, var(--accent), #ffffff);
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
            background: rgba(255, 255, 255, 0.92);
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
            background: linear-gradient(135deg, var(--accent), #ffffff);
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

    /* ── PAYMENT PANEL ── */
.payment-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-shrink: 0;
}

.payment-main-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
}

.payment-icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--surface2);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
}

.payment-icon-btn svg {
    width: 18px;
    height: 18px;
    color: var(--text-muted);
}

.payment-section-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.payment-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
}

.payment-tag.green {
    background: rgba(74,222,128,0.15);
    color: var(--accent);
    border: 1px solid rgba(74,222,128,0.3);
}

.payment-tag.blue {
    background: rgba(34,211,238,0.15);
    color: var(--accent2);
    border: 1px solid rgba(34,211,238,0.3);
}

.payment-method-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
    max-height: 200px;
    overflow-y: auto;
    padding-right: 4px;
}

.payment-method-list::-webkit-scrollbar { width: 4px; }
.payment-method-list::-webkit-scrollbar-track { background: transparent; }
.payment-method-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 100px; }

.payment-item {
    display: flex;
    align-items: center;
    gap: 14px;
    background: var(--surface2);
    border: 1.5px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}

.payment-item:hover {
    border-color: var(--accent);
}

.payment-item.selected {
    border-color: var(--accent);
    background: rgba(74,222,128,0.08);
}

.payment-item-logo {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    flex-shrink: 0;
    overflow: hidden;
}

.payment-item-logo.wallet {
    background: rgba(74,222,128,0.15);
    color: var(--accent);
}

.payment-item-logo.bca {
    background: #ffffff;
    color: #fff;
}

.payment-item-logo.bri {
    background: #ffffff;
    color: #fff;
}

.payment-item-logo.dana {
    background: #ffffff;
    color: #fff;
}

.payment-item-logo.gopay {
    background: #ffffff;
    color: #fff;
}

.payment-item-info {
    flex: 1;
}

.payment-item-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
    font-family: 'DM Mono', monospace;
}

.payment-item-sub {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

.payment-item-check {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}

.payment-item.selected .payment-item-check {
    background: var(--accent);
    border-color: var(--accent);
}

.payment-item.selected .payment-item-check::after {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #0f1117;
}

.payment-footer {
    margin-top: auto;
    flex-shrink: 0;
}

.payment-total-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.payment-total-label {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 600;
    margin-bottom: 3px;
}

.payment-total-value {
    font-size: 20px;
    font-weight: 800;
    color: var(--text);
    font-family: 'DM Mono', monospace;
}

/* ── PARKING TICKET DETAILS ── */
.ptd-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-shrink: 0;
}

.ptd-main-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
}

.ptd-icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--surface2);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ptd-icon-btn svg {
    width: 18px;
    height: 18px;
    color: var(--text-muted);
}

.ptd-vehicle-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    flex-shrink: 0;
}

.ptd-vehicle-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 20px;
    font-weight: 800;
    color: #fff;
}

.ptd-vehicle-plate {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    font-family: 'DM Mono', monospace;
}

.ptd-vehicle-type {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

.ptd-vehicle-detail {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 6px;
    padding-top: 6px;
    border-top: 1px solid var(--border);
}

.ptd-log {
    margin-bottom: 16px;
    flex-shrink: 0;
}

.ptd-log-title {
    font-size: 12px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 10px;
}

.ptd-log-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding-left: 4px;
}

.ptd-log-item {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
}

.ptd-log-item::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--accent);
    flex-shrink: 0;
}

.ptd-log-item:last-child::before {
    background: #f87171;
}

.ptd-log-time {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
    font-family: 'DM Mono', monospace;
    min-width: 48px;
}

.ptd-log-date {
    font-size: 11px;
    color: var(--text-muted);
}

.ptd-payment-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    flex-shrink: 0;
}

.ptd-payment-logo {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ptd-payment-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 10px;
}

.ptd-payment-info {
    flex: 1;
}

.ptd-payment-number {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
    font-family: 'DM Mono', monospace;
}

.ptd-payment-sub {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

.ptd-payment-total {
    text-align: right;
}

.ptd-payment-total-label {
    font-size: 10px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 600;
}

.ptd-payment-total-value {
    font-size: 14px;
    font-weight: 800;
    color: var(--accent);
    font-family: 'DM Mono', monospace;
}

.ptd-chevron {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    background: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ptd-chevron svg {
    width: 14px;
    height: 14px;
    color: #0f1117;
}

/* ── INFO CARD (sebelum slot dipilih) ── */
.info-card {
    position: fixed;
    right: 28px;
    top: 50%;
    transform: translateY(-50%);
    width: 300px;
    z-index: 60;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.info-card.hidden {
    opacity: 0;
}

.info-card-block {
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
}

.info-card-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 10px;
}

.info-card-location {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}

.info-card-loc-icon {
    width: 40px;
    height: 40px;
    background: var(--surface2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-card-loc-icon svg {
    width: 20px;
    height: 20px;
    color: var(--text);
}

.info-card-loc-name {
    font-size: 14px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
}

.info-card-loc-zone {
    font-size: 11px;
    color: var(--text-muted);
    font-family: 'DM Mono', monospace;
    margin-top: 2px;
}

.info-stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

.info-stat-item {
    background: var(--surface2);
    border-radius: 12px;
    padding: 12px;
}

.info-stat-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 4px;
}

.info-stat-value {
    font-size: 14px;
    font-weight: 800;
    color: var(--text);
}

.info-stat-value.green { color: #16a34a; }

.info-tips-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-tip-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.5;
}

.info-tip-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--text-muted);
    flex-shrink: 0;
    margin-top: 5px;
}

.info-select-hint {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px;
    background: var(--surface2);
    border-radius: 14px;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    animation: hint-pulse 2s infinite;
}

@keyframes hint-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

.info-select-hint svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

/* ── ZONA TABS ── */
.zona-tab {
    flex: 1;
    padding: 8px;
    background: var(--surface2);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px;
    font-weight: 700;
    color: var(--text-muted);
    cursor: pointer;
    text-align: center;
    transition: all 0.2s;
}

.zona-tab:hover {
    border-color: var(--accent);
    color: var(--text);
}

.zona-tab.active {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
}

.mobile-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 200;          /* tetap di bawah panel-right (z-index 250) */
    opacity: 0;
    transition: opacity 0.35s ease;
    backdrop-filter: blur(2px);
    pointer-events: none;  /* ← TAMBAH INI, overlay gak nyegat klik */
}


/* ══════════════════════════════════════════
   MOBILE: < 768px
   ══════════════════════════════════════════ */
@media (max-width: 768px) {

    /* ── Header pill tetap center ── */
    .booking-open .header-pill {
        left: 50%;
        transform: translateX(-50%);
    }

    /* ── Panel kiri: full width, full height ── */
    .panel-left {
        width: 100%;
        height: 100%;
        border-right: none;
        transform: translateX(-100%);
        z-index: 100;
        transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1),
                    opacity 0.3s ease;
    }

    .panel-left.active {
        transform: translateX(0);
    }

    /*
       Mode "payment flow" — panel kiri disembunyikan
       supaya panel kanan bisa full screen
    */
    .panel-left.mobile-hidden {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }

    /* ── Panel kanan: BOTTOM SHEET default ── */
    .panel-right {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: auto;
        max-height: 88vh;
        border-left: none;
        border-top: 1px solid var(--border);
        border-radius: 24px 24px 0 0;
        margin-left: 0;
        padding: 0 24px 32px;
        transform: translateY(100%);       /* sembunyi di bawah */
        transition: transform 0.42s cubic-bezier(0.32, 0.72, 0, 1);
        overflow-y: auto;
        z-index: 250;
        box-shadow: 0 -8px 40px rgba(0,0,0,0.25);
        justify-content: flex-start;
    }

    /* Handle bar di atas bottom sheet */
    .panel-right::before {
        content: '';
        display: block;
        width: 40px;
        height: 4px;
        background: var(--border);
        border-radius: 100px;
        margin: 14px auto 20px;
        flex-shrink: 0;
    }

    .panel-right.active {
        transform: translateY(0);
    }

    /*
       Mode "full screen" — saat masuk formulir/payment/ticket
       Panel kanan jadi full screen dari atas
    */
    .panel-right.mobile-fullscreen {
        height: 100%;
        max-height: 100vh;
        border-radius: 0;
        padding-top: 20px;
    }

    /* ── Info card: sembunyikan di mobile ── */
    .info-card {
        display: none !important;
    }

    /* ── Back button lebih kecil ── */
    .back-btn {
        top: 16px;
        left: 16px;
        padding: 8px 14px;
        font-size: 12px;
    }

    /* ── Header pill naik sedikit ── */
    .header-pill {
        top: 16px;
        padding: 8px 18px;
    }

    /* ── Panel left inner: padding top lebih kecil ── */
    .panel-left-inner {
        padding: 70px 20px 20px;
    }

    /* ── Slot grid: 3 kolom tetap, gap lebih kecil ── */
    .slot-grid {
        gap: 12px;
    }

    /* ── Panel right inner content ── */
    #viewBooking, #viewTicket, #viewFormulir,
    #viewPayment, #viewParkingTicket {
        padding-bottom: 8px;
    }

    /* ── Booking title lebih kecil di mobile ── */
    .booking-title {
        font-size: 18px;
        margin-bottom: 16px;
    }

    /* ── Formulir wrap height di fullscreen ── */
    .panel-right.mobile-fullscreen .formulir-wrap {
        min-height: calc(100vh - 80px);
    }

    /* ── Payment method list: bisa scroll ── */
    .payment-method-list {
        max-height: 180px;
    }

    /* ── Mobile back button di dalam panel kanan ── */
    .mobile-back-in-panel {
        display: flex !important;
        align-items: center;
        gap: 6px;
        background: none;
        border: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0;
        margin-bottom: 16px;
    }

    .mobile-back-in-panel svg {
        width: 16px;
        height: 16px;
    }
}

/* Desktop: sembunyikan elemen mobile-only */
@media (min-width: 769px) {
    .mobile-overlay { display: none !important; }
    .mobile-back-in-panel { display: none !important; }
    .panel-left.mobile-hidden { transform: translateX(0) !important; opacity: 1 !important; }
    .panel-right.mobile-fullscreen { height: 100% !important; max-height: 100% !important; border-radius: 0 !important; }
}


    </style>
</head>
<body>

    <div class="mobile-overlay" id="mobileOverlay" ></div>

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

    <div class="panel-left active" id="panelLeft">
        <div class="panel-left-inner">
            <div class="panel-top">
                <div class="panel-title">Pilih tempat Parkir</div>
                <div class="panel-subtitle" id="panelSubtitle">Zone A · Parkir Mall BTM</div>
            </div>

            {{-- Tab Zona --}}
            <div id="zonaTabs" style="display:flex; gap:8px; margin-bottom:16px; flex-shrink:0;"></div>

            {{-- Label Lantai --}}
            <div id="lantaiLabel" style="
                font-size:11px;
                font-weight:700;
                color:var(--text-muted);
                font-family:'DM Mono',monospace;
                letter-spacing:0.06em;
                text-transform:uppercase;
                margin-bottom:12px;
                flex-shrink:0;
            "></div>

            <div class="slot-grid" id="slotGrid"></div>

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
                    <div class="booking-detail-value green">Rp3.300/Jam</div>
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
                        <span id="ticketPrice">Rp3.300</span>/jam
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


        <input class="formulir-input"
            type="text"
            placeholder="Konfirmasi nama anda."
            id="inputNama"
            value="{{ $user->nama ?? '' }}"
            readonly>

        <input class="formulir-input"
            type="text"
            placeholder="Masukan plat nomor."
            id="inputPlat"
            value="{{ strtoupper($kendaraan->plat_nomor ?? '') }}"
            readonly>

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
                <span class="summary-value">Rp 3.300/Jam</span>
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

            {{-- PAYMENT VIEW (muncul setelah klik Selanjutnya di formulir) --}}
<div id="viewPayment" style="display:none;">
    <div class="formulir-wrap">

        <div class="payment-header">
            <div class="payment-main-title">Pilih<br>pembayaran</div>
            <div class="payment-icon-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
        </div>

        {{-- Kartu / E-Wallet --}}
        <div>
            <div class="payment-section-title">
                Kartu
                <span class="payment-tag green">+ Top up</span>
            </div>
            <div class="payment-method-list" style="max-height: unset;">
                <div class="payment-item" id="pay-wallet" onclick="selectPayment('wallet')">
                    <div class="payment-item-logo wallet">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:20px;height:20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div class="payment-item-info">
                        <div class="payment-item-name">IDR 2.000</div>
                        <div class="payment-item-sub">Account</div>
                    </div>
                    <div class="payment-item-check"></div>
                </div>
            </div>
        </div>

        {{-- Kartu Kredit --}}
        <div>
            <div class="payment-section-title">
                Kartu Kredit
                <span class="payment-tag blue">+ Tambah</span>
            </div>
            <div class="payment-method-list">
                <div class="payment-item" id="pay-bca" onclick="selectPayment('bca')">
                    <div class="payment-item-logo bca">
    <img src="{{ asset('images/logobca.png') }}" alt="BCA" style="width:100%;height:100%;object-fit:contain;border-radius:10px;">
</div>
                    <div class="payment-item-info">
                        <div class="payment-item-name">3056****5904</div>
                        <div class="payment-item-sub">Muhammad · 06/26</div>
                    </div>
                    <div class="payment-item-check"></div>
                </div>

                <div class="payment-item" id="pay-bri" onclick="selectPayment('bri')">
                    <div class="payment-item-logo bri">
    <img src="{{ asset('images/bri.png') }}" alt="BRI" style="width:100%;height:100%;object-fit:contain;border-radius:10px;">
</div>
                    <div class="payment-item-info">
                        <div class="payment-item-name">5213****4854</div>
                        <div class="payment-item-sub">Muhammad · 06/26</div>
                    </div>
                    <div class="payment-item-check"></div>
                </div>

                <div class="payment-item" id="pay-dana" onclick="selectPayment('dana')">
                    <div class="payment-item-logo dana">
    <img src="{{ asset('images/dana.png') }}" alt="DANA" style="width:100%;height:100%;object-fit:contain;border-radius:10px;">
</div>
                    <div class="payment-item-info">
                        <div class="payment-item-name">0812****3456</div>
                        <div class="payment-item-sub">Muhammad · Dana</div>
                    </div>
                    <div class="payment-item-check"></div>
                </div>

                <div class="payment-item" id="pay-gopay" onclick="selectPayment('gopay')">
                    <div class="payment-item-logo gopay">
    <img src="{{ asset('images/gopay.png') }}" alt="GoPay" style="width:100%;height:100%;object-fit:contain;border-radius:10px;">
</div>
                    <div class="payment-item-info">
                        <div class="payment-item-name">0812****3456</div>
                        <div class="payment-item-sub">Muhammad · GoPay</div>
                    </div>
                    <div class="payment-item-check"></div>
                </div>
            </div>
        </div>

        <div class="payment-footer">
            <div class="payment-total-row">
                <div>
                    <div class="payment-total-label">Total</div>
                    <div class="payment-total-value" id="paymentTotal">Rp0</div>
                </div>
            </div>
            <button class="booking-btn" onclick="submitPayment()">
                Bayar Sekarang →
            </button>
        </div>

    </div>
</div>

{{-- PARKING TICKET DETAILS (muncul setelah klik Bayar Sekarang) --}}
<div id="viewParkingTicket" style="display:none;">
    <div class="formulir-wrap">

        <div class="ptd-header">
            <div class="ptd-main-title">Parking<br>ticket details</div>
            <div class="ptd-icon-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>

        {{-- Vehicle Card --}}
        <div class="ptd-vehicle-card">
            <div class="ptd-vehicle-icon" style="background:transparent;position:relative;padding:0;">
    <div style="
        width:44px;height:44px;
        border-radius:50%;
        background:#16a34a;
        display:flex;align-items:center;justify-content:center;
        position:relative;
    ">
        <span style="color:#fff;font-size:22px;font-weight:900;font-family:'Plus Jakarta Sans',sans-serif;">P</span>
        <div style="
            position:absolute;
            bottom:2px;right:2px;
            width:10px;height:10px;
            border-radius:50%;
            background:#ef4444;
            border:2px solid #fff;
        "></div>
    </div>
</div>
            <div style="flex:1;">
                <div class="ptd-vehicle-plate" id="ptdPlate">B 6797 OB</div>
                <div class="ptd-vehicle-type">BYD M6</div>
                <div class="ptd-vehicle-detail" id="ptdDetail">Zone A-012 · Parking Mall BTM · Muhammad</div>
            </div>
        </div>

        {{-- Log Activities --}}
        <div class="ptd-log">
            <div class="ptd-log-title">Log activities</div>
            <div class="ptd-log-list">
                <div class="ptd-log-item">
                    <div class="ptd-log-time" id="ptdLogIn">11:00</div>
                    <div class="ptd-log-date" id="ptdLogInDate">25/12/2026</div>
                </div>
                <div class="ptd-log-item">
                    <div class="ptd-log-time" id="ptdLogOut">13:00</div>
                    <div class="ptd-log-date" id="ptdLogOutDate">25/12/2026</div>
                </div>
            </div>
        </div>

        {{-- Payment Method --}}
        <div class="ptd-payment-card">
            <div class="ptd-payment-logo">
                <img id="ptdPaymentLogo" src="{{ asset('images/bca.png') }}" alt="Payment">
            </div>
            <div class="ptd-payment-info">
                <div class="ptd-payment-number" id="ptdPaymentNumber">3056****5904</div>
                <div class="ptd-payment-sub" id="ptdPaymentSub">Muhammad · 06/26</div>
            </div>
            <div class="ptd-payment-total">
                <div class="ptd-payment-total-label">Total</div>
                <div class="ptd-payment-total-value" id="ptdTotal">Rp. 6.600</div>
            </div>
            <div class="ptd-chevron">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        {{-- Confirm Button --}}
        <button class="booking-btn" onclick="konfirmasiPembayaran()">
            Konfirmasi Pembayaran
        </button>

    </div>
</div>

</div>

        {{-- INFO CARD (sebelum slot dipilih) --}}
<div class="info-card" id="infoCard">

    {{-- Lokasi Info --}}
    <div class="info-card-block">
        <div class="info-card-label">Lokasi Parkir</div>
        <div class="info-card-location">
            <div class="info-card-loc-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="info-card-loc-name" id="infoLocName">Mall BTM</div>
                <div class="info-card-loc-zone" id="infoLocZone">Zone A-C · Bogor</div>
            </div>
        </div>
        <div class="info-stat-grid">
            <div class="info-stat-item">
                <div class="info-stat-label">Tarif</div>
                <div class="info-stat-value">Rp3.300</div>
            </div>
            <div class="info-stat-item">
                <div class="info-stat-label">Per</div>
                <div class="info-stat-value">Jam</div>
            </div>
            <div class="info-stat-item">
                <div class="info-stat-label">Jam Buka</div>
                <div class="info-stat-value" style="font-size:12px;">06:00–22:00</div>
            </div>
            <div class="info-stat-item">
                <div class="info-stat-label">Status</div>
                <div class="info-stat-value green">Buka</div>
            </div>
        </div>
    </div>

    {{-- Tips --}}
    <div class="info-card-block">
        <div class="info-card-label">Tips Parkir</div>
        <div class="info-tips-list">
            <div class="info-tip-item">
                <div class="info-tip-dot"></div>
                Pilih slot yang paling dekat dengan pintu masuk mall.
            </div>
            <div class="info-tip-item">
                <div class="info-tip-dot"></div>
                Pastikan plat nomor kendaraan sesuai saat booking.
            </div>
            <div class="info-tip-item">
                <div class="info-tip-dot"></div>
                Simpan nomor tiket sebagai bukti reservasi kamu.
            </div>
        </div>
    </div>

    {{-- Hint --}}
    <div class="info-select-hint">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/>
        </svg>
        Pilih slot parkir di sebelah kiri
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
    btm: {
        name: 'Mall BTM (Bogor Trade Mall)',
        zone: 'Zone A', lat:  -6.60365122733893, lng: 106.79163356255708,
        floors: [
            { zone: 'Zone A', lantai: 'Lantai 1', slots: generateSlots('A', 12, [3, 7, 11]) },
            { zone: 'Zone B', lantai: 'Lantai 2', slots: generateSlots('B', 12, [1, 5, 9]) },
            { zone: 'Zone C', lantai: 'Lantai 3', slots: generateSlots('C', 12, [2, 8]) },
        ]
    },
    boxies: {
        name: 'Boxies 123 Mall',
        zone: 'Zone A', lat: -6.633461609000311, lng:  106.82287405222026,
        floors: [
            { zone: 'Zone A', lantai: 'Lantai 1', slots: generateSlots('A', 12, [1, 5, 9]) },
            { zone: 'Zone B', lantai: 'Lantai 2', slots: generateSlots('B', 12, [0, 4, 8, 11]) },
            { zone: 'Zone C', lantai: 'Lantai 3', slots: generateSlots('C', 12, [2, 6]) },
        ]
    },
    lippo: {
        name: 'Lippo Plaza Bogor',
        zone: 'Zone A', lat: -6.621343417155484, lng: 106.81717862668985,
        floors: [
            { zone: 'Zone A', lantai: 'Lantai 1', slots: generateSlots('A', 12, [2, 8]) },
            { zone: 'Zone B', lantai: 'Lantai 2', slots: generateSlots('B', 12, [3, 7]) },
            { zone: 'Zone C', lantai: 'Lantai 3', slots: generateSlots('C', 12, [1, 5, 10]) },
        ]
    },
    botani: {
        name: 'Botani Square',
        zone: 'Zone A', lat: -6.602185889697182, lng: 106.8059483290694,

        floors: [
            { zone: 'Zone A', lantai: 'Lantai 1', slots: generateSlots('A', 12, [0,1,2,3,4,5,6,7,8,9,10,11]) },
            { zone: 'Zone B', lantai: 'Lantai 2', slots: generateSlots('B', 12, [0,1,2,3,4,5,6,7,8,9,10,11]) },
            { zone: 'Zone C', lantai: 'Lantai 3', slots: generateSlots('C', 12, [0,1,2,3,4,5,6,7,8,9,10,11]) },
        ]
    },
        'cibinong city': {
            name: 'Cibinong City Mall',
            zone: 'Zone A', lat: -6.483499283438411, lng: 106.84133740539262,

            floors: [
                { zone: 'Zone A', lantai: 'Lantai 1', slots: generateSlots('A', 12, [2, 6, 10]) },
                { zone: 'Zone B', lantai: 'Lantai 2', slots: generateSlots('B', 12, [1, 5, 9]) },
                { zone: 'Zone C', lantai: 'Lantai 3', slots: generateSlots('C', 12, [3, 7, 11]) },
            ]
        },
    jambu2: {
        name: 'Jambu Dua Square',
        zone: 'Zone A', lat: -6.569423577334395, lng: 106.80803262616166,
        floors: [
            { zone: 'Zone A', lantai: 'Lantai 1', slots: generateSlots('A', 12, [0, 3, 7, 11]) },
            { zone: 'Zone B', lantai: 'Lantai 2', slots: generateSlots('B', 12, [1, 6, 10]) },
            { zone: 'Zone C', lantai: 'Lantai 3', slots: generateSlots('C', 12, [2, 5, 8]) },
        ]
    },
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

L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    attribution: '© OpenStreetMap © CARTO',
    maxZoom: 19
}).addTo(map);

        // Marker lokasi saat ini
        const markerHtml = `
            <div style="
                width:36px;height:36px;
                border-radius:50% 50% 50% 0;
                transform:rotate(-45deg);
                background:linear-gradient(135deg,#1eff00,#1eff00);
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
let activeFloorIndex = 0;
let selectedSlot = null;

document.getElementById('panelSubtitle').textContent = currentLoc.name;
document.getElementById('bookingLocation').textContent = currentLoc.name;
document.getElementById('infoLocName').textContent = currentLoc.name;
document.getElementById('infoLocZone').textContent = `${currentLoc.zone} · Bogor`;

function renderZonaTabs() {
    const tabs = document.getElementById('zonaTabs');
    if (!currentLoc.floors || currentLoc.floors.length <= 1) {
        tabs.style.display = 'none';
        return;
    }
    tabs.innerHTML = currentLoc.floors.map((floor, i) => `
        <button class="zona-tab ${i === activeFloorIndex ? 'active' : ''}"
                onclick="switchFloor(${i})">
            ${floor.zone}<br>
            <span style="font-size:10px;font-weight:500;">${floor.lantai}</span>
        </button>
    `).join('');
}

function switchFloor(index) {
    activeFloorIndex = index;
    selectedSlot = null;
    document.getElementById('selectedLabel').textContent = '—';
    document.getElementById('panelRight').classList.remove('active');
    document.getElementById('infoCard').classList.remove('hidden');
    renderZonaTabs();
    renderCurrentFloor();
}

function renderCurrentFloor() {
    const floor = currentLoc.floors[activeFloorIndex];
    document.getElementById('lantaiLabel').textContent = `${floor.zone} · ${floor.lantai}`;
    renderSlots(floor.slots);
}

function renderSlots(slots) {
    const grid = document.getElementById('slotGrid');
    grid.innerHTML = slots.map(slot => `
        <div class="slot-card ${slot.occupied ? 'occupied' : ''}"
             id="slot-${slot.id}" onclick="selectSlot('${slot.id}')">
            <div class="slot-card-id">${slot.id}</div>
            <div class="slot-card-status">${slot.occupied ? 'Penuh' : 'Kosong'}</div>
        </div>
    `).join('');
}

renderZonaTabs();
renderCurrentFloor();

if (preselected) {
    setTimeout(() => selectSlot(preselected), 100);
}

// ── SELECT SLOT ──

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
            // Sembunyikan info card saat slot dipilih
            document.getElementById('infoCard').classList.add('hidden');
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

    // Pindah ke payment view
    const formulir = document.getElementById('viewFormulir');
    const payment  = document.getElementById('viewPayment');

    formulir.style.transition = 'opacity 0.25s';
    formulir.style.opacity = '0';

    setTimeout(() => {
        formulir.style.display = 'none';
        payment.style.display  = 'block';
        payment.style.opacity  = '0';
        payment.style.transition = 'opacity 0.25s';

        // Sync total dari formulir ke payment
        document.getElementById('paymentTotal').textContent =
            document.getElementById('footerTotal').textContent;

        requestAnimationFrame(() => {
            payment.style.opacity = '1';
        });
    }, 250);
}

let selectedPaymentMethod = null;

function selectPayment(method) {
    // Hapus selected sebelumnya
    document.querySelectorAll('.payment-item').forEach(el => {
        el.classList.remove('selected');
    });

    selectedPaymentMethod = method;
    document.getElementById(`pay-${method}`).classList.add('selected');
}

function submitPayment() {
    if (!selectedPaymentMethod) {
        alert('Pilih metode pembayaran dulu!');
        return;
    }

    const payment  = document.getElementById('viewPayment');
    const ptd      = document.getElementById('viewParkingTicket');

    // Ambil data dari form sebelumnya
    const plat  = document.getElementById('inputPlat').value;
    const awal  = document.getElementById('inputJamAwal').value;
    const akhir = document.getElementById('inputJamAkhir').value;
    const nama  = document.getElementById('inputNama').value;
    const total = document.getElementById('footerTotal').textContent;

    // Isi data ke parking ticket
    document.getElementById('ptdPlate').textContent   = plat;
    document.getElementById('ptdDetail').textContent  =
        `${currentLoc.zone} · ${selectedSlot} · ${currentLoc.name} · ${nama}`;
    document.getElementById('ptdLogIn').textContent   = awal;
    document.getElementById('ptdLogOut').textContent  = akhir;
    document.getElementById('ptdTotal').textContent   = total;

    // Set tanggal hari ini
    const today = new Date();
    const tgl = `${today.getDate().toString().padStart(2,'0')}/${(today.getMonth()+1).toString().padStart(2,'0')}/${today.getFullYear()}`;
    document.getElementById('ptdLogInDate').textContent  = tgl;
    document.getElementById('ptdLogOutDate').textContent = tgl;

    // Set logo & info payment
    const paymentMap = {
        wallet: { logo: '', number: 'IDR 2.000',      sub: 'Account' },
        bca:    { logo: "{{ asset('images/logobca.png') }}",   number: '3056****5904', sub: 'Muhammad · 06/26' },
        bri:    { logo: "{{ asset('images/bri.png') }}",   number: '5213****4854', sub: 'Muhammad · 06/26' },
        dana:   { logo: "{{ asset('images/dana.png') }}",  number: '0812****3456', sub: 'Muhammad · Dana' },
        gopay:  { logo: "{{ asset('images/gopay.png') }}", number: '0812****3456', sub: 'Muhammad · GoPay' },
    };

    const pm = paymentMap[selectedPaymentMethod];
    document.getElementById('ptdPaymentLogo').src            = pm.logo;
    document.getElementById('ptdPaymentNumber').textContent  = pm.number;
    document.getElementById('ptdPaymentSub').textContent     = pm.sub;

    // Fade transition
    payment.style.transition = 'opacity 0.25s';
    payment.style.opacity = '0';

    setTimeout(() => {
        payment.style.display = 'none';
        ptd.style.display     = 'block';
        ptd.style.opacity     = '0';
        ptd.style.transition  = 'opacity 0.25s';
        requestAnimationFrame(() => {
            ptd.style.opacity = '1';
        });
    }, 250);
}

function konfirmasiPembayaran() {
    // window.location.href =
    //     `/booking/success?slot=${encodeURIComponent(selectedSlot)}&location=${encodeURIComponent(locationId)}&payment=${encodeURIComponent(selectedPaymentMethod)}`;
    window.location.href =
        `/succes`;
}


const isMobile = () => window.innerWidth <= 768;

const panelLeft   = document.getElementById('panelLeft');
const panelRight  = document.getElementById('panelRight');
const overlay     = document.getElementById('mobileOverlay');

/* ─── Tampilkan overlay mobile ─── */
function showMobileOverlay() {
    overlay.style.display = 'block';
    requestAnimationFrame(() => overlay.classList.add('visible'));
}

function hideMobileOverlay() {
    overlay.classList.remove('visible');
    setTimeout(() => { overlay.style.display = 'none'; }, 350);
}

/* ─── Tutup panel kanan (mobile) ─── */
function closeMobilePanel() {
    if (!isMobile()) return;
    panelRight.classList.remove('active', 'mobile-fullscreen');
    panelLeft.classList.remove('mobile-hidden');
    hideMobileOverlay();

    // Reset ke viewBooking
    resetToBookingView();
}

/* ─── Reset semua view ke state awal ─── */
function resetToBookingView() {
    ['viewTicket','viewFormulir','viewPayment','viewParkingTicket'].forEach(id => {
        const el = document.getElementById(id);
        el.style.display = 'none';
        el.style.opacity = '1';
    });
    const booking = document.getElementById('viewBooking');
    booking.style.display = 'block';
    booking.style.opacity = '1';
}

/* ─── Tombol kembali ke slot dari fullscreen ─── */
function mobileBackToSlot() {
    if (!isMobile()) return;
    panelRight.classList.remove('mobile-fullscreen');
    panelLeft.classList.remove('mobile-hidden');
    // Kembali ke view booking (bottom sheet)
    resetToBookingView();
    // Tetap tampilkan bottom sheet
    showMobileOverlay();
}

/* ══════════════════════════════════════════
   OVERRIDE: selectSlot — tambah mobile behavior
   ══════════════════════════════════════════ */
const _origSelectSlot = selectSlot; // simpan asli jika ada
// Override selectSlot dengan tambahan mobile logic
// (Ganti fungsi selectSlot yang sudah ada dengan ini)
function selectSlot(slotId) {
    document.querySelectorAll('.slot-card.selected')
        .forEach(el => el.classList.remove('selected'));

    const card = document.getElementById(`slot-${slotId}`);
    if (!card || card.classList.contains('occupied')) return;

    card.classList.add('selected');
    selectedSlot = slotId;

    document.getElementById('selectedLabel').textContent = slotId;
    document.getElementById('bookingSlotCode').textContent = slotId;

    const now = new Date();
    const jam = now.getHours().toString().padStart(2, '0');
    const mnt = now.getMinutes().toString().padStart(2, '0');
    document.getElementById('bookingTime').textContent = `${jam}:${mnt} Kedepan`;

    // Desktop: seperti biasa
    document.getElementById('panelRight').classList.add('active');
    document.getElementById('infoCard').classList.add('hidden');

    // Mobile: tampilkan sebagai bottom sheet
    if (isMobile()) {
        panelRight.classList.remove('mobile-fullscreen');
        showMobileOverlay();
    }
}

/* ══════════════════════════════════════════
   OVERRIDE: submitBooking — tambah mobile fullscreen
   ══════════════════════════════════════════ */
const _origSubmitBooking = submitBooking;
function submitBooking() {
    if (!selectedSlot) return;

    const now = new Date();
    const jam = now.getHours().toString().padStart(2, '0');
    const mnt = now.getMinutes().toString().padStart(2, '0');

    document.getElementById('ticketSlotZone').textContent =
        `${currentLoc.zone} · ${selectedSlot}`;
    document.getElementById('ticketTime').textContent =
        `${jam}:${mnt} – 23:59`;
    document.getElementById('ticketSerial').textContent =
        'No. ' + Math.floor(Math.random() * 900 + 100);

    // Mobile: masuk fullscreen mode
    if (isMobile()) {
        panelLeft.classList.add('mobile-hidden');
        panelRight.classList.add('mobile-fullscreen');
        hideMobileOverlay();
    }

    const booking = document.getElementById('viewBooking');
    const ticket  = document.getElementById('viewTicket');

    booking.style.transition = 'opacity 0.25s';
    booking.style.opacity = '0';
    setTimeout(() => {
        booking.style.display = 'none';
        ticket.style.display  = 'block';
        ticket.style.opacity  = '0';
        ticket.style.transition = 'opacity 0.25s';
        requestAnimationFrame(() => { ticket.style.opacity = '1'; });
    }, 250);
}

/* ══════════════════════════════════════════
   OVERRIDE: goToConfirm, submitFormulir,
             submitPayment — pastikan tetap fullscreen
   ══════════════════════════════════════════ */
function goToConfirm() {
    // Mobile: pastikan fullscreen
    if (isMobile()) {
        panelLeft.classList.add('mobile-hidden');
        panelRight.classList.add('mobile-fullscreen');
    }

    const ticket   = document.getElementById('viewTicket');
    const formulir = document.getElementById('viewFormulir');

    ticket.style.transition = 'opacity 0.25s';
    ticket.style.opacity = '0';
    setTimeout(() => {
        ticket.style.display   = 'none';
        formulir.style.display = 'block';
        formulir.style.opacity = '0';
        formulir.style.transition = 'opacity 0.25s';
        requestAnimationFrame(() => { formulir.style.opacity = '1'; });
    }, 250);
}

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
        requestAnimationFrame(() => { ticket.style.opacity = '1'; });
    }, 250);
}

function submitFormulir() {
    const nama  = document.getElementById('inputNama').value;
    const plat  = document.getElementById('inputPlat').value;
    const awal  = document.getElementById('inputJamAwal').value;
    const akhir = document.getElementById('inputJamAkhir').value;

    if (!nama || !plat || !awal || !akhir) {
        alert('Lengkapi semua data terlebih dahulu!');
        return;
    }

    if (isMobile()) {
        panelLeft.classList.add('mobile-hidden');
        panelRight.classList.add('mobile-fullscreen');
    }

    const formulir = document.getElementById('viewFormulir');
    const payment  = document.getElementById('viewPayment');

    formulir.style.transition = 'opacity 0.25s';
    formulir.style.opacity = '0';
    setTimeout(() => {
        formulir.style.display = 'none';
        payment.style.display  = 'block';
        payment.style.opacity  = '0';
        payment.style.transition = 'opacity 0.25s';
        document.getElementById('paymentTotal').textContent =
            document.getElementById('footerTotal').textContent;
        requestAnimationFrame(() => { payment.style.opacity = '1'; });
    }, 250);
}

function submitPayment() {
    if (!selectedPaymentMethod) {
        alert('Pilih metode pembayaran dulu!');
        return;
    }

    const payment = document.getElementById('viewPayment');
    const ptd     = document.getElementById('viewParkingTicket');

    const plat  = document.getElementById('inputPlat').value;
    const awal  = document.getElementById('inputJamAwal').value;
    const akhir = document.getElementById('inputJamAkhir').value;
    const nama  = document.getElementById('inputNama').value;
    const total = document.getElementById('footerTotal').textContent;

    document.getElementById('ptdPlate').textContent  = plat;
    document.getElementById('ptdDetail').textContent =
        `${currentLoc.zone} · ${selectedSlot} · ${currentLoc.name} · ${nama}`;
    document.getElementById('ptdLogIn').textContent  = awal;
    document.getElementById('ptdLogOut').textContent = akhir;
    document.getElementById('ptdTotal').textContent  = total;

    const today = new Date();
    const tgl = `${today.getDate().toString().padStart(2,'0')}/${(today.getMonth()+1).toString().padStart(2,'0')}/${today.getFullYear()}`;
    document.getElementById('ptdLogInDate').textContent  = tgl;
    document.getElementById('ptdLogOutDate').textContent = tgl;

    const paymentMap = {
        wallet: { logo: '', number: 'IDR 2.000', sub: 'Account' },
        bca:    { logo: "{{ asset('images/logobca.png') }}", number: '3056****5904', sub: 'Muhammad · 06/26' },
        bri:    { logo: "{{ asset('images/bri.png') }}",    number: '5213****4854', sub: 'Muhammad · 06/26' },
        dana:   { logo: "{{ asset('images/dana.png') }}",   number: '0812****3456', sub: 'Muhammad · Dana' },
        gopay:  { logo: "{{ asset('images/gopay.png') }}",  number: '0812****3456', sub: 'Muhammad · GoPay' },
    };

    const pm = paymentMap[selectedPaymentMethod];
    document.getElementById('ptdPaymentLogo').src           = pm.logo;
    document.getElementById('ptdPaymentNumber').textContent = pm.number;
    document.getElementById('ptdPaymentSub').textContent    = pm.sub;

    if (isMobile()) {
        panelLeft.classList.add('mobile-hidden');
        panelRight.classList.add('mobile-fullscreen');
    }

    payment.style.transition = 'opacity 0.25s';
    payment.style.opacity = '0';
    setTimeout(() => {
        payment.style.display = 'none';
        ptd.style.display     = 'block';
        ptd.style.opacity     = '0';
        ptd.style.transition  = 'opacity 0.25s';
        requestAnimationFrame(() => { ptd.style.opacity = '1'; });
    }, 250);
}

/* ── Resize handler: reset mobile state kalau balik ke desktop ── */
window.addEventListener('resize', () => {
    if (!isMobile()) {
        overlay.style.display = 'none';
        overlay.classList.remove('visible');
        panelLeft.classList.remove('mobile-hidden');
        panelRight.classList.remove('mobile-fullscreen');
    }
});


    </script>
</body>
</html>