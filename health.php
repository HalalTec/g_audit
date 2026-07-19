<?php
declare(strict_types=1);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/config/database.php';
    getDBConnection()->query('SELECT 1');
    http_response_code(200);
    echo json_encode(['status' => 'ok']);
} catch (Throwable $e) {
    error_log('Health check failed: ' . $e->getMessage());
    http_response_code(503);
    echo json_encode(['status' => 'unavailable']);
}
