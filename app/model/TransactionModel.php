<?php
class TransactionModel
{
    public function __construct(private PDO $db) {}

    public function save(array $data): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO transactions (cashier_id, product_id, quantity, unit_price, total_amount)
            VALUES (?, ?, ?, ?, ?)
            RETURNING id
        ');
        $stmt->execute([
            $data['cashier_id'],
            $data['product_id'],
            $data['quantity'],
            $data['unit_price'],
            $data['total_amount'],
        ]);
        return (int) $stmt->fetchColumn();
    }

    public function flagAnomaly(int $id, string $reason): void
    {
        $stmt = $this->db->prepare('
            UPDATE transactions SET is_anomalous = TRUE, anomaly_reason = ? WHERE id = ?
        ');
        $stmt->execute([$reason, $id]);
    }

    public function markReviewed(int $id): void
    {
        $stmt = $this->db->prepare('
            UPDATE transactions SET reviewed = TRUE, reviewed_at = CURRENT_TIMESTAMP WHERE id = ?
        ');
        $stmt->execute([$id]);
    }

    /** Recent transactions for the logged-in cashier */
    public function recentByCashier(int $cashierId, int $limit = 15): array
    {
        $stmt = $this->db->prepare('
            SELECT t.id, t.quantity, t.unit_price, t.total_amount,
                   t.is_anomalous, t.anomaly_reason, t.created_at,
                   p.name AS product_name
            FROM   transactions t
            JOIN   products p ON p.id = t.product_id
            WHERE  t.cashier_id = ?
            ORDER  BY t.created_at DESC
            LIMIT  ?
        ');
        $stmt->execute([$cashierId, $limit]);
        return $stmt->fetchAll();
    }

    /** Count transactions by cashier in the last N minutes (for frequency rule) */
    public function countRecentByCashier(int $cashierId, int $minutes): int
    {
        $stmt = $this->db->prepare('
            SELECT COUNT(*) FROM transactions
            WHERE  cashier_id = ?
            AND    created_at >= CURRENT_TIMESTAMP - make_interval(mins => ?)
        ');
        $stmt->execute([$cashierId, $minutes]);
        return (int) $stmt->fetchColumn();
    }

    /** All transactions for manager view, newest first */
    public function allForManager(int $limit = 200): array
    {
        $stmt = $this->db->prepare('
            SELECT t.id, t.quantity, t.unit_price, t.total_amount,
                   t.is_anomalous, t.anomaly_reason, t.reviewed, t.reviewed_at, t.created_at,
                   p.name  AS product_name,
                   u.username  AS cashier_username,
                   u.full_name AS cashier_name
            FROM   transactions t
            JOIN   products p ON p.id = t.product_id
            JOIN   users    u ON u.id = t.cashier_id
            ORDER  BY t.created_at DESC
            LIMIT  ?
        ');
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Observation query — Average Transaction Value and daily stats.
     * Returns a single associative row for today.
     */
    public function dailyStats(): array
    {
        $row = $this->db->query('
            SELECT
                COUNT(*)                                                           AS transaction_count,
                COALESCE(ROUND(AVG(total_amount), 2), 0)                          AS avg_transaction_value,
                COALESCE(ROUND(SUM(total_amount), 2), 0)                          AS total_revenue,
                COUNT(*) FILTER (WHERE is_anomalous)                              AS flagged_count,
                COUNT(*) FILTER (WHERE is_anomalous AND NOT reviewed)             AS pending_review_count
            FROM transactions
            WHERE created_at >= CURRENT_DATE
              AND created_at < CURRENT_DATE + 1
        ')->fetch();

        return $row ?: [
            'transaction_count'    => 0,
            'avg_transaction_value'=> 0,
            'total_revenue'        => 0,
            'flagged_count'        => 0,
            'pending_review_count' => 0,
        ];
    }
}
