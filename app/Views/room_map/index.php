<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Denah Kamar</h1>
            <p class="page-sub">Visualisasi real-time status kamar</p>
        </div>
        <div class="header-actions">
            <span class="last-update" id="last-updated">-</span>

            <!-- Search Icon -->
            <mdui-button-icon onclick="openSearchModal()" title="Cari Kamar" class="icon-btn">
                <mdui-icon name="search"></mdui-icon>
            </mdui-button-icon>

            <!-- Filter Icon (dengan badge) -->
            <mdui-button-icon onclick="openFilterModal()" title="Filter" class="icon-btn" id="filter-btn">
                <mdui-icon name="tune"></mdui-icon>
                <span class="filter-badge" id="filter-badge" style="display: none;">0</span>
            </mdui-button-icon>

            <!-- Refresh -->
            <mdui-button onclick="loadRooms(true)" variant="outlined">
                <mdui-icon slot="icon" name="refresh"></mdui-icon>
                Refresh
            </mdui-button>
        </div>
    </div>

    <!-- STATS -->
    <div class="stat-mini-grid">
        <div class="stat-mini" style="--accent: #10B981; --soft: #ECFDF5;">
            <div class="stat-mini-icon"><mdui-icon name="check_circle"></mdui-icon></div>
            <div>
                <div class="stat-mini-value" id="stat-vacant-clean">0</div>
                <div class="stat-mini-label">Vacant Clean</div>
            </div>
        </div>
        <div class="stat-mini" style="--accent: #F59E0B; --soft: #FFFBEB;">
            <div class="stat-mini-icon"><mdui-icon name="cleaning_services"></mdui-icon></div>
            <div>
                <div class="stat-mini-value" id="stat-vacant-dirty">0</div>
                <div class="stat-mini-label">Vacant Dirty</div>
            </div>
        </div>
        <div class="stat-mini" style="--accent: #EF4444; --soft: #FEF2F2;">
            <div class="stat-mini-icon"><mdui-icon name="person"></mdui-icon></div>
            <div>
                <div class="stat-mini-value" id="stat-occupied">0</div>
                <div class="stat-mini-label">Occupied</div>
            </div>
        </div>
        <div class="stat-mini" style="--accent: #3B82F6; --soft: #EFF6FF;">
            <div class="stat-mini-icon"><mdui-icon name="sync"></mdui-icon></div>
            <div>
                <div class="stat-mini-value" id="stat-on-change">0</div>
                <div class="stat-mini-label">On Change</div>
            </div>
        </div>
        <div class="stat-mini" style="--accent: #E65100; --soft: #FFF7ED;">
            <div class="stat-mini-icon"><mdui-icon name="warning"></mdui-icon></div>
            <div>
                <div class="stat-mini-value" id="stat-out-of-order">0</div>
                <div class="stat-mini-label">Out of Order</div>
            </div>
        </div>
        <div class="stat-mini" style="--accent: #757575; --soft: #F3F4F6;">
            <div class="stat-mini-icon"><mdui-icon name="block"></mdui-icon></div>
            <div>
                <div class="stat-mini-value" id="stat-out-of-service">0</div>
                <div class="stat-mini-label">Out of Service</div>
            </div>
        </div>
    </div>

    <!-- ACTIVE FILTERS -->
    <div id="active-filters" class="active-filters" style="display: none;">
        <span class="chip-label">Filter aktif:</span>
        <span id="filter-chip-floor" class="chip" style="display: none;">
            Lantai: <strong id="chip-floor-value"></strong>
            <button onclick="clearFloorFilter()" class="chip-close">×</button>
        </span>
        <span id="filter-chip-status" class="chip" style="display: none;">
            Status: <strong id="chip-status-value"></strong>
            <button onclick="clearStatusFilter()" class="chip-close">×</button>
        </span>
        <span id="filter-chip-search" class="chip" style="display: none;">
            Cari: "<strong id="chip-search-value"></strong>"
            <button onclick="clearSearchFilter()" class="chip-close">×</button>
        </span>
        <button onclick="clearAllFilters()" class="chip-clear">Hapus semua</button>
    </div>

    <!-- LEGEND -->
    <div class="legend-bar">
        <span style="font-size: 12px; font-weight: 600; color: var(--text-muted);">Keterangan:</span>
        <span class="legend-item"><span class="legend-box" style="background:#10B981;"></span> Vacant Clean</span>
        <span class="legend-item"><span class="legend-box" style="background:#F59E0B;"></span> Vacant Dirty</span>
        <span class="legend-item"><span class="legend-box" style="background:#EF4444;"></span> Occupied</span>
        <span class="legend-item"><span class="legend-box" style="background:#3B82F6;"></span> On Change</span>
        <span class="legend-item"><span class="legend-box" style="background:#E65100;"></span> Out of Order</span>
        <span class="legend-item"><span class="legend-box" style="background:#757575;"></span> Out of Service</span>
    </div>

    <div id="room-map-container">
        <div style="text-align: center; padding: 48px; color: var(--text-muted);">
            <mdui-spinner></mdui-spinner>
            <p>Memuat denah kamar...</p>
        </div>
    </div>
