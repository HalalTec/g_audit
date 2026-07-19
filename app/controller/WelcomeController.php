<?php
declare(strict_types=1);

class WelcomeController
{
    public function __construct(private \PDO $db) {}

    public function index(): void
    {
        if (Auth::check()) {
            $role = Auth::user()['role'];
            header('Location: ' . BASE_URL . ($role === 'manager' ? '/dashboard' : '/sale'));
            exit;
        }

        require __DIR__ . '/../view/welcome.php';
    }
}
