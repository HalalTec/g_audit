<?php
class ManagerController
{
    private TransactionModel $transactionModel;

    public function __construct(private PDO $db)
    {
        $this->transactionModel = new TransactionModel($db);
    }

    public function index(): void
    {
        Auth::requireRole('manager');

        $transactions = $this->transactionModel->allForManager();
        $stats        = $this->transactionModel->dailyStats();
        $user         = Auth::user();
        $flash        = [
            'success' => Auth::flash('success'),
            'error'   => Auth::flash('error'),
        ];

        require __DIR__ . '/../view/Manager/dashboard.php';
    }

    public function reviewTransaction(): void
    {
        Auth::requireRole('manager');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        if (!Auth::verifyCsrf($_POST['csrf_token'] ?? '')) {
            Auth::flash('error', 'Invalid form submission.');
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $txId = (int) ($_POST['transaction_id'] ?? 0);
        if ($txId > 0) {
            $this->transactionModel->markReviewed($txId);
            Auth::flash('success', "Transaction #$txId marked as reviewed.");
        }

        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}