</div>

<!-- ============ MODAL: SEARCH ============ -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Kamar</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            placeholder="Ketik nomor kamar..."
            variant="outlined"
            clearable
            style="width: 100%;">
            <mdui-icon slot="icon" name="search"></mdui-icon>
        </mdui-text-field>
        <p style="font-size: 12px; color: var(--text-muted); margin: 12px 0 0 0;">
            Contoh: <strong>101</strong>, <strong>201</strong>, <strong>3</strong> (kamar dengan angka 3)
        </p>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearSearchFilter()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applySearch()">Terapkan</mdui-button>
</mdui-dialog>

<!-- ============ MODAL: FILTER ============ -->
<mdui-dialog id="dialog-filter" style="--mdui-dialog-width: 480px;">
    <span slot="headline">Filter Denah</span>
    <div style="padding: 4px 0;">

        <!-- FLOOR -->
        <div class="filter-section">
            <div class="filter-section-title">
                <mdui-icon name="layers"></mdui-icon>
                Lantai
            </div>
            <div class="floor-options" id="floor-options">
                <label class="floor-chip">
                    <input type="radio" name="filter_floor" value="all" checked onchange="selectFloor(this)">
                    <span>Semua</span>
                </label>
                <!-- Lantai akan di-inject via JS -->
            </div>
        </div>

        <!-- STATUS -->
        <div class="filter-section" style="margin-top: 20px;">
            <div class="filter-section-title">
                <mdui-icon name="tune"></mdui-icon>
                Status Kamar
            </div>

            <div class="filter-options">
                <label class="filter-option">
                    <input type="radio" name="filter_status" value="all" checked onchange="selectStatus(this)">
                    <div class="filter-option-content">
                        <mdui-icon name="done_all"></mdui-icon>
                        <div>
                            <div class="filter-option-title">Semua Status</div>
                            <div class="filter-option-sub">Tampilkan semua kamar</div>
                        </div>
                    </div>
                </label>

                <label class="filter-option">
                    <input type="radio" name="filter_status" value="vacant_clean" onchange="selectStatus(this)">
                    <div class="filter-option-content">
                        <mdui-icon name="check_circle" style="color: #10B981;"></mdui-icon>
                        <div>
                            <div class="filter-option-title">Vacant Clean</div>
                            <div class="filter-option-sub">Kosong & siap huni</div>
                        </div>
                    </div>
                </label>

                <label class="filter-option">
                    <input type="radio" name="filter_status" value="vacant_dirty" onchange="selectStatus(this)">
                    <div class="filter-option-content">
                        <mdui-icon name="cleaning_services" style="color: #F59E0B;"></mdui-icon>
                        <div>
                            <div class="filter-option-title">Vacant Dirty</div>
                            <div class="filter-option-sub">Perlu dibersihkan</div>
                        </div>
                    </div>
                </label>

                <label class="filter-option">
                    <input type="radio" name="filter_status" value="occupied" onchange="selectStatus(this)">
                    <div class="filter-option-content">
                        <mdui-icon name="person" style="color: #EF4444;"></mdui-icon>
                        <div>
                            <div class="filter-option-title">Occupied</div>
                            <div class="filter-option-sub">Sedang dihuni tamu</div>
                        </div>
                    </div>
                </label>

                <label class="filter-option">
                    <input type="radio" name="filter_status" value="on_change" onchange="selectStatus(this)">
                    <div class="filter-option-content">
                        <mdui-icon name="sync" style="color: #3B82F6;"></mdui-icon>
                        <div>
                            <div class="filter-option-title">On Change</div>
                            <div class="filter-option-sub">Tamu check-out</div>
                        </div>
                    </div>
                </label>

                <label class="filter-option">
                    <input type="radio" name="filter_status" value="out_of_order" onchange="selectStatus(this)">
                    <div class="filter-option-content">
                        <mdui-icon name="warning" style="color: #E65100;"></mdui-icon>
                        <div>
                            <div class="filter-option-title">Out of Order</div>
                            <div class="filter-option-sub">Dalam perbaikan</div>
                        </div>
                    </div>
                </label>

                <label class="filter-option">
                    <input type="radio" name="filter_status" value="out_of_service" onchange="selectStatus(this)">
                    <div class="filter-option-content">
                        <mdui-icon name="block" style="color: #757575;"></mdui-icon>
                        <div>
                            <div class="filter-option-title">Out of Service</div>
                            <div class="filter-option-sub">Diblokir sementara</div>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <mdui-button slot="action" variant="text" onclick="resetFilterModal()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applyFilter()">Terapkan</mdui-button>
</mdui-dialog>

<!-- ============ MODAL: DETAIL KAMAR (LEBIH LEBAR) ============ -->
<mdui-dialog id="dialog-detail" style="--mdui-dialog-width: 460px;">
    <span slot="headline">Detail Kamar</span>
    <div style="min-width: 380px; padding: 4px 0;">
        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 20px;">
            <div id="detail-avatar" style="width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700;">101</div>
            <div>
                <div style="font-size: 20px; font-weight: 700;" id="detail-room-number">101</div>
                <div style="color: var(--text-muted); font-size: 13px;" id="detail-room-type">Standard</div>
            </div>
        </div>

        <table style="width: 100%; font-size: 13px;">
            <tr>
                <td style="padding: 10px 0; color: var(--text-muted);">Lantai</td>
                <td style="padding: 10px 0; text-align: right; font-weight: 600;" id="detail-floor">1</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: var(--text-muted);">Harga Dasar</td>
                <td style="padding: 10px 0; text-align: right; font-weight: 600;" id="detail-price">-</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: var(--text-muted);">Status</td>
                <td style="padding: 10px 0; text-align: right;" id="detail-status">-</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: var(--text-muted); vertical-align: top;">Catatan</td>
                <td style="padding: 10px 0; text-align: right;" id="detail-notes">-</td>
            </tr>
        </table>

        <mdui-divider style="margin: 20px 0;"></mdui-divider>

        <div style="margin-bottom: 12px; font-size: 13px; font-weight: 600;">Ubah Status:</div>
        <div id="status-buttons" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;"></div>
    </div>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-detail')">Tutup</mdui-button>
</mdui-dialog>

