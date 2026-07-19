<?php
$pageTitle = 'Manager Dashboard — G&G Sentinel';
require __DIR__ . '/../partials/header.php';

$fmt = fn(float $n): string => '₦' . number_format($n, 2);
?>

<!-- Page header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manager Dashboard</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            <?= date('l, d F Y') ?> &mdash;
            <span class="text-gray-600 font-medium"><?= htmlspecialchars($user['full_name']) ?></span>
        </p>
    </div>
    <div class="flex items-center gap-2 text-xs text-gray-400">
        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
        Near Real-Time Sentinel
    </div>
</div>

<!-- Flash -->
<?php if (!empty($flash['success'])): ?>
<div class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-3 text-sm">
    <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?= htmlspecialchars($flash['success']) ?>
</div>
<?php endif; ?>

<!-- ── Daily Stats Cards ─────────────────────────── -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

    <!-- Total Transactions -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Transactions</div>
        <div class="text-2xl font-bold text-gray-800"><?= number_format((int)$stats['transaction_count']) ?></div>
        <div class="text-xs text-gray-400 mt-1">Today</div>
    </div>

    <!-- Revenue -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Revenue</div>
        <div class="text-2xl font-bold text-brand-700"><?= $fmt((float)$stats['total_revenue']) ?></div>
        <div class="text-xs text-gray-400 mt-1">Today</div>
    </div>

    <!--
        OBSERVATION COMPONENT
        Average Transaction Value (ATV) — the key metric for spotting anomalies.
        SQL: SELECT ROUND(AVG(total_amount), 2) FROM transactions WHERE created_at >= CURRENT_DATE
    -->
    <div class="bg-blue-50 rounded-xl border border-blue-200 shadow-sm p-5">
        <div class="text-xs text-blue-500 uppercase tracking-wide mb-1">Avg Txn Value</div>
        <div class="text-2xl font-bold text-blue-700"><?= $fmt((float)$stats['avg_transaction_value']) ?></div>
        <div class="text-xs text-blue-400 mt-1">Daily Norm (ATV)</div>
    </div>

    <!-- Flagged -->
    <div class="<?= (int)$stats['flagged_count'] > 0 ? 'bg-red-50 border-red-200' : 'bg-white border-gray-100' ?> rounded-xl border shadow-sm p-5">
        <div class="text-xs <?= (int)$stats['flagged_count'] > 0 ? 'text-red-500' : 'text-gray-500' ?> uppercase tracking-wide mb-1">Flagged</div>
        <div class="text-2xl font-bold <?= (int)$stats['flagged_count'] > 0 ? 'text-red-600' : 'text-gray-800' ?>"><?= number_format((int)$stats['flagged_count']) ?></div>
        <div class="text-xs <?= (int)$stats['flagged_count'] > 0 ? 'text-red-400' : 'text-gray-400' ?> mt-1">Anomalies Today</div>
    </div>

    <!-- Pending Review -->
    <div class="<?= (int)$stats['pending_review_count'] > 0 ? 'bg-amber-50 border-amber-200' : 'bg-white border-gray-100' ?> rounded-xl border shadow-sm p-5">
        <div class="text-xs <?= (int)$stats['pending_review_count'] > 0 ? 'text-amber-600' : 'text-gray-500' ?> uppercase tracking-wide mb-1">Pending Review</div>
        <div class="text-2xl font-bold <?= (int)$stats['pending_review_count'] > 0 ? 'text-amber-600' : 'text-gray-800' ?>"><?= number_format((int)$stats['pending_review_count']) ?></div>
        <div class="text-xs <?= (int)$stats['pending_review_count'] > 0 ? 'text-amber-400' : 'text-gray-400' ?> mt-1">Need Attention</div>
    </div>
</div>

<!-- ATV explanation callout -->
<?php if ((int)$stats['transaction_count'] > 0 && (float)$stats['avg_transaction_value'] > 0): ?>
<div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl px-5 py-3 text-sm text-blue-800 flex items-start gap-2">
    <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span>
        <strong>Daily Norm:</strong> Today's Average Transaction Value (ATV) is
        <strong><?= $fmt((float)$stats['avg_transaction_value']) ?></strong>.
        Any transaction significantly above this figure warrants closer scrutiny.
        Flagged anomalies are highlighted in red below.
    </span>
</div>
<?php endif; ?>

