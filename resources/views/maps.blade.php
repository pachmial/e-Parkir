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
            background: linear-gradient(135deg, var(--accent), #16a34a);
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
            background: linear-gradient(135deg, var(--accent), #16a34a);
            color: #0f1117;
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
            background: linear-gradient(135deg, var(--accent), #16a34a);
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

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 100px; }
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
    <div class="overlay" id="overlay" onclick="closeSheet()"></div>

    {{-- Slot Sheet --}}
    <div class="slot-sheet" id="slotSheet">
        <div class="sheet-handle"></div>
        <div class="sheet-header">
            <div>
                <div class="sheet-title" id="sheetTitle">Pilih tempat Parkir</div>
            </div>
            <div class="sheet-close" onclick="closeSheet()">×</div>
        </div>
        <div class="sheet-subtitle" id="sheetSubtitle">Zone A · Parkir Mal BTM</div>

        <div class="slot-grid" id="slotGrid">
            {{-- Slots generated by JS --}}
        </div>

        <div class="sheet-footer">
            <div class="sheet-footer-info">
                Dipilih: <span id="selectedSlotLabel">—</span>
            </div>
            <button class="book-btn" id="bookBtn" disabled onclick="handleBook()">
                Pesan Sekarang →
            </button>
        </div>
    </div>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // ── MAP INIT ──
        const map = L.map('map', {
            center: [-6.5971, 106.8060],
            zoom: 14,
            zoomControl: false,
        });

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
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
                lat: -6.5975, lng: 106.7974,
                zone: 'Zone A',
                available: 34,
                total: 60,
                slots: generateSlots('A', 12, [3, 7, 11])
            },
            {
                id: 'boxies',
                name: 'Boxies 123 Mall',
                desc: 'Mall modern di Tajur dengan konsep outdoor dan akses tol Jagorawi.',
                lat: -6.6112, lng: 106.8214,
                zone: 'Zone B',
                available: 18,
                total: 50,
                slots: generateSlots('B', 12, [1, 5, 9, 12])
            },
            {
                id: 'lippo',
                name: 'Lippo Plaza Bogor',
                desc: 'Mall premium kawasan Bogor Selatan, lengkap dengan bioskop dan restoran.',
                lat: -6.6021, lng: 106.8103,
                zone: 'Zone C',
                available: 41,
                total: 50,
                slots: generateSlots('C', 12, [2, 8])
            },
            {
                id: 'botani',
                name: 'Botani Square',
                desc: 'Mall keluarga di dekat Kebun Raya Bogor, mudah diakses dari pusat kota.',
                lat: -6.5940, lng: 106.7990,
                zone: 'Zone D',
                available: 0,
                total: 40,
                slots: generateSlots('D', 12, [0,1,2,3,4,5,6,7,8,9,10,11])
            },
            {
                id: 'ekalokasari',
                name: 'Ekalokasari Plaza',
                desc: 'Pusat belanja di kawasan Bogor Timur, dekat terminal Baranangsiang.',
                lat: -6.5963, lng: 106.8195,
                zone: 'Zone E',
                available: 22,
                total: 45,
                slots: generateSlots('E', 12, [4, 6, 10])
            },
            {
                id: 'jambu2',
                name: 'Jambu Dua Square',
                desc: 'Mall di utara Bogor, kawasan Warung Jambu, mudah akses dari Jabodetabek.',
                lat: -6.5615, lng: 106.7923,
                zone: 'Zone F',
                available: 15,
                total: 40,
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

        // ── CREATE MARKERS ──
        locations.forEach(loc => {
            const isAvailable = loc.available > 0;
            const color = isAvailable ? '#4ade80' : '#f87171';

            const markerHtml = `
                <div class="custom-marker ${isAvailable ? 'available' : 'full'}">
                    <div class="custom-marker-inner">${isAvailable ? '🅿' : '✕'}</div>
                </div>`;

            const icon = L.divIcon({
                html: markerHtml,
                className: '',
                iconSize: [36, 36],
                iconAnchor: [18, 36],
                popupAnchor: [0, -40]
            });

            const marker = L.marker([loc.lat, loc.lng], { icon }).addTo(map);

            const statusClass = isAvailable ? 'available' : 'full';
            const statusText = isAvailable ? `${loc.available} Slot Tersedia` : 'Penuh';

            const popupContent = `
                <div>
                    <div class="popup-badge ${statusClass}">
                        <span>●</span> ${statusText}
                    </div>
                    <div class="popup-title">${loc.name}</div>
                    <div class="popup-desc">${loc.desc}</div>
                    <div class="popup-slots">
                        <div class="popup-slots-count">${loc.available}</div>
                        <div class="popup-slots-label">Slot<br>Tersedia</div>
                    </div>
                    <button
                        class="popup-btn ${isAvailable ? '' : 'disabled'}"
                        onclick="${isAvailable ? `openSheet('${loc.id}')` : 'void(0)'}"
                    >
                        ${isAvailable ? 'Pilih Parkir →' : 'Tidak Tersedia'}
                    </button>
                </div>`;

            marker.bindPopup(popupContent, {
                maxWidth: 260,
                closeButton: true,
                className: 'eparkir-popup'
            });
        });

        // ── OPEN SHEET ──
        function openSheet(locId) {
            currentLocation = locations.find(l => l.id === locId);
            if (!currentLocation) return;

            selectedSlot = null;
            document.getElementById('sheetTitle').textContent = 'Pilih tempat Parkir';
            document.getElementById('sheetSubtitle').textContent =
                `${currentLocation.zone} · ${currentLocation.name}`;
            document.getElementById('selectedSlotLabel').textContent = '—';
            document.getElementById('bookBtn').disabled = true;

            renderSlots(currentLocation.slots);

            document.getElementById('slotSheet').classList.add('active');
            document.getElementById('overlay').classList.add('active');
            map.closePopup();
        }

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

        function selectSlot(slotId) {
            // Deselect previous
            document.querySelectorAll('.slot-card.selected')
                .forEach(el => el.classList.remove('selected'));

            selectedSlot = slotId;
            document.getElementById(`slot-${slotId}`).classList.add('selected');
            document.getElementById('selectedSlotLabel').textContent = slotId;
            document.getElementById('bookBtn').disabled = false;
        }

        function closeSheet() {
            document.getElementById('slotSheet').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
            selectedSlot = null;
            currentLocation = null;
        }

        function handleBook() {
            if (!selectedSlot || !currentLocation) return;
            // Redirect ke halaman booking dengan data slot & lokasi
            window.location.href = `/booking?slot=${encodeURIComponent(selectedSlot)}&location=${encodeURIComponent(currentLocation.id)}`;
        }
    </script>
</body>
</html>