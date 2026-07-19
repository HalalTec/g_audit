<?php
class AnomalyEngine
{
    private float $maxAmount;
    private int   $maxFreq;
    private int   $freqWindow;

    public function __construct(private PDO $db)
    {
        $cfg = require __DIR__ . '/../config/AppConfig.php';
        $this->maxAmount  = (float) $cfg['max_amount_threshold'];
        $this->maxFreq    = (int)   $cfg['max_freq_threshold'];
        $this->freqWindow = (int)   $cfg['freq_window_minutes'];
    }

    /**
     * Run all anomaly rules against a just-saved transaction.
     * Returns an array of human-readable reason strings (empty = clean).
     */
    public function check(int $cashierId, float $totalAmount): array
    {
        $reasons = [];

        // Rule 1 — High Amount
        if ($totalAmount > $this->maxAmount) {
            $reasons[] = sprintf(
                'High amount: ₦%s exceeds threshold of ₦%s',
                number_format($totalAmount, 2),
                number_format($this->maxAmount, 2)
            );
        }

        // Rule 2 — Frequency (count includes the transaction just saved)
        $stmt = $this->db->prepare('
            SELECT COUNT(*) FROM transactions
            WHERE  cashier_id = ?
            AND    created_at >= CURRENT_TIMESTAMP - make_interval(mins => ?)
        ');
        $stmt->execute([$cashierId, $this->freqWindow]);
        $count = (int) $stmt->fetchColumn();

        if ($count > $this->maxFreq) {
            $reasons[] = sprintf(
                'High frequency: %d transactions in the last %d min (threshold: %d)',
                $count,
                $this->freqWindow,
                $this->maxFreq
            );
        }

        return $reasons;
    }
}
