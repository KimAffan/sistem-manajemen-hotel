<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan <?= esc(app_setting('hotel_name', 'Sistem Hotel')) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            padding: 30px 40px;
        }
        .header {
            border-bottom: 3px solid #6C5CE7;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header table { width: 100%; }
        .header .hotel-name {
            font-size: 22px;
            font-weight: bold;
            color: #6C5CE7;
            letter-spacing: 1px;
        }
        .header .hotel-sub {
            font-size: 10px;
            color: #666;
            margin-top: 4px;
        }
        .header .report-label {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            color: #333;
        }
        .header .report-period {
            font-size: 11px;
            text-align: right;
            color: #6C5CE7;
            font-weight: bold;
            margin-top: 4px;
        }
        .meta-line {
            font-size: 10px;
            color: #888;
            text-align: right;
            margin-top: 2px;
        }

        h3 {
            font-size: 13px;
            color: #6C5CE7;
            margin: 20px 0 10px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }

        table.summary {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 16px;
        }
        table.summary td {
            width: 25%;
            padding: 12px;
            background: #F5F3FF;
            border-radius: 6px;
            vertical-align: top;
        }
        table.summary .label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.summary .value {
            font-size: 16px;
            font-weight: bold;
            color: #6C5CE7;
            margin-top: 4px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10px;
        }
        table.data thead th {
            background: #6C5CE7;
            color: white;
            padding: 7px 10px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.data tbody td {
            padding: 6px 10px;
            border-bottom: 1px solid #e5e5e5;
        }
        table.data tbody tr:nth-child(even) {
            background: #FAFBFF;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .chart-row {
            width: 100%;
            margin-bottom: 16px;
        }
        .chart-row table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
        }
        .chart-row td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }
        .chart-row img {
            max-width: 100%;
        }

        .footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="hotel-name"><?= strtoupper(app_setting('hotel_name', 'SISTEM HOTEL')) ?></div>
                    <div class="hotel-sub">
                        <?= app_setting('hotel_address', 'Jl. Contoh No. 123') ?><br>
                        Telp: <?= app_setting('hotel_phone', '-') ?> | Email: <?= app_setting('hotel_email', '-') ?>
                    </div>
                </td>
                <td>
                    <div class="report-label">LAPORAN</div>
                    <div class="report-period"><?= esc($data['period']['label'] ?? 'Periode') ?></div>
                    <div class="meta-line">
                        <?= esc($data['period']['start'] ?? '') ?> s/d <?= esc($data['period']['end'] ?? '') ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- SUMMARY -->
    <h3>Ringkasan</h3>
    <table class="summary">
        <tr>
            <td>
                <div class="label">Total Pendapatan</div>
                <div class="value">Rp <?= number_format($data['summary']['total_revenue'] ?? 0, 0, ',', '.') ?></div>
            </td>
            <td>
                <div class="label">Total Reservasi</div>
                <div class="value"><?= $data['summary']['total_reservations'] ?? 0 ?></div>
            </td>
            <td>
                <div class="label">Tingkat Okupansi</div>
                <div class="value"><?= $data['summary']['occupancy_rate'] ?? 0 ?>%</div>
            </td>
            <td>
                <div class="label">Item Terkirim</div>
                <div class="value"><?= $data['summary']['total_items'] ?? 0 ?></div>
            </td>
        </tr>
    </table>

    <!-- GRAFIK -->
    <?php if (! empty($charts['revenue']) || ! empty($charts['occupancy'])): ?>
        <h3>Grafik</h3>
        <div class="chart-row">
            <table>
                <tr>
                    <?php if (! empty($charts['revenue'])): ?>
                        <td>
                            <div style="font-size: 10px; color: #666; margin-bottom: 6px;">Pendapatan Harian</div>
                            <img src="<?= $charts['revenue'] ?>" alt="Revenue Chart">
                        </td>
                    <?php endif; ?>
                    <?php if (! empty($charts['occupancy'])): ?>
                        <td>
                            <div style="font-size: 10px; color: #666; margin-bottom: 6px;">Okupansi Harian</div>
                            <img src="<?= $charts['occupancy'] ?>" alt="Occupancy Chart">
                        </td>
                    <?php endif; ?>
                </tr>
            </table>
        </div>
    <?php endif; ?>

    <?php if (! empty($charts['room_status']) || ! empty($charts['department'])): ?>
        <div class="chart-row">
            <table>
                <tr>
                    <?php if (! empty($charts['room_status'])): ?>
                        <td>
                            <div style="font-size: 10px; color: #666; margin-bottom: 6px;">Status Kamar</div>
                            <img src="<?= $charts['room_status'] ?>" alt="Room Status" style="max-height: 220px;">
                        </td>
                    <?php endif; ?>
                    <?php if (! empty($charts['department'])): ?>
                        <td>
                            <div style="font-size: 10px; color: #666; margin-bottom: 6px;">SR per Departemen</div>
                            <img src="<?= $charts['department'] ?>" alt="Department" style="max-height: 220px;">
                        </td>
                    <?php endif; ?>
                </tr>
            </table>
        </div>
    <?php endif; ?>

    <!-- TABEL TOP 5 KAMAR -->
    <h3>Top 5 Kamar Paling Sering Dipesan</h3>
    <table class="data">
        <thead>
            <tr>
                <th class="text-center" style="width: 40px;">#</th>
                <th>No. Kamar</th>
                <th>Lantai</th>
                <th>Tipe</th>
                <th class="text-right">Jumlah Pesanan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['top_rooms'])): ?>
                <tr><td colspan="5" class="text-center" style="padding: 16px; color: #888;">Belum ada data.</td></tr>
            <?php else: ?>
                <?php foreach ($data['top_rooms'] as $i => $r): ?>
                    <tr>
                        <td class="text-center"><?= $i + 1 ?></td>
                        <td><strong><?= esc($r['room_number']) ?></strong></td>
                        <td>Lantai <?= esc($r['floor']) ?></td>
                        <td><?= esc($r['type_name'] ?? '-') ?></td>
                        <td class="text-right"><strong><?= $r['total_bookings'] ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- TABEL TOP 5 BARANG -->
    <h3>Top 5 Barang Paling Banyak Diminta</h3>
    <table class="data">
        <thead>
            <tr>
                <th class="text-center" style="width: 40px;">#</th>
                <th>Nama Barang</th>
                <th class="text-right">Total Qty</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data['top_items'])): ?>
                <tr><td colspan="4" class="text-center" style="padding: 16px; color: #888;">Belum ada data.</td></tr>
            <?php else: ?>
                <?php foreach ($data['top_items'] as $i => $it): ?>
                    <tr>
                        <td class="text-center"><?= $i + 1 ?></td>
                        <td><strong><?= esc($it['name']) ?></strong></td>
                        <td class="text-right"><strong><?= $it['total_qty'] ?></strong></td>
                        <td><?= esc($it['unit']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Laporan ini di-generate otomatis oleh <?= esc(app_setting('hotel_name', 'Sistem Hotel')) ?></p>
        <p style="margin-top: 4px;">Dicetak pada: <?= esc($generatedAt) ?> WIB</p>
    </div>

</body>
</html>