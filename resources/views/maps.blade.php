<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Parkir - Peta Lokasi</title>

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

        /* ── CUSTOM MARKER ── */
        .custom-marker {
            width: 36px; height: 36px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.4);
            cursor: pointer;
            transition: transform 0.2s;
        }
        .custom-marker.available {
    background: linear-gradient(135deg, #1eff00, #1eff00);
    border: 2px solid rgba(255,255,255,0.3);
}
        .custom-marker.full {
            background: linear-gradient(135deg, #f87171, #dc2626);
            border: 2px solid rgba(255,255,255,0.3);
        }
        .custom-marker-inner {
            transform: rotate(45deg);
            font-size: 14px;
        }

        /* ── POPUP ── */
        .leaflet-popup-content-wrapper {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            border-radius: var(--radius) !important;
            box-shadow: var(--shadow) !important;
            padding: 0 !important;
        }
        .leaflet-popup-content {
            margin: 0 !important;
            padding: 20px !important;
            min-width: 220px;
        }
        .leaflet-popup-tip {
            background: var(--surface) !important;
        }
        .leaflet-popup-close-button {
            color: var(--text-muted) !important;
            font-size: 18px !important;
            top: 10px !important;
            right: 14px !important;
        }

        .popup-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 100px;
            margin-bottom: 10px;
        }
        .popup-badge.available { background: rgba(74,222,128,0.15); color: var(--accent); }
        .popup-badge.full { background: rgba(248,113,113,0.15); color: #f87171; }

        .popup-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }
        .popup-desc {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 14px;
        }
        .popup-slots {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
        }
        .popup-slots-count {
            font-family: 'DM Mono', monospace;
            font-size: 22px;
            font-weight: 500;
            color: var(--accent);
        }
        .popup-slots-label {
            font-size: 11px;
            color: var(--text-muted);
            line-height: 1.3;
        }
        .popup-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(135deg, var(--accent), #000000);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.02em;
        }
        .popup-btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .popup-btn.disabled {
            background: var(--surface2);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        /* ── SLOT SHEET ── */
        .slot-sheet {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            z-index: 200;
            background: var(--surface);
            border-top: 1px solid var(--border);
            border-radius: 28px 28px 0 0;
            padding: 28px 28px 40px;
            box-shadow: 0 -24px 64px rgba(0,0,0,0.7);

            transform: translateY(100%);
            transition: transform 0.45s cubic-bezier(0.32, 0.72, 0, 1);
            max-height: 85vh;
            overflow-y: auto;
        }
        .slot-sheet.active { transform: translateY(0); }

        .sheet-handle {
            width: 40px; height: 4px;
            background: var(--border);
            border-radius: 100px;
            margin: 0 auto 24px;
        }

        .sheet-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .sheet-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
        }
        .sheet-close {
            width: 32px; height: 32px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 18px;
            line-height: 1;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .sheet-close:hover { background: var(--surface); color: var(--text); }

        .sheet-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 24px;
            font-family: 'DM Mono', monospace;
            letter-spacing: 0.04em;
        }

        .slot-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .slot-card {
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 16px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
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
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }
        .slot-card-id {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 4px;
        }
        .slot-card-status {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent);
        }
        .slot-card.occupied .slot-card-status { color: #f87171; }

        .sheet-footer {
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sheet-footer-info {
            font-size: 12px;
            color: var(--text-muted);
        }
        .sheet-footer-info span {
            color: var(--accent);
            font-weight: 700;
        }
        .book-btn {
            padding: 12px 28px;
            background: linear-gradient(135deg, var(--accent), #ffffff);
            color: #0f1117;
            border: none;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .book-btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .book-btn:disabled {
            background: var(--surface2);
            color: var(--text-muted);
            cursor: not-allowed;
            transform: none;
        }

        /* ── OVERLAY ── */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 150;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
            backdrop-filter: blur(4px);
        }
        .overlay.active { opacity: 1; pointer-events: all; }

/* ── DETAIL PANEL ── */
.detail-panel {
    position: fixed;
    top: 0;
    right: 0;
    width: 340px;
    height: 100%;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(24px);
    border-left: 1px solid var(--border);
    z-index: 200;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.45s cubic-bezier(0.32, 0.72, 0, 1);
    box-shadow: -4px 0 40px rgba(0,0,0,0.5);
    overflow: hidden;
}
.detail-panel.active {
    transform: translateX(0);
}

/* ── CAROUSEL ── */
.carousel-wrap {
    position: relative;
    width: 100%;
    height: 220px;
    flex-shrink: 0;
    overflow: hidden;
    background: var(--surface2);
}

.carousel-track {
    display: flex;
    height: 100%;
    transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1);
}

.carousel-slide {
    min-width: 100%;
    height: 100%;
    object-fit: cover;
    flex-shrink: 0;
}

.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.carousel-btn:hover { background: #fff; transform: translateY(-50%) scale(1.05); }
.carousel-btn svg { width: 16px; height: 16px; color: #1a1d27; }
.carousel-btn.prev { left: 12px; }
.carousel-btn.next { right: 12px; }

.carousel-dots {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 6px;
}

.carousel-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: all 0.2s;
}

.carousel-dot.active {
    background: #fff;
    width: 18px;
    border-radius: 100px;
}

.carousel-close {
    position: absolute;
    top: 12px;
    left: 12px;
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: all 0.2s;
}

.carousel-close:hover { background: #fff; }
.carousel-close svg { width: 16px; height: 16px; color: #1a1d27; }

/* ── DETAIL CONTENT ── */
.detail-content {
    padding: 24px;
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.detail-content::-webkit-scrollbar { width: 4px; }
.detail-content::-webkit-scrollbar-track { background: transparent; }
.detail-content::-webkit-scrollbar-thumb { background: var(--border); border-radius: 100px; }

.detail-name {
    font-size: 20px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
    margin-bottom: 6px;
}

.detail-rating {
    display: flex;
    align-items: center;
    gap: 6px;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    font-size: 14px;
}

.rating-value {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
}

.rating-count {
    font-size: 12px;
    color: var(--text-muted);
}

.detail-desc {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.7;
}

.detail-slots-card {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.detail-slots-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.detail-slots-icon {
    width: 36px;
    height: 36px;
    background: rgba(74,222,128,0.15);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.detail-slots-icon svg {
    width: 18px;
    height: 18px;
    color: var(--accent);
}

.detail-slots-label {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 2px;
}

.detail-slots-count {
    font-size: 18px;
    font-weight: 800;
    color: var(--accent);
    font-family: 'DM Mono', monospace;
}

.detail-slots-total {
    font-size: 11px;
    color: var(--text-muted);
}

.detail-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.detail-info-item {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px 14px;
}

.detail-info-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 4px;
}

.detail-info-value {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
}

.detail-footer {
    padding: 20px 24px;
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}

.detail-book-btn {
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
}

.detail-book-btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(74,222,128,0.25);
}

.detail-book-btn:disabled {
    background: var(--surface2);
    color: var(--text-muted);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
        /* Detail content */
        .ds-body {
            padding: 24px 24px 36px;
        }
        .ds-handle {
            width: 40px; height: 4px;
            background: var(--border);
            border-radius: 100px;
            margin: 0 auto 20px;
        }
        .ds-top-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .ds-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            flex: 1;
            padding-right: 12px;
            line-height: 1.3;
        }
        .ds-close {
            width: 32px; height: 32px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 18px; line-height: 1;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .ds-close:hover { background: var(--border); color: var(--text); }

        .ds-zone {
            font-size: 11px;
            font-family: 'DM Mono', monospace;
            color: var(--text-muted);
            letter-spacing: 0.04em;
            margin-bottom: 14px;
        }

        /* Stats row */
        .ds-stats {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }
        .ds-stat {
            flex: 1;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px 14px;
        }
        .ds-stat-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 4px;
        }
        .ds-stat-value {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
            font-family: 'DM Mono', monospace;
        }
        .ds-stat-value.green { color: #ffffff; }
        .ds-stat-value.red { color: #dc2626; }

        /* Rating stars */
        .ds-rating-stars {
            display: flex;
            gap: 2px;
            margin-top: 2px;
        }
        .ds-star { font-size: 13px; }

        /* Description */
        .ds-desc-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 8px;
        }
        .ds-desc {
            font-size: 13px;
            color: var(--text);
            line-height: 1.7;
            margin-bottom: 22px;
        }

        /* Facilities tags */
        .ds-facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 22px;
        }
        .ds-tag {
            display: flex;
            align-items: center;
            gap: 5px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 5px 12px;
            font-size: 11px;
            font-weight: 600;
            color: var(--text);
        }

        /* CTA button */
        .ds-cta {
            width: 100%;
            padding: 15px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.01em;
        }
        .ds-cta:hover { opacity: 0.88; transform: translateY(-1px); }
        .ds-cta.full {
            background: var(--surface2);
            color: var(--text-muted);
            cursor: not-allowed;
        }
        .ds-cta.full:hover { transform: none; opacity: 1; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 100px; }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            .ds-carousel { height: 180px; }
            .ds-body { padding: 20px 16px 32px; }
            .ds-name { font-size: 17px; }
            .ds-stats { gap: 8px; }
            .ds-stat { padding: 10px 12px; }
            .ds-stat-value { font-size: 16px; }
            .slot-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
            .sheet-footer { flex-direction: column; gap: 10px; }
            .book-btn { width: 100%; padding: 14px; }
        }
    </style>
</head>
<body>

    {{-- Header Pill --}}
    <div class="header-pill">
        <div class="dot"></div>
        <span>e-Parkir · Bogor</span>
    </div>

    {{-- Back Button --}}
    <a href="{{ url('/') }}" class="back-btn">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    {{-- Map --}}
    <div id="map"></div>

    {{-- Overlay --}}
    <div class="overlay" id="overlay" onclick="closeAll()"></div>

{{-- DETAIL PANEL --}}
<div class="detail-panel" id="detailPanel">

    {{-- Carousel --}}
    <div class="carousel-wrap">
        <div class="carousel-track" id="carouselTrack"></div>

        <button class="carousel-close" onclick="closeDetail()">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button class="carousel-btn prev" onclick="carouselPrev()">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button class="carousel-btn next" onclick="carouselNext()">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <div class="carousel-dots" id="carouselDots"></div>
    </div>

    {{-- Content --}}
    <div class="detail-content">
        <div>
            <div class="detail-name" id="detailName">Mall BTM</div>
            <div class="detail-rating">
                <div class="stars" id="detailStars"></div>
                <span class="rating-value" id="detailRatingValue">4.5</span>
                <span class="rating-count" id="detailRatingCount">(128 ulasan)</span>
            </div>
        </div>

        <div class="detail-desc" id="detailDesc">Deskripsi lokasi parkir.</div>

        <div class="detail-slots-card">
            <div class="detail-slots-left">
                <div class="detail-slots-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div>
                    <div class="detail-slots-label">Slot Tersedia</div>
                    <div class="detail-slots-count" id="detailSlotsAvail">0</div>
                </div>
            </div>
            <div class="detail-slots-total" id="detailSlotsTotal">dari 0 slot</div>
        </div>

        <div class="detail-info-grid">
            <div class="detail-info-item">
                <div class="detail-info-label">Zona</div>
                <div class="detail-info-value" id="detailZone">Zone A - Zona C</div>
            </div>
            <div class="detail-info-item">
                <div class="detail-info-label">Tarif</div>
                <div class="detail-info-value">Rp3.000/jam</div>
            </div>
            <div class="detail-info-item">
                <div class="detail-info-label">Jam Buka</div>
                <div class="detail-info-value">06:00 – 22:00</div>
            </div>
            <div class="detail-info-item">
                <div class="detail-info-label">Status</div>
                <div class="detail-info-value" id="detailStatus">Buka</div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="detail-footer">
        <button class="detail-book-btn" id="detailBookBtn" onclick="goToBooking()">
            Pesan Parkir Sekarang →
        </button>
    </div>

</div>    <

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // ── MAP INIT ──
        const map = L.map('map', {
            center: [-6.5971, 106.8060],
            zoom: 14,
            zoomControl: false,
        });

L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    attribution: '© OpenStreetMap © CARTO',
    maxZoom: 19
}).addTo(map);

        // Custom zoom control (bottom right)
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // ── LOKASI PARKIR BOGOR ──
const locations = [
    {
        id: 'btm',
        name: 'Mall BTM (Bogor Trade Mall)',
        desc: 'Pusat perbelanjaan terbesar di tengah kota Bogor, dekat Kebun Raya.',
        lat:  -6.60365122733893, lng: 106.79163356255708,
        zone: 'Zone A-C',
        available: 34,
        total: 60,
        rating: 4.5,
        reviewCount: 128,
        // ── GANTI FOTO DI SINI ──
        photos: [
            '/images/btm-1.jpg',
            '/images/btm-2.jpg',
            '/images/btm-3.jpg',
        ],
        slots: generateSlots('A', 12, [3, 7, 11])
    },
    {
        id: 'boxies',
        name: 'Boxies 123 Mall',
        desc: 'Mall modern di Tajur dengan konsep outdoor dan akses tol Jagorawi.',
        lat: -6.633461609000311, lng:  106.82287405222026,
        zone: 'Zone A-C',
        available: 18,
        total: 50,
        rating: 4.2,
        reviewCount: 95,
        // ── GANTI FOTO DI SINI ──
        photos: [
            '/images/boxies-1.jpg',
            '/images/boxies-2.jpg',
            '/images/boxies-3.jfif',
        ],
        slots: generateSlots('B', 12, [1, 5, 9, 12])
    },
    {
        id: 'lippo',
        name: 'Lippo Plaza Bogor',
        desc: 'Mall premium kawasan Bogor Selatan, lengkap dengan bioskop dan restoran.',
        lat: -6.621343417155484, lng: 106.81717862668985,
        zone: 'Zone A-C',
        available: 41,
        total: 50,
        rating: 4.7,
        reviewCount: 210,
        // ── GANTI FOTO DI SINI ──
        photos: [
            '/images/lippo-1.jpg',
            '/images/lippo-2.jpg',
            '/images/lippo-3.jpg',
        ],
        slots: generateSlots('C', 12, [2, 8])
    },
    {
        id: 'botani',
        name: 'Botani Square',
        desc: 'Mall keluarga di dekat Kebun Raya Bogor, mudah diakses dari pusat kota.',
        lat: -6.602185889697182, lng: 106.8059483290694,
        zone: 'Zone A-C',
        available: 0,
        total: 40,
        rating: 4.3,
        reviewCount: 176,
        // ── GANTI FOTO DI SINI ──
        photos: [
            '/images/botani-1.webp',
            '/images/botani-2.jpg',
            '/images/botani-3.avif',
        ],
        slots: generateSlots('D', 12, [0,1,2,3,4,5,6,7,8,9,10,11])
    },
    {
        id: 'cibinong city',
        name: 'Cibinong City Mall',
        desc: 'Pusat perbelanjaan terbesar di Cibinong, lengkap dengan berbagai tenant dan hiburan keluarga.',
        lat: -6.483499283438411, lng: 106.84133740539262,
        zone: 'Zone A-C',
        available: 22,
        total: 45,
        rating: 4.1,
        reviewCount: 89,
        // ── GANTI FOTO DI SINI ──
        photos: [
            '/images/cibinong-1.webp',
            '/images/cibinong-2.jpg',
            '/images/cibinong-3.jpg',
        ],
        slots: generateSlots('E', 12, [4, 6, 10])
    },
    {
        id: 'jambu2',
        name: 'Jambu Dua Square',
        desc: 'Mall di utara Bogor, kawasan Warung Jambu, mudah akses dari Jabodetabek.',
        lat: -6.569423577334395, lng: 106.80803262616166,
        zone: 'Zone A-C ',
        available: 15,
        total: 40,
        rating: 4.0,
        reviewCount: 67,
        // ── GANTI FOTO DI SINI ──
        photos: [
            '/images/jambu2-1.jpg',
            '/images/jambu2-2.jpg',
            '/images/jambu2-3.jpg',
        ],
        slots: generateSlots('F', 12, [0, 3, 7, 11])
    },
];

        function generateSlots(zoneCode, count, occupiedIndexes) {
            return Array.from({ length: count }, (_, i) => ({
                id: `${zoneCode}-${String(i + 1).padStart(3, '0')}`,
                occupied: occupiedIndexes.includes(i)
            }));
        }

// ── SELECTED STATE ──
let selectedSlot = null;
let currentLocation = null;
let carouselIndex = 0;

// ── STARS HELPER ──
function renderStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= Math.floor(rating)) {
            stars += '<span class="star" style="color:#f59e0b;">★</span>';
        } else if (i - rating < 1) {
            stars += '<span class="star" style="color:#f59e0b;">½</span>';
        } else {
            stars += '<span class="star" style="color:#d1d5db;">★</span>';
        }
    }
    return stars;
}

