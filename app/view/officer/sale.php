<?php
$pageTitle = 'Record Sale — G&G Sentinel';
require __DIR__ . '/../partials/header.php';

// Build a JS-friendly price map: {product_id: price, ...}
$priceMap = [];
foreach ($products as $p) {
    $priceMap[(int)$p['id']] = (float)$p['price'];
}
?>

<!-- Page header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Record Sale</h1>
        <p class="text-sm text-gray-500 mt-0.5">
            Cashier: <span class="font-medium text-gray-700"><?= htmlspecialchars($user['full_name']) ?></span>
            &mdash; <?= date('l, d M Y') ?>
        </p>
    </div>
    <div class="hidden sm:flex items-center gap-1.5 text-xs text-gray-400">
        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
        Live Sentinel Active
    </div>
</div>

<!-- Flash messages -->
<?php if (!empty($flash['success'])): ?>
<div id="flash-success"
     class="mb-5 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm">
    <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <div><span class="font-semibold">Sale Recorded</span><br><?= htmlspecialchars($flash['success']) ?></div>
</div>
<?php endif; ?>

<?php if (!empty($flash['warning'])): ?>
<div id="flash-warning"
     class="mb-5 flex items-start gap-3 bg-amber-50 border border-amber-300 text-amber-800 rounded-xl px-5 py-4 text-sm">
    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
    </svg>
    <div>
        <span class="font-semibold text-amber-900">Transaction Flagged!</span><br>
        <?= htmlspecialchars($flash['warning']) ?>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($flash['error'])): ?>
<div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm">
    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
    </svg>
    <?= htmlspecialchars($flash['error']) ?>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- ── Sale Form ────────────────────────────── -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-700 text-base mb-5 flex items-center gap-2">
                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                New Sale
            </h2>

            <form method="post" action="<?= BASE_URL ?>/save-sale" id="saleForm">
                <input type="hidden" name="csrf_token" value="<?= Auth::csrfToken() ?>">

                <!-- Product -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1.5" for="product_id">Product</label>
                    <select id="product_id" name="product_id" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-600 transition bg-white">
                        <option value="">-- Select product --</option>
                        <?php
                        $currentCategory = '';
                        foreach ($products as $p):
                            if ($p['category'] !== $currentCategory):
                                if ($currentCategory !== '') echo '</optgroup>';
                                echo '<optgroup label="' . htmlspecialchars($p['category']) . '">';
                                $currentCategory = $p['category'];
                            endif;
                        ?>
                        <option value="<?= $p['id'] ?>"
                                data-price="<?= number_format((float)$p['price'], 2, '.', '') ?>">
                            <?= htmlspecialchars($p['name']) ?> — ₦<?= number_format((float)$p['price'], 2) ?>
                        </option>
                        <?php endforeach; ?>
                        <?php if ($currentCategory !== '') echo '</optgroup>'; ?>
                    </select>
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1.5" for="quantity">Quantity</label>
                    <input id="quantity" type="number" name="quantity" min="1" max="9999" value="1" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-600 transition">
                </div>

                <!-- Live Total Preview -->
                <div class="mb-5 bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                        <span>Unit Price</span>
                        <span id="previewUnit">₦0.00</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 mb-2">
                        <span>Quantity</span>
                        <span id="previewQty">0</span>
                    </div>
                    <div class="flex justify-between font-bold text-gray-800 text-base pt-2 border-t border-gray-200">
                        <span>Total</span>
                        <span id="previewTotal" class="text-brand-700">₦0.00</span>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-brand-700 hover:bg-brand-800 text-white font-semibold py-3 rounded-xl transition text-sm tracking-wide">
                    Record Sale
                </button>
            </form>
        </div>
    </div>

    <!-- ── Recent Transactions ───────────────────── -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-semibold text-gray-700 text-base">My Recent Transactions</h2>
                <span class="text-xs text-gray-400">Last 15 records</span>
            </div>

            <?php if (empty($recent)): ?>
            <div class="py-16 text-center text-gray-400 text-sm">
                No transactions yet. Record your first sale.
            </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Product</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    <?php foreach ($recent as $tx): ?>
                        <tr class="<?= $tx['is_anomalous'] ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50' ?> transition">
                            <td class="px-4 py-3 text-gray-400 font-mono text-xs">#<?= $tx['id'] ?></td>
                            <td class="px-4 py-3 font-medium text-gray-800"><?= htmlspecialchars($tx['product_name']) ?></td>
                            <td class="px-4 py-3 text-right text-gray-600"><?= $tx['quantity'] ?></td>
                            <td class="px-4 py-3 text-right font-semibold <?= $tx['is_anomalous'] ? 'text-red-700' : 'text-gray-800' ?>">
                                ₦<?= number_format((float)$tx['total_amount'], 2) ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <?php if ($tx['is_anomalous']): ?>
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-semibold px-2 py-0.5 rounded-full"
                                      title="<?= htmlspecialchars($tx['anomaly_reason'] ?? '') ?>">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Flagged
                                </span>
                                <?php else: ?>
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    OK
                                </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-right text-gray-400 text-xs whitespace-nowrap">
                                <?= date('H:i:s', strtotime($tx['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Live total calculator -->
<script>
(function () {
    const prices   = <?= json_encode($priceMap) ?>;
    const select   = document.getElementById('product_id');
    const qtyInput = document.getElementById('quantity');
    const unitEl   = document.getElementById('previewUnit');
    const qtyEl    = document.getElementById('previewQty');
    const totalEl  = document.getElementById('previewTotal');

    function fmt(n) {
        return '₦' + n.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function update() {
        const pid   = parseInt(select.value, 10);
        const qty   = Math.max(0, parseInt(qtyInput.value, 10) || 0);
        const price = prices[pid] || 0;
        const total = price * qty;

        unitEl.textContent  = fmt(price);
        qtyEl.textContent   = qty;
        totalEl.textContent = fmt(total);

        const threshold = 50000;
        totalEl.className = total > threshold
            ? 'text-red-600 font-bold'
            : 'text-brand-700 font-bold';
    }

    select.addEventListener('change', update);
    qtyInput.addEventListener('input', update);

    // Auto-dismiss flash after 6 seconds
    ['flash-success','flash-warning'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) setTimeout(function() { el.style.transition='opacity .5s'; el.style.opacity='0'; setTimeout(function(){el.remove()},500); }, 6000);
    });
})();
</script>

<?php require __DIR__ . '/../partials/footer.php'; ?>
