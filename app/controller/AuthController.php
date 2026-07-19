<?php
class AuthController
{
    private UserModel $userModel;

    public function __construct(private PDO $db)
    {
        $this->userModel = new UserModel($db);
    }

    public function showLogin(): void
    {
        if (Auth::check()) {
            Auth::redirectHome();
        }
        $flash = [
            'error'   => Auth::flash('error'),
            'success' => Auth::flash('success'),
        ];
        require __DIR__ . '/../view/auth/login.php';
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if (!Auth::verifyCsrf($_POST['csrf_token'] ?? '')) {
            Auth::flash('error', 'Invalid form submission. Please try again.');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            Auth::flash('error', 'Invalid username or password.');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        Auth::login($user);
        Auth::redirectHome();
    }

    public function logout(): void
    {
        Auth::logout();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
