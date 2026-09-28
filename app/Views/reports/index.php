<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan & Analitik</h1>
            <p class="page-sub">Statistik dan performa operasional hotel</p>
        </div>
        <div class="header-actions">
            <mdui-select 
                id="period-filter" 
                value="30days"
                variant="outlined"
                label="Periode"
                style="min-width: 220px;" 
                onchange="loadData()">
                <mdui-menu-item value="7days">7 Hari Terakhir</mdui-menu-item>
                <mdui-menu-item value="30days">30 Hari Terakhir</mdui-menu-item>
                <mdui-menu-item value="this_month">Bulan Ini</mdui-menu-item>
                <mdui-menu-item value="last_month">Bulan Lalu</mdui-menu-item>
                <mdui-menu-item value="this_year">Tahun Ini</mdui-menu-item>
            </mdui-select>
            <mdui-button onclick="exportPDF()" variant="filled" class="btn-primary">
                <mdui-icon slot="icon" name="picture_as_pdf"></mdui-icon>
                Export PDF
            </mdui-button>
        </div>
    </div>

    <form id="form-pdf" action="<?= base_url('reports/pdf') ?>" method="post" style="display: none;">
        <?= csrf_field() ?>
        <input type="hidden" name="data" id="pdf-data">
        <input type="hidden" name="charts" id="pdf-charts">
    </form>

    <!-- SUMMARY CARDS -->
    <div class="stats-grid">
        <div class="stat-card stat-success">
            <div class="stat-icon"><mdui-icon name="payments"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value" id="sum-revenue">Rp 0</div>
                <div class="stat-desc">Dari reservasi non-cancelled</div>
            </div>
        </div>

        <div class="stat-card stat-primary">
            <div class="stat-icon"><mdui-icon name="book_online"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Total Reservasi</div>
                <div class="stat-value" id="sum-reservations">0</div>
                <div class="stat-desc">Sepanjang periode</div>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon"><mdui-icon name="trending_up"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Tingkat Okupansi</div>
                <div class="stat-value" id="sum-occupancy">0%</div>
                <div class="stat-desc">Rata-rata periode</div>
            </div>
        </div>

        <div class="stat-card stat-purple">
            <div class="stat-icon"><mdui-icon name="inventory_2"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Item Terkirim</div>
                <div class="stat-value" id="sum-items">0</div>
                <div class="stat-desc">Dari SR delivered</div>
            </div>
        </div>
    </div>

    <!-- CHART: REVENUE -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">Pendapatan Harian</div>
                <div class="chart-sub">Total pendapatan per hari dari check-in</div>
            </div>
        </div>
        <canvas id="chart-revenue" height="80"></canvas>
    </div>

    <!-- CHART: OCCUPANCY -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">Tingkat Okupansi Harian</div>
                <div class="chart-sub">Persentase kamar terisi per hari</div>
            </div>
        </div>
        <canvas id="chart-occupancy" height="80"></canvas>
    </div>

    <!-- CHART ROW: STATUS + DEPARTMENT -->
    <div class="chart-row">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">Status Kamar</div>
                <div class="chart-sub">Distribusi status saat ini</div>
            </div>
            <canvas id="chart-room-status" height="220"></canvas>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">SR per Departemen</div>
                <div class="chart-sub">Jumlah permintaan barang</div>
            </div>
            <canvas id="chart-department" height="220"></canvas>
        </div>
    </div>

    <!-- TABLES -->
    <div class="chart-row">
        <div class="modern-card">
            <div class="table-header">
                <div>
                    <div class="table-title">Top 5 Kamar Paling Sering Dipesan</div>
                    <div class="table-sub">Berdasarkan jumlah reservasi</div>
                </div>
            </div>
            <table class="modern-table" id="table-top-rooms">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Kamar</th>
                        <th>Tipe</th>
                        <th style="text-align: right;">Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="4" style="text-align:center; padding:32px; color:var(--text-muted);">Memuat...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="modern-card">
            <div class="table-header">
                <div>
                    <div class="table-title">Top 5 Barang Paling Banyak Diminta</div>
                    <div class="table-sub">Dari SR yang sudah delivered</div>
                </div>
            </div>
            <table class="modern-table" id="table-top-items">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Barang</th>
                        <th style="text-align: right;">Total Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="3" style="text-align:center; padding:32px; color:var(--text-muted);">Memuat...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .page-title { font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .page-sub { color: var(--text-muted); font-size: 13px; margin: 0; }
    .header-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

    /* STATS */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon mdui-icon { font-size: 26px; }
    .stat-info { flex: 1; min-width: 0; }
    .stat-label {
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;
        color: var(--text-muted); font-weight: 600; margin-bottom: 4px;
    }
    .stat-value {
        font-size: 22px; font-weight: 700; color: var(--text-primary); line-height: 1.1;
    }
    .stat-desc { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

    .stat-success .stat-icon { background: #ECFDF5; color: #10B981; }
    .stat-primary .stat-icon { background: #EEF0FF; color: #6C5CE7; }
    .stat-warning .stat-icon { background: #FEF3C7; color: #F59E0B; }
    .stat-purple  .stat-icon { background: #F3E8FF; color: #7C3AED; }

    /* CHART CARDS */
    .chart-card {
        background: #fff;
        border-radius: 14px;
        padding: 22px 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .chart-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .chart-sub { font-size: 12px; color: var(--text-muted); margin: 0; }

    .chart-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }
    .chart-row .chart-card { margin-bottom: 0; }

    /* TABLE HEADER */
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
    }
    .table-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .table-sub { font-size: 12px; color: var(--text-muted); margin: 0; }

    .modern-card {
        background: #fff; border-radius: 14px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm); overflow: hidden;
    }
    .modern-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .modern-table thead th {
        background: #F9FAFB; padding: 12px 20px; text-align: left;
        font-size: 11px; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    .modern-table tbody td {
        padding: 12px 20px; border-bottom: 1px solid #F3F4F6; vertical-align: middle;
    }
    .modern-table tbody tr:last-child td { border-bottom: none; }
    .modern-table tbody tr:hover { background: #FAFBFF; }

    .row-index {
        display: inline-block; width: 24px; height: 24px;
        background: #F3F4F6; border-radius: 6px; text-align: center;
        line-height: 24px; font-size: 11px; font-weight: 600;
        color: var(--text-secondary);
    }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let charts = {};

    async function loadData() {
        const period = document.getElementById('period-filter').value || '30days';
        const res = await fetch('<?= base_url('reports/data') ?>?period=' + period);
        const json = await res.json();

        if (! json.success) {
            showAlert('Gagal memuat data laporan.', 'error');
            return;
        }

        document.getElementById('sum-revenue').textContent      = 'Rp ' + parseInt(json.summary.total_revenue).toLocaleString('id-ID');
        document.getElementById('sum-reservations').textContent = json.summary.total_reservations;
        document.getElementById('sum-occupancy').textContent    = json.summary.occupancy_rate + '%';
        document.getElementById('sum-items').textContent        = json.summary.total_items;

        renderRevenueChart(json.revenue_chart);
        renderOccupancyChart(json.occupancy_chart);
        renderRoomStatusChart(json.room_status_chart);
        renderDepartmentChart(json.department_chart);
        renderTopRooms(json.top_rooms);
        renderTopItems(json.top_items);
    }

    function destroyChart(key) {
        if (charts[key]) { charts[key].destroy(); delete charts[key]; }
    }

    function renderRevenueChart(data) {
        destroyChart('revenue');
        const ctx = document.getElementById('chart-revenue').getContext('2d');
        charts.revenue = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: data.values,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.08)',
                    borderWidth: 2.5,
                    tension: 0.35,
                    fill: true,
                    pointBackgroundColor: '#10B981',
                    pointRadius: 3,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: { label: (ctx) => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID') }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F3F4F6' },
                        ticks: {
                            color: '#9CA3AF',
                            callback: (v) => 'Rp ' + (v >= 1000000 ? (v / 1000000).toFixed(1) + 'jt' : (v / 1000).toFixed(0) + 'rb')
                        }
                    },
                    x: { grid: { display: false }, ticks: { color: '#9CA3AF' } }
                }
            }
        });
    }

    function renderOccupancyChart(data) {
        destroyChart('occupancy');
        const ctx = document.getElementById('chart-occupancy').getContext('2d');
        charts.occupancy = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Okupansi (%)',
                    data: data.values,
                    backgroundColor: '#6C5CE7',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: { label: (ctx) => ctx.parsed.y + '%' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true, max: 100,
                        grid: { color: '#F3F4F6' },
                        ticks: { color: '#9CA3AF', callback: (v) => v + '%' }
                    },
                    x: { grid: { display: false }, ticks: { color: '#9CA3AF' } }
                }
            }
        });
    }

    function renderRoomStatusChart(data) {
        destroyChart('roomStatus');
        const ctx = document.getElementById('chart-room-status').getContext('2d');
        charts.roomStatus = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: data.colors,
                    borderWidth: 3,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                cutout: '62%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 }, usePointStyle: true } },
                }
            }
        });
    }

    function renderDepartmentChart(data) {
        destroyChart('department');
        const ctx = document.getElementById('chart-department').getContext('2d');
        charts.department = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Jumlah SR',
                    data: data.values,
                    backgroundColor: ['#6C5CE7', '#10B981', '#F59E0B', '#E65100', '#7C3AED'],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#111827', padding: 12, cornerRadius: 8 }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { color: '#9CA3AF', stepSize: 1 } },
                    x: { grid: { display: false }, ticks: { color: '#9CA3AF' } }
                }
            }
        });
    }

    function renderTopRooms(rooms) {
        const tbody = document.querySelector('#table-top-rooms tbody');
        if (rooms.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding:32px; color:var(--text-muted);">Belum ada data.</td></tr>';
            return;
        }
        let html = '';
        rooms.forEach((r, i) => {
            html += `
                <tr>
                    <td><span class="row-index">${i + 1}</span></td>
                    <td><div class="cell-title">Kamar ${r.room_number}</div><div class="cell-sub">Lantai ${r.floor}</div></td>
                    <td>${r.type_name || '-'}</td>
                    <td style="text-align: right;"><strong style="color: var(--primary); font-size: 14px;">${r.total_bookings}</strong></td>
                </tr>
            `;
        });
        tbody.innerHTML = html;
    }

    function renderTopItems(items) {
        const tbody = document.querySelector('#table-top-items tbody');
        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:32px; color:var(--text-muted);">Belum ada data.</td></tr>';
            return;
        }
        let html = '';
        items.forEach((it, i) => {
            html += `
                <tr>
                    <td><span class="row-index">${i + 1}</span></td>
                    <td><div class="cell-title">${it.name}</div></td>
                    <td style="text-align: right;">
                        <strong style="color: var(--primary); font-size: 14px;">${it.total_qty}</strong>
                        <span style="color: var(--text-muted); font-size: 12px;"> ${it.unit}</span>
                    </td>
                </tr>
            `;
        });
        tbody.innerHTML = html;
    }

    function exportPDF() {
        const period = document.getElementById('period-filter').value || '30days';
        fetch('<?= base_url('reports/data') ?>?period=' + period)
            .then(res => res.json())
            .then(json => {
                if (! json.success) {
                    showAlert('Gagal mengambil data untuk PDF.', 'error');
                    return;
                }

                const chartImages = {
                    revenue:     charts.revenue     ? charts.revenue.toBase64Image()     : '',
                    occupancy:   charts.occupancy   ? charts.occupancy.toBase64Image()   : '',
                    room_status: charts.roomStatus  ? charts.roomStatus.toBase64Image()  : '',
                    department:  charts.department  ? charts.department.toBase64Image()  : '',
                };

                document.getElementById('pdf-data').value   = JSON.stringify(json);
                document.getElementById('pdf-charts').value = JSON.stringify(chartImages);
                document.getElementById('form-pdf').submit();

                showAlert('Menyiapkan PDF...', 'info', 2000);
            })
            .catch(err => {
                console.error(err);
                showAlert('Gagal export PDF.', 'error');
            });
    }

    // Load pertama kali
    loadData();
</script>
<?= $this->endSection() ?>