// ── CREATE MARKERS ──
locations.forEach(loc => {
    const isAvailable = loc.available > 0;

    const markerHtml = `
        <div class="custom-marker ${isAvailable ? 'available' : 'full'}">
            <div class="custom-marker-inner">${isAvailable ? '🅿' : '✕'}</div>
        </div>`;

    const icon = L.divIcon({
        html: markerHtml,
        className: '',
        iconSize: [36, 36],
        iconAnchor: [18, 36],
    });

    const marker = L.marker([loc.lat, loc.lng], { icon }).addTo(map);
    marker.on('click', () => openDetail(loc.id));
});

// ── OPEN DETAIL PANEL ──
function openDetail(locId) {
    currentLocation = locations.find(l => l.id === locId);
    if (!currentLocation) return;

    const loc = currentLocation;
    carouselIndex = 0;

    // Isi konten
    document.getElementById('detailName').textContent         = loc.name;
    document.getElementById('detailStars').innerHTML          = renderStars(loc.rating);
    document.getElementById('detailRatingValue').textContent  = loc.rating.toFixed(1);
    document.getElementById('detailRatingCount').textContent  = `(${loc.reviewCount} ulasan)`;
    document.getElementById('detailDesc').textContent         = loc.desc;
    document.getElementById('detailSlotsAvail').textContent   = loc.available;
    document.getElementById('detailSlotsTotal').textContent   = `dari ${loc.total} slot`;
    document.getElementById('detailZone').textContent         = loc.zone;
    document.getElementById('detailStatus').textContent       = loc.available > 0 ? 'Buka' : 'Penuh';
    document.getElementById('detailStatus').style.color       = loc.available > 0 ? 'var(--accent)' : '#f87171';

    // Tombol booking
    const bookBtn = document.getElementById('detailBookBtn');
    bookBtn.disabled = loc.available === 0;
    bookBtn.textContent = loc.available > 0 ? 'Pesan Parkir Sekarang →' : 'Slot Penuh';

    // Render carousel
    const track = document.getElementById('carouselTrack');
    const dots  = document.getElementById('carouselDots');

    track.innerHTML = loc.photos.map(photo => `
        <img class="carousel-slide" src="${photo}" alt="${loc.name}"
             onerror="this.style.background='var(--surface2)';this.src='';">
    `).join('');

    dots.innerHTML = loc.photos.map((_, i) => `
        <div class="carousel-dot ${i === 0 ? 'active' : ''}"
             onclick="goToSlide(${i})"></div>
    `).join('');

    updateCarousel();

    // Buka panel
    document.getElementById('detailPanel').classList.add('active');
}

// ── CAROUSEL ──
function updateCarousel() {
    const loc = currentLocation;
    if (!loc) return;

    document.getElementById('carouselTrack').style.transform =
        `translateX(-${carouselIndex * 100}%)`;

    document.querySelectorAll('.carousel-dot').forEach((dot, i) => {
        dot.classList.toggle('active', i === carouselIndex);
    });
}

function carouselNext() {
    if (!currentLocation) return;
    carouselIndex = (carouselIndex + 1) % currentLocation.photos.length;
    updateCarousel();
}

function carouselPrev() {
    if (!currentLocation) return;
    carouselIndex = (carouselIndex - 1 + currentLocation.photos.length) % currentLocation.photos.length;
    updateCarousel();
}

function goToSlide(index) {
    carouselIndex = index;
    updateCarousel();
}

// ── CLOSE DETAIL ──
function closeDetail() {
    document.getElementById('detailPanel').classList.remove('active');
    currentLocation = null;
}

// ── GO TO BOOKING ──
function goToBooking() {
    if (!currentLocation) return;
    window.location.href =
        `/booking?location=${encodeURIComponent(currentLocation.id)}`;
}
    </script>
</body>
</html>