<!-- ── Transactions Table ──────────────────────────── -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h2 class="font-semibold text-gray-700">All Transactions</h2>
        <div class="flex items-center gap-2 text-xs">
            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-2 py-1 rounded-full font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Anomalous
            </span>
            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Normal
            </span>
            <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 px-2 py-1 rounded-full font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Reviewed
            </span>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="px-6 pt-3 pb-0 flex gap-1 border-b border-gray-100">
        <button onclick="filterTable('all')" id="tab-all"
                class="tab-btn px-4 py-2 text-xs font-medium rounded-t-lg border-b-2 border-brand-700 text-brand-700 bg-brand-50">
            All
        </button>
        <button onclick="filterTable('flagged')" id="tab-flagged"
                class="tab-btn px-4 py-2 text-xs font-medium rounded-t-lg border-b-2 border-transparent text-gray-500 hover:text-gray-700">
            Flagged Only
        </button>
        <button onclick="filterTable('unreviewed')" id="tab-unreviewed"
                class="tab-btn px-4 py-2 text-xs font-medium rounded-t-lg border-b-2 border-transparent text-gray-500 hover:text-gray-700">
            Pending Review
        </button>
    </div>

    <?php if (empty($transactions)): ?>
    <div class="py-16 text-center text-gray-400 text-sm">
        No transactions found. Cashiers haven't logged any sales yet.
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="txTable">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Cashier</th>
                    <th class="px-4 py-3 text-left">Product</th>
                    <th class="px-4 py-3 text-right">Qty</th>
                    <th class="px-4 py-3 text-right">Unit Price</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-left">Anomaly Reason</th>
                    <th class="px-4 py-3 text-right">Time</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
            <?php foreach ($transactions as $tx):
                $isAnomaly   = (bool) $tx['is_anomalous'];
                $isReviewed  = (bool) $tx['reviewed'];
                $rowClass    = $isAnomaly && !$isReviewed
                    ? 'bg-red-50 hover:bg-red-100'
                    : ($isAnomaly && $isReviewed ? 'bg-gray-50 hover:bg-gray-100' : 'hover:bg-gray-50');
            ?>
            <tr class="<?= $rowClass ?> transition tx-row"
                data-anomalous="<?= $isAnomaly ? '1' : '0' ?>"
                data-reviewed="<?= $isReviewed ? '1' : '0' ?>">
                <td class="px-4 py-3 text-gray-400 font-mono text-xs">#<?= $tx['id'] ?></td>
                <td class="px-4 py-3">
                    <div class="font-medium text-gray-800"><?= htmlspecialchars($tx['cashier_name']) ?></div>
                    <div class="text-xs text-gray-400">@<?= htmlspecialchars($tx['cashier_username']) ?></div>
                </td>
                <td class="px-4 py-3 text-gray-700"><?= htmlspecialchars($tx['product_name']) ?></td>
                <td class="px-4 py-3 text-right text-gray-600"><?= $tx['quantity'] ?></td>
                <td class="px-4 py-3 text-right text-gray-500 text-xs">₦<?= number_format((float)$tx['unit_price'], 2) ?></td>
                <td class="px-4 py-3 text-right font-bold <?= $isAnomaly && !$isReviewed ? 'text-red-700' : 'text-gray-800' ?>">
                    <?= $fmt((float)$tx['total_amount']) ?>
                </td>
                <td class="px-4 py-3 text-center">
                    <?php if ($isAnomaly && !$isReviewed): ?>
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Flagged
                    </span>
                    <?php elseif ($isAnomaly && $isReviewed): ?>
                    <span class="inline-flex items-center gap-1 bg-gray-200 text-gray-600 text-xs font-medium px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Reviewed
                    </span>
                    <?php else: ?>
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Normal
                    </span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 max-w-xs">
                    <?php if ($tx['anomaly_reason']): ?>
                    <span class="text-xs text-red-600 leading-snug"><?= htmlspecialchars($tx['anomaly_reason']) ?></span>
                    <?php else: ?>
                    <span class="text-gray-300 text-xs">—</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 text-right text-gray-400 text-xs whitespace-nowrap">
                    <div><?= date('d M Y', strtotime($tx['created_at'])) ?></div>
                    <div><?= date('H:i:s', strtotime($tx['created_at'])) ?></div>
                </td>
                <td class="px-4 py-3 text-center">
                    <?php if ($isAnomaly && !$isReviewed): ?>
                    <form method="post" action="<?= BASE_URL ?>/review-transaction"
                          onsubmit="return confirm('Mark transaction #<?= $tx['id'] ?> as reviewed?')">
                        <input type="hidden" name="csrf_token" value="<?= Auth::csrfToken() ?>">
                        <input type="hidden" name="transaction_id" value="<?= $tx['id'] ?>">
                        <button type="submit"
                                class="text-xs bg-amber-500 hover:bg-amber-600 text-white font-semibold px-3 py-1.5 rounded-lg transition whitespace-nowrap">
                            Review
                        </button>
                    </form>
                    <?php else: ?>
                    <span class="text-gray-300 text-xs">—</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<script>
(function () {
    const tabs = document.querySelectorAll('.tab-btn');
    const rows = document.querySelectorAll('.tx-row');

    function setActive(id) {
        tabs.forEach(function(t) {
            const active = t.id === 'tab-' + id;
            t.className = active
                ? 'tab-btn px-4 py-2 text-xs font-medium rounded-t-lg border-b-2 border-brand-700 text-brand-700 bg-brand-50'
                : 'tab-btn px-4 py-2 text-xs font-medium rounded-t-lg border-b-2 border-transparent text-gray-500 hover:text-gray-700';
        });
    }

    window.filterTable = function(filter) {
        setActive(filter);
        rows.forEach(function(r) {
            const anomalous  = r.dataset.anomalous === '1';
            const reviewed   = r.dataset.reviewed  === '1';
            let   show       = true;
            if (filter === 'flagged')    show = anomalous;
            if (filter === 'unreviewed') show = anomalous && !reviewed;
            r.style.display = show ? '' : 'none';
        });
    };

    // Refresh page every 30 seconds so manager sees near-real-time data
    setTimeout(function() { window.location.reload(); }, 30000);
})();
</script>

<?php require __DIR__ . '/../partials/footer.php'; ?>
