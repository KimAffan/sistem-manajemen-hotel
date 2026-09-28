<?php
/**
 * Pagination Component (Self-contained)
 *
 * Variables:
 * @var \CodeIgniter\Pager\Pager $pager
 * @var int    $perPage
 * @var string $baseUrl
 * @var array  $queryParams  (opsional)
 */

$baseUrl     = $baseUrl     ?? base_url();
$perPage     = $perPage     ?? 10;
$queryParams = $queryParams ?? [];

$currentPage = $pager->getCurrentPage();
$totalPages  = max(1, $pager->getPageCount());
$totalItems  = $pager->getTotal();
$start       = $totalItems > 0 ? ($currentPage - 1) * $perPage + 1 : 0;
$end         = min($currentPage * $perPage, $totalItems);

$buildUrl = function ($page) use ($baseUrl, $perPage, $queryParams) {
    $params = array_merge($queryParams, ['per_page' => $perPage, 'page' => $page]);
    return $baseUrl . '?' . http_build_query($params);
};

$pageRange = 2;
$startPage = max(1, $currentPage - $pageRange);
$endPage   = min($totalPages, $currentPage + $pageRange);

// Unique ID untuk dropdown di halaman ini
$selectId = 'perPageSelect_' . uniqid();
?>

<?php if ($totalItems > 0): ?>
<div class="pagination-bar">
    <div class="pagination-info">
        Menampilkan <strong><?= $start ?></strong> – <strong><?= $end ?></strong>
        dari <strong><?= number_format($totalItems, 0, ',', '.') ?></strong> data
    </div>

    <div class="pagination-controls">
        <a href="<?= $buildUrl(1) ?>" class="page-btn <?= $currentPage <= 1 ? 'disabled' : '' ?>" title="Halaman Pertama">
            <mdui-icon name="first_page"></mdui-icon>
        </a>
        <a href="<?= $buildUrl(max(1, $currentPage - 1)) ?>" class="page-btn <?= $currentPage <= 1 ? 'disabled' : '' ?>" title="Sebelumnya">
            <mdui-icon name="chevron_left"></mdui-icon>
        </a>

        <?php if ($startPage > 1): ?>
            <span class="page-ellipsis">…</span>
        <?php endif; ?>

        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <a href="<?= $buildUrl($i) ?>" class="page-btn <?= $i == $currentPage ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($endPage < $totalPages): ?>
            <span class="page-ellipsis">…</span>
        <?php endif; ?>

        <a href="<?= $buildUrl(min($totalPages, $currentPage + 1)) ?>" class="page-btn <?= $currentPage >= $totalPages ? 'disabled' : '' ?>" title="Selanjutnya">
            <mdui-icon name="chevron_right"></mdui-icon>
        </a>
        <a href="<?= $buildUrl($totalPages) ?>" class="page-btn <?= $currentPage >= $totalPages ? 'disabled' : '' ?>" title="Halaman Terakhir">
            <mdui-icon name="last_page"></mdui-icon>
        </a>
    </div>

    <div class="per-page-selector">
        <label for="<?= $selectId ?>">Tampilkan</label>
        <select id="<?= $selectId ?>" data-page-select>
            <?php foreach ([10, 20, 50, 100] as $opt): ?>
                <option value="<?= $opt ?>" <?= $perPage == $opt ? 'selected' : '' ?>><?= $opt ?></option>
            <?php endforeach; ?>
        </select>
        <label>per halaman</label>
    </div>
</div>

<script>
(function() {
    // Bind semua dropdown per-page (self-contained)
    document.querySelectorAll('select[data-page-select]').forEach(function(sel) {
        if (sel.dataset.bound === '1') return;
        sel.dataset.bound = '1';

        sel.addEventListener('change', function() {
            const v = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', v);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        });
    });
})();
</script>

<style>
    .pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 20px;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
        background: #FAFBFF;
    }
    .pagination-info {
        font-size: 12px;
        color: var(--text-muted);
    }
    .pagination-info strong { color: var(--text-primary); }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .page-btn {
        min-width: 34px;
        height: 34px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #fff;
        border: 1px solid var(--border);
        color: var(--text-secondary);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s;
    }
    .page-btn mdui-icon { font-size: 18px; }
    .page-btn:hover:not(.disabled):not(.active) {
        background: var(--primary-soft);
        color: var(--primary);
        border-color: var(--primary-light);
    }
    .page-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 2px 6px rgba(108, 92, 231, 0.3);
    }
    .page-btn.disabled {
        opacity: 0.4;
        pointer-events: none;
        cursor: not-allowed;
    }
    .page-ellipsis {
        color: var(--text-muted);
        font-size: 13px;
        padding: 0 4px;
    }

    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--text-muted);
    }
    .per-page-selector select {
        padding: 6px 10px;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s;
    }
    .per-page-selector select:hover {
        border-color: var(--primary);
    }
    .per-page-selector select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-soft);
    }

    @media (max-width: 720px) {
        .pagination-bar { justify-content: center; }
        .pagination-info { width: 100%; text-align: center; }
    }
</style>
<?php else: ?>
<div class="pagination-bar" style="justify-content: center;">
    <div class="pagination-info">Tidak ada data untuk ditampilkan.</div>
</div>
<?php endif; ?>