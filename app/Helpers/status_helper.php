<?php

if (! function_exists('status_badge')) {
    /**
     * Render badge HTML untuk status kamar
     */
    function status_badge(string $status): string
    {
        $map = [
            'vacant_clean'   => ['label' => 'Vacant Clean',   'bg' => '#146C2E', 'color' => '#fff'],
            'vacant_dirty'   => ['label' => 'Vacant Dirty',   'bg' => '#F0B100', 'color' => '#000'],
            'occupied'       => ['label' => 'Occupied',       'bg' => '#BA1A1A', 'color' => '#fff'],
            'on_change'      => ['label' => 'On Change',      'bg' => '#1A56DB', 'color' => '#fff'],
            'out_of_order'   => ['label' => 'Out of Order',   'bg' => '#E65100', 'color' => '#fff'],
            'out_of_service' => ['label' => 'Out of Service', 'bg' => '#757575', 'color' => '#fff'],
        ];

        $s = $map[$status] ?? ['label' => $status, 'bg' => '#ccc', 'color' => '#000'];

        return sprintf(
            '<span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600; background:%s; color:%s;">%s</span>',
            $s['bg'],
            $s['color'],
            esc($s['label'])
        );
    }
    if (! function_exists('reservation_badge')) {
    /**
     * Render badge HTML untuk status reservasi
     */
    function reservation_badge(string $status): string
    {
        $map = [
            'pending'     => ['label' => 'Pending',     'bg' => '#F0B100', 'color' => '#000'],
            'confirmed'   => ['label' => 'Confirmed',   'bg' => '#1A56DB', 'color' => '#fff'],
            'checked_in'  => ['label' => 'Checked In',  'bg' => '#146C2E', 'color' => '#fff'],
            'checked_out' => ['label' => 'Checked Out', 'bg' => '#757575', 'color' => '#fff'],
            'cancelled'   => ['label' => 'Cancelled',   'bg' => '#BA1A1A', 'color' => '#fff'],
        ];

        $s = $map[$status] ?? ['label' => $status, 'bg' => '#ccc', 'color' => '#000'];

        return sprintf(
            '<span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600; background:%s; color:%s;">%s</span>',
            $s['bg'],
            $s['color'],
            esc($s['label'])
        );
    }
}
}
if (! function_exists('hk_badge')) {
    /**
     * Badge untuk status housekeeping
     */
    function hk_badge(string $status): string
    {
        $map = [
            'pending'     => ['label' => 'Pending',     'bg' => '#F0B100', 'color' => '#000'],
            'in_progress' => ['label' => 'In Progress', 'bg' => '#1A56DB', 'color' => '#fff'],
            'done'        => ['label' => 'Done',        'bg' => '#146C2E', 'color' => '#fff'],
            'verified'    => ['label' => 'Verified',    'bg' => '#4A148C', 'color' => '#fff'],
        ];
        $s = $map[$status] ?? ['label' => $status, 'bg' => '#ccc', 'color' => '#000'];
        return sprintf(
            '<span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600; background:%s; color:%s;">%s</span>',
            $s['bg'], $s['color'], esc($s['label'])
        );
    }
}

if (! function_exists('task_type_label')) {
    /**
     * Label tipe tugas
     */
    function task_type_label(string $type): string
    {
        return match ($type) {
            'daily_clean'    => 'Daily Clean',
            'checkout_clean' => 'Checkout Clean',
            'deep_clean'     => 'Deep Clean',
            'inspection'     => 'Inspection',
            default          => ucfirst(str_replace('_', ' ', $type)),
        };
    }
}
if (! function_exists('stock_badge')) {
    /**
     * Badge untuk status stok barang
     */
    function stock_badge(int $current, int $minimum): string
    {
        if ($current <= 0) {
            return '<span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600; background:#BA1A1A; color:#fff;">Habis</span>';
        }
        if ($current <= $minimum) {
            return '<span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600; background:#F0B100; color:#000;">Menipis</span>';
        }
        return '<span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600; background:#146C2E; color:#fff;">Aman</span>';
    }
}
if (! function_exists('sr_badge')) {
    function sr_badge(string $status): string
    {
        $map = [
            'pending'   => ['label' => 'Pending',   'bg' => '#F0B100', 'color' => '#000'],
            'approved'  => ['label' => 'Approved',  'bg' => '#1A56DB', 'color' => '#fff'],
            'rejected'  => ['label' => 'Rejected',  'bg' => '#BA1A1A', 'color' => '#fff'],
            'delivered' => ['label' => 'Delivered', 'bg' => '#146C2E', 'color' => '#fff'],
        ];
        $s = $map[$status] ?? ['label' => $status, 'bg' => '#ccc', 'color' => '#000'];
        return sprintf(
            '<span style="display:inline-block; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600; background:%s; color:%s;">%s</span>',
            $s['bg'], $s['color'], esc($s['label'])
        );
    }
}

if (! function_exists('department_label')) {
    function department_label(string $dept): string
    {
        return match ($dept) {
            'housekeeping'  => 'Housekeeping',
            'kitchen'       => 'Kitchen',
            'fb'            => 'Food & Beverage',
            'engineering'   => 'Engineering',
            'front_office'  => 'Front Office',
            default         => ucfirst(str_replace('_', ' ', $dept)),
        };
    }
}