<div id="room-tooltip" style="position: fixed; display: none; background: rgba(17, 24, 39, 0.95); color: white; padding: 10px 14px; border-radius: 8px; font-size: 12px; pointer-events: none; z-index: 9999; max-width: 220px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"></div>

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .page-title { font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .page-sub { color: var(--text-muted); font-size: 13px; margin: 0; }

    .header-actions { display: flex; align-items: center; gap: 8px; }
    .last-update { font-size: 12px; color: var(--text-muted); margin-right: 4px; }

    .icon-btn {
        width: 40px !important;
        height: 40px !important;
        border-radius: 10px !important;
        background: #fff !important;
        border: 1px solid var(--border) !important;
        color: var(--text-secondary) !important;
        position: relative;
    }
    .icon-btn:hover {
        background: var(--primary-soft) !important;
        color: var(--primary) !important;
        border-color: var(--primary) !important;
    }
    .filter-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: var(--primary);
        color: white;
        font-size: 10px;
        font-weight: 700;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        border: 2px solid #fff;
    }

    /* ACTIVE FILTERS */
    .active-filters {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        padding: 10px 14px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--border);
        flex-wrap: wrap;
    }
    .chip-label { font-size: 12px; color: var(--text-muted); font-weight: 600; }
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        background: var(--primary-soft);
        color: var(--primary);
        font-size: 12px;
        font-weight: 500;
    }
    .chip strong { color: var(--primary-dark); }
    .chip-close {
        background: none; border: none; color: var(--primary);
        font-size: 16px; line-height: 1; cursor: pointer;
        padding: 0; margin-left: 2px;
    }
    .chip-close:hover { color: #EF4444; }
    .chip-clear {
        background: none; border: none; color: #EF4444;
        font-size: 12px; font-weight: 600; cursor: pointer;
        padding: 4px 8px; margin-left: auto;
    }
    .chip-clear:hover { text-decoration: underline; }

    /* STATS */
    .stat-mini-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px; margin-bottom: 16px;
    }
    .stat-mini {
        background: #fff; border-radius: 12px;
        padding: 14px 16px;
        border: 1px solid var(--border);
        display: flex; align-items: center; gap: 12px;
        box-shadow: var(--shadow-sm);
    }
    .stat-mini-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: var(--soft); color: var(--accent);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-mini-icon mdui-icon { font-size: 20px; }
    .stat-mini-value { font-size: 20px; font-weight: 700; color: var(--accent); line-height: 1; }
    .stat-mini-label { font-size: 11px; color: var(--text-muted); margin-top: 3px; }

    /* LEGEND */
    .legend-bar {
        display: flex; gap: 16px; align-items: center; flex-wrap: wrap;
        background: #fff; padding: 14px 20px; border-radius: 14px;
        border: 1px solid var(--border); box-shadow: var(--shadow-sm);
        margin-bottom: 20px;
    }
    .legend-item { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-secondary); }
    .legend-box { display: inline-block; width: 14px; height: 14px; border-radius: 4px; }

    /* FLOOR & ROOM GRID */
    .floor-section { margin-bottom: 32px; }
    .floor-title {
        font-size: 15px; font-weight: 700; color: var(--text-primary);
        margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
    }
    .room-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 14px;
    }
    .room-box {
        aspect-ratio: 1.15;
        border-radius: 14px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        color: white; cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .room-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.15);
    }
    .room-box .room-num { font-size: 22px; font-weight: 700; line-height: 1; }
    .room-box .room-status-label {
        font-size: 9px; text-transform: uppercase;
        letter-spacing: 0.5px; margin-top: 6px;
        opacity: 0.95; font-weight: 600;
    }

    /* FILTER MODAL STYLES */
    .filter-section-title {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .filter-section-title mdui-icon { font-size: 18px; }

    .floor-options {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .floor-chip {
        cursor: pointer;
    }
    .floor-chip input { position: absolute; opacity: 0; pointer-events: none; }
    .floor-chip span {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid var(--border);
        background: #fff;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        transition: all 0.15s;
    }
    .floor-chip:hover span {
        border-color: var(--primary-light);
        color: var(--primary);
    }
    .floor-chip input:checked + span {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        font-weight: 600;
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 340px;
        overflow-y: auto;
        padding-right: 6px;
    }
    .filter-option { display: block; cursor: pointer; position: relative; }
    .filter-option input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
    .filter-option-content {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: #fff;
        transition: all 0.15s ease;
    }
    .filter-option-content mdui-icon { font-size: 22px; color: var(--text-muted); flex-shrink: 0; }
    .filter-option-content > div { flex: 1; }
    .filter-option-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .filter-option-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
    .filter-option:hover .filter-option-content { border-color: var(--primary-light); background: #FAFBFF; }
    .filter-option input[type="radio"]:checked + .filter-option-content {
        border-color: var(--primary);
        background: var(--primary-soft);
    }
    .filter-option input[type="radio"]:checked + .filter-option-content .filter-option-title {
        color: var(--primary);
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const STATUS_COLORS = {
    'vacant_clean':   '#10B981',
    'vacant_dirty':   '#F59E0B',
    'occupied':       '#EF4444',
    'on_change':      '#3B82F6',
    'out_of_order':   '#E65100',
    'out_of_service': '#757575',
};

const STATUS_LABELS = {
    'vacant_clean':   'Vacant Clean',
    'vacant_dirty':   'Vacant Dirty',
    'occupied':       'Occupied',
    'on_change':      'On Change',
    'out_of_order':   'Out of Order',
    'out_of_service': 'Out of Service',
};

let allRooms = [];
let currentRoom = null;
let previousStatuses = {};
let soundEnabled = true;

// Active filters
let activeSearch = '';
let activeFloor = 'all';
let activeStatus = 'all';

// =====================
// LOAD
// =====================
async function loadRooms(showNotification = false) {
    try {
        const res  = await fetch('<?= base_url('room-map/data') ?>');
        const json = await res.json();
        if (! json.success) { console.error('Gagal memuat data:', json); return; }

        const flatRooms = [];
        for (const floor in json.floors) {
            json.floors[floor].forEach(r => { r.floor_num = floor; flatRooms.push(r); });
        }

        if (showNotification || Object.keys(previousStatuses).length > 0) {
            flatRooms.forEach(room => {
                const prev = previousStatuses[room.id];
                if (prev && prev !== room.status) playNotificationSound();
            });
        }
        flatRooms.forEach(room => { previousStatuses[room.id] = room.status; });

        allRooms = flatRooms;
        updateStatistics(flatRooms);
        buildFloorOptions(flatRooms);
        applyFilter();

        document.getElementById('last-updated').textContent = 'Update: ' + new Date().toLocaleTimeString('id-ID');
    } catch (err) {
        console.error(err);
        document.getElementById('room-map-container').innerHTML =
            '<div style="text-align:center; padding:48px; color:#EF4444;">Gagal memuat data kamar.</div>';
    }
}

function updateStatistics(rooms) {
    const counts = { 'vacant_clean': 0, 'vacant_dirty': 0, 'occupied': 0, 'on_change': 0, 'out_of_order': 0, 'out_of_service': 0 };
    rooms.forEach(r => { if (counts[r.status] !== undefined) counts[r.status]++; });
    document.getElementById('stat-vacant-clean').textContent   = counts['vacant_clean'];
    document.getElementById('stat-vacant-dirty').textContent   = counts['vacant_dirty'];
    document.getElementById('stat-occupied').textContent       = counts['occupied'];
    document.getElementById('stat-on-change').textContent      = counts['on_change'];
    document.getElementById('stat-out-of-order').textContent   = counts['out_of_order'];
    document.getElementById('stat-out-of-service').textContent = counts['out_of_service'];
}

function buildFloorOptions(rooms) {
    const floors = [...new Set(rooms.map(r => r.floor))].sort((a, b) => a - b);
    const container = document.getElementById('floor-options');

    // Keep the "all" option, remove the rest
    container.querySelectorAll('.floor-chip:not(:first-child)').forEach(el => el.remove());

    floors.forEach(f => {
        const chip = document.createElement('label');
        chip.className = 'floor-chip';
        chip.innerHTML = `
            <input type="radio" name="filter_floor" value="${f}" onchange="selectFloor(this)">
            <span>Lantai ${f}</span>
        `;
        container.appendChild(chip);
    });

    // Restore active selection
    document.querySelectorAll('input[name="filter_floor"]').forEach(r => {
        r.checked = (String(r.value) === String(activeFloor));
    });
}

// =====================
// SEARCH
// =====================
function openSearchModal() {
    document.getElementById('search-input').value = activeSearch;
    openDialog('dialog-search');
}

function applySearch() {
    activeSearch = (document.getElementById('search-input').value || '').toLowerCase().trim();
    closeDialog('dialog-search');
    updateUI();
    applyFilter();
}

function clearSearchFilter() {
    activeSearch = '';
    document.getElementById('search-input').value = '';
    closeDialog('dialog-search');
    updateUI();
    applyFilter();
}

// =====================
// FILTER
// =====================
function openFilterModal() {
    document.querySelectorAll('input[name="filter_floor"]').forEach(r => {
        r.checked = (String(r.value) === String(activeFloor));
    });
    document.querySelectorAll('input[name="filter_status"]').forEach(r => {
        r.checked = (r.value === activeStatus);
    });
    openDialog('dialog-filter');
}

function selectFloor(el) {
    activeFloor = el.value;
}

function selectStatus(el) {
    activeStatus = el.value;
}

function applyFilter() {
    closeDialog('dialog-filter');
    updateUI();
    renderFiltered();
}

function resetFilterModal() {
    activeFloor = 'all';
    activeStatus = 'all';
    document.querySelectorAll('input[name="filter_floor"]').forEach(r => {
        r.checked = (r.value === 'all');
    });
    document.querySelectorAll('input[name="filter_status"]').forEach(r => {
        r.checked = (r.value === 'all');
    });
}

function clearFloorFilter() {
    activeFloor = 'all';
    document.querySelectorAll('input[name="filter_floor"]').forEach(r => {
        r.checked = (r.value === 'all');
    });
    updateUI();
    renderFiltered();
}

function clearStatusFilter() {
    activeStatus = 'all';
    document.querySelectorAll('input[name="filter_status"]').forEach(r => {
        r.checked = (r.value === 'all');
    });
    updateUI();
    renderFiltered();
}

function clearAllFilters() {
    activeSearch = '';
    activeFloor = 'all';
    activeStatus = 'all';
    document.getElementById('search-input').value = '';
    document.querySelectorAll('input[name="filter_floor"]').forEach(r => {
        r.checked = (r.value === 'all');
    });
    document.querySelectorAll('input[name="filter_status"]').forEach(r => {
        r.checked = (r.value === 'all');
    });
    updateUI();
    renderFiltered();
}

// =====================
// UI (CHIPS & BADGE)
// =====================
function updateUI() {
    const badge = document.getElementById('filter-badge');
    const activeFilters = document.getElementById('active-filters');
    const chipFloor = document.getElementById('filter-chip-floor');
    const chipStatus = document.getElementById('filter-chip-status');
    const chipSearch = document.getElementById('filter-chip-search');

    let filterCount = 0;

    // Floor
    if (activeFloor !== 'all') {
        filterCount++;
        chipFloor.style.display = 'inline-flex';
        document.getElementById('chip-floor-value').textContent = 'Lantai ' + activeFloor;
    } else {
        chipFloor.style.display = 'none';
    }

    // Status
    if (activeStatus !== 'all') {
        filterCount++;
        chipStatus.style.display = 'inline-flex';
        document.getElementById('chip-status-value').textContent = STATUS_LABELS[activeStatus] || activeStatus;
    } else {
        chipStatus.style.display = 'none';
    }

    // Search
    if (activeSearch) {
        chipSearch.style.display = 'inline-flex';
        document.getElementById('chip-search-value').textContent = activeSearch;
    } else {
        chipSearch.style.display = 'none';
    }

    // Badge (hanya floor & status)
    if (filterCount > 0) {
        badge.style.display = 'flex';
        badge.textContent = filterCount;
    } else {
        badge.style.display = 'none';
    }

    // Show chips bar
    const totalActive = filterCount + (activeSearch ? 1 : 0);
    activeFilters.style.display = totalActive > 0 ? 'flex' : 'none';
}

// =====================
// RENDER
// =====================
function renderFiltered() {
    const filtered = allRooms.filter(room => {
        const matchSearch = ! activeSearch || room.room_number.toLowerCase().includes(activeSearch);
        const matchFloor  = activeFloor === 'all' || String(room.floor) === String(activeFloor);
        const matchStatus = activeStatus === 'all' || room.status === activeStatus;
        return matchSearch && matchFloor && matchStatus;
    });
    renderMap(filtered);
}

function renderMap(rooms) {
    const container = document.getElementById('room-map-container');
    if (! rooms || rooms.length === 0) {
        container.innerHTML = `
            <div style="text-align:center; padding: 60px 20px;">
                <mdui-icon name="search_off" style="font-size: 56px; color: #CBD5E1;"></mdui-icon>
                <p style="font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 16px 0 4px 0;">Tidak ada kamar yang cocok</p>
                <span style="font-size: 13px; color: var(--text-muted);">Coba ubah kata kunci atau filter Anda</span>
            </div>`;
        return;
    }
    const grouped = {};
    rooms.forEach(r => { grouped[r.floor] = grouped[r.floor] || []; grouped[r.floor].push(r); });
    const sortedFloors = Object.keys(grouped).sort((a, b) => a - b);
    let html = '';
    sortedFloors.forEach(floor => {
        html += '<div class="floor-section">';
        html += `<div class="floor-title"><mdui-icon name="layers" style="font-size:20px; color: var(--primary);"></mdui-icon> Lantai ${floor} <span style="color: var(--text-muted); font-weight: 400; font-size: 13px;">(${grouped[floor].length} kamar)</span></div>`;
        html += '<div class="room-grid">';
        grouped[floor].forEach(room => {
            const color = STATUS_COLORS[room.status] || '#888';
            const label = STATUS_LABELS[room.status] || room.status;
            html += `
                <div class="room-box" style="background: linear-gradient(135deg, ${color} 0%, ${color}DD 100%);"
                     data-room='${JSON.stringify(room).replace(/'/g, "&apos;")}'
                     onclick="openDetail(this)"
                     onmouseenter="showTooltip(event, this)"
                     onmouseleave="hideTooltip()">
                    <span class="room-num">${room.room_number}</span>
                    <span class="room-status-label">${label}</span>
                </div>`;
        });
        html += '</div></div>';
    });
    container.innerHTML = html;
}

// =====================
// TOOLTIP
// =====================
function showTooltip(event, el) {
    const room = JSON.parse(el.dataset.room);
    const tooltip = document.getElementById('room-tooltip');
    let html = `<strong>Kamar ${room.room_number}</strong><br>`;
    html += `<span style="opacity: 0.8;">Tipe: ${room.type_name || '-'}</span><br>`;
    html += `<span style="opacity: 0.8;">Status: ${STATUS_LABELS[room.status] || room.status}</span>`;
    if (room.base_price) html += `<br><span style="opacity: 0.8;">Harga: Rp ${parseInt(room.base_price).toLocaleString('id-ID')}</span>`;
    tooltip.innerHTML = html;
    tooltip.style.display = 'block';
    const rect = el.getBoundingClientRect();
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top  = (rect.top - tooltip.offsetHeight - 8) + 'px';
}

function hideTooltip() {
    document.getElementById('room-tooltip').style.display = 'none';
}

// =====================
// SOUND
// =====================
function playNotificationSound() {
    if (! soundEnabled) return;
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(880, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(1320, ctx.currentTime + 0.1);
        gain.gain.setValueAtTime(0.15, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start(ctx.currentTime);
        osc.stop(ctx.currentTime + 0.3);
    } catch (e) { console.warn('Audio tidak bisa dimainkan:', e); }
}

// =====================
// DETAIL MODAL
// =====================
function openDetail(el) {
    const room = JSON.parse(el.dataset.room);
    currentRoom = room;
    document.getElementById('detail-avatar').textContent      = room.room_number;
    document.getElementById('detail-avatar').style.background = `linear-gradient(135deg, ${STATUS_COLORS[room.status]} 0%, ${STATUS_COLORS[room.status]}DD 100%)`;
    document.getElementById('detail-room-number').textContent = room.room_number;
    document.getElementById('detail-room-type').textContent   = room.type_name || 'Tanpa Tipe';
    document.getElementById('detail-floor').textContent       = 'Lantai ' + room.floor;
    document.getElementById('detail-price').textContent       = room.base_price ? 'Rp ' + parseInt(room.base_price).toLocaleString('id-ID') : '-';
    document.getElementById('detail-status').innerHTML        = statusBadge(room.status);
    document.getElementById('detail-notes').textContent       = room.notes || '-';
    const btnContainer = document.getElementById('status-buttons');
    btnContainer.innerHTML = '';
    for (const key in STATUS_LABELS) {
        const btn = document.createElement('button');
        btn.textContent = STATUS_LABELS[key];
        btn.style.cssText = `padding: 10px 12px; border: 1px solid ${STATUS_COLORS[key]}; background: ${room.status === key ? STATUS_COLORS[key] : 'transparent'}; color: ${room.status === key ? 'white' : STATUS_COLORS[key]}; border-radius: 8px; font-size: 12px; cursor: pointer; font-weight: 600; transition: all 0.15s;`;
        btn.onclick = () => updateStatus(room.id, key);
        btnContainer.appendChild(btn);
    }
    openDialog('dialog-detail');
}

function statusBadge(status) {
    const color = STATUS_COLORS[status] || '#888';
    const label = STATUS_LABELS[status] || status;
    return `<span style="display:inline-block; padding:4px 10px; border-radius:8px; font-size:12px; font-weight:600; background:${color}; color:white;">${label}</span>`;
}

async function updateStatus(roomId, newStatus) {
    try {
        const formData = new FormData();
        formData.append('status', newStatus);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        const res  = await fetch('<?= base_url('room-map/update-status') ?>/' + roomId, { method: 'POST', body: formData });
        const json = await res.json();
        if (json.success) {
            showAlert(json.message, 'success', 2000);
            closeDialog('dialog-detail');
            loadRooms(false);
        } else {
            showAlert(json.message || 'Gagal update status.', 'error');
        }
    } catch (err) {
        console.error(err);
        showAlert('Terjadi kesalahan.', 'error');
    }
}

// =====================
// UTILS
// =====================
function openDialog(id)  { document.getElementById(id).open = true; }
function closeDialog(id) { document.getElementById(id).open = false; }

// Enter di search input
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applySearch();
        });
    }
});

// Load awal
loadRooms();
setInterval(() => loadRooms(true), 30000);
</script>
<?= $this->endSection() ?>