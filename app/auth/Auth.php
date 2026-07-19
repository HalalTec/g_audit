<?php
class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public static function requireRole(string $role): void
    {
        self::requireAuth();
        if ($_SESSION['role'] !== $role) {
            // Redirect to the correct home for this user's role
            self::redirectHome();
        }
    }

    public static function redirectHome(): never
    {
        $role = $_SESSION['role'] ?? '';
        header('Location: ' . BASE_URL . ($role === 'manager' ? '/dashboard' : '/sale'));
        exit;
    }

    public static function user(): array
    {
        return [
            'id'        => $_SESSION['user_id']   ?? null,
            'username'  => $_SESSION['username']  ?? null,
            'full_name' => $_SESSION['full_name'] ?? null,
            'role'      => $_SESSION['role']      ?? null,
        ];
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role']      = $user['role'];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function flash(string $key, ?string $message = null): ?string
    {
        if ($message !== null) {
            $_SESSION['flash'][$key] = $message;
            return null;
        }
        $msg = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $msg;
    }

    public static function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrf(string $token): bool
    {
        return !empty($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}
