<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= esc($reservation['reservation_code']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 30px 40px;
        }
        .header {
            border-bottom: 3px solid #1A56DB;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .header table { width: 100%; }
        .header .hotel-name {
            font-size: 26px;
            font-weight: bold;
            color: #1A56DB;
            letter-spacing: 1px;
        }
        .header .hotel-sub {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
        }
        .header .invoice-label {
            font-size: 22px;
            font-weight: bold;
            text-align: right;
            color: #333;
        }
        .header .invoice-code {
            font-size: 13px;
            text-align: right;
            color: #1A56DB;
            font-weight: bold;
            margin-top: 4px;
        }
        .info-section {
            width: 100%;
            margin-bottom: 24px;
        }
        .info-section table { width: 100%; }
        .info-section td { vertical-align: top; padding: 4px 0; }
        .info-box {
            width: 48%;
            padding: 12px 16px;
            background: #f8f9ff;
            border-radius: 6px;
        }
        .info-box h4 {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .info-box p { margin: 2px 0; font-size: 12px; }
        .info-box .name { font-weight: bold; font-size: 13px; color: #1A56DB; }

        table.detail {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        table.detail thead th {
            background: #1A56DB;
            color: white;
            padding: 10px 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.detail tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 12px;
        }
        table.detail tbody tr:nth-child(even) {
            background: #fafbff;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .summary {
            width: 100%;
            margin-top: 12px;
        }
        .summary table {
            width: 50%;
            margin-left: 50%;
            border-collapse: collapse;
        }
        .summary td {
            padding: 6px 12px;
            font-size: 12px;
        }
        .summary .label { color: #666; }
        .summary .amount { text-align: right; font-weight: 600; }
        .summary .total-row td {
            border-top: 2px solid #1A56DB;
            padding-top: 10px;
            font-size: 15px;
            font-weight: bold;
            color: #1A56DB;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-pending     { background: #F0B100; color: #000; }
        .status-confirmed   { background: #1A56DB; color: #fff; }
        .status-checked_in  { background: #146C2E; color: #fff; }
        .status-checked_out { background: #757575; color: #fff; }
        .status-cancelled   { background: #BA1A1A; color: #fff; }

        .footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 1px solid #e0e0e0;
            font-size: 10px;
            color: #888;
            text-align: center;
        }
        .footer .thanks {
            font-size: 14px;
            color: #1A56DB;
            font-weight: bold;
            margin-bottom: 6px;
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
                    <div class="invoice-label">INVOICE</div>
                    <div class="invoice-code"><?= esc($reservation['reservation_code']) ?></div>
                </td>
            </tr>
        </table>
    </div>

    <!-- INFO TAMU & RESERVASI -->
    <div class="info-section">
        <table>
            <tr>
                <td style="width: 50%;">
                    <div class="info-box">
                        <h4>Ditagihkan Kepada</h4>
                        <p class="name"><?= esc($guest['full_name']) ?></p>
                        <p>No. Identitas: <?= esc($guest['id_number'] ?: '-') ?></p>
                        <p>Telepon: <?= esc($guest['phone'] ?: '-') ?></p>
                        <p>Email: <?= esc($guest['email'] ?: '-') ?></p>
                        <?php if (! empty($guest['address'])): ?>
                            <p>Alamat: <?= esc($guest['address']) ?></p>
                        <?php endif; ?>
                    </div>
                </td>
                <td style="width: 4%;"></td>
                <td style="width: 46%;">
                    <div class="info-box">
                        <h4>Detail Reservasi</h4>
                        <p>Tanggal Cetak: <?= date('d M Y H:i') ?></p>
                        <p>Check-in: <strong><?= date('d M Y', strtotime($reservation['check_in_date'])) ?></strong></p>
                        <p>Check-out: <strong><?= date('d M Y', strtotime($reservation['check_out_date'])) ?></strong></p>
                        <p style="margin-top: 8px;">
                            Status:
                            <span class="status-badge status-<?= esc($reservation['status']) ?>">
                                <?= ucwords(str_replace('_', ' ', $reservation['status'])) ?>
                            </span>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- DETAIL KAMAR -->
    <table class="detail">
        <thead>
            <tr>
                <th style="width: 40px;" class="text-center">#</th>
                <th>Deskripsi</th>
                <th style="width: 100px;" class="text-center">Lantai</th>
                <th style="width: 120px;" class="text-center">Jumlah Malam</th>
                <th style="width: 140px;" class="text-right">Harga / Malam</th>
                <th style="width: 150px;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>
                    <strong>Kamar <?= esc($room['room_number']) ?></strong><br>
                    <span style="color: #666; font-size: 11px;">
                        Tipe: <?= esc($room['type_name'] ?? '-') ?>
                    </span>
                </td>
                <td class="text-center">Lantai <?= esc($room['floor']) ?></td>
                <td class="text-center"><?= $nights ?> malam</td>
                <td class="text-right">Rp <?= number_format($pricePerNight, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <!-- SUMMARY -->
    <div class="summary">
        <table>
            <tr>
                <td class="label">Subtotal</td>
                <td class="amount">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="label">Pajak (10%)</td>
                <td class="amount">Rp <?= number_format($tax, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="label">Service Charge (5%)</td>
                <td class="amount">Rp <?= number_format($service, 0, ',', '.') ?></td>
            </tr>
            <tr class="total-row">
                <td>TOTAL</td>
                <td class="amount">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>

    <?php if (! empty($reservation['notes'])): ?>
        <div style="margin-top: 24px; padding: 12px 16px; background: #f8f9ff; border-radius: 6px;">
            <strong style="font-size: 11px; text-transform: uppercase; color: #888;">Catatan:</strong>
            <p style="margin-top: 4px;"><?= esc($reservation['notes']) ?></p>
        </div>
    <?php endif; ?>

    <!-- FOOTER -->
    <div class="footer">
        <div class="thanks">Terima kasih atas kunjungan Anda</div>
        <p>Invoice ini di-generate otomatis oleh Sistem Hotel. Harap simpan sebagai bukti pembayaran yang sah.</p>
        <p style="margin-top: 4px;">Dicetak pada: <?= date('d F Y, H:i:s') ?> WIB</p>
    </div>

</body>
</html>