<?php
class CashierController
{
    private ProductModel     $productModel;
    private TransactionModel $transactionModel;
    private AnomalyEngine    $anomalyEngine;

    public function __construct(private PDO $db)
    {
        $this->productModel     = new ProductModel($db);
        $this->transactionModel = new TransactionModel($db);
        $this->anomalyEngine    = new AnomalyEngine($db);
    }

    public function showForm(): void
    {
        Auth::requireRole('cashier');

        $products  = $this->productModel->all();
        $user      = Auth::user();
        $recent    = $this->transactionModel->recentByCashier((int) $user['id']);
        $flash     = [
            'success' => Auth::flash('success'),
            'warning' => Auth::flash('warning'),
            'error'   => Auth::flash('error'),
        ];

        require __DIR__ . '/../view/officer/sale.php';
    }

    public function saveSale(): void
    {
        Auth::requireRole('cashier');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/sale');
            exit;
        }

        if (!Auth::verifyCsrf($_POST['csrf_token'] ?? '')) {
            Auth::flash('error', 'Invalid form submission. Please try again.');
            header('Location: ' . BASE_URL . '/sale');
            exit;
        }

        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity  = (int) ($_POST['quantity']   ?? 0);

        if ($productId <= 0 || $quantity <= 0) {
            Auth::flash('error', 'Please select a product and enter a valid quantity (≥ 1).');
            header('Location: ' . BASE_URL . '/sale');
            exit;
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            Auth::flash('error', 'Selected product not found. Please try again.');
            header('Location: ' . BASE_URL . '/sale');
            exit;
        }

        $user        = Auth::user();
        $unitPrice   = (float) $product['price'];
        $totalAmount = $unitPrice * $quantity;

        $txId = $this->transactionModel->save([
            'cashier_id'   => (int) $user['id'],
            'product_id'   => $productId,
            'quantity'     => $quantity,
            'unit_price'   => $unitPrice,
            'total_amount' => $totalAmount,
        ]);

        // Run anomaly engine immediately after saving
        $reasons = $this->anomalyEngine->check((int) $user['id'], $totalAmount);

        if (!empty($reasons)) {
            $this->transactionModel->flagAnomaly($txId, implode('; ', $reasons));
            Auth::flash('warning', implode('; ', $reasons));
        } else {
            Auth::flash('success', sprintf(
                'Sale recorded — %s × %d = ₦%s',
                $product['name'],
                $quantity,
                number_format($totalAmount, 2)
            ));
        }

        header('Location: ' . BASE_URL . '/sale');
        exit;
    }
}
