<?php
class ProductModel
{
    public function __construct(private PDO $db) {}

    public function all(): array
    {
        return $this->db
            ->query('SELECT id, name, category, price FROM products ORDER BY category, name')
            ->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, name, category, price FROM products WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
