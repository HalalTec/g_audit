<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/database.php';

// Models
require_once __DIR__ . '/app/model/UserModel.php';
require_once __DIR__ . '/app/model/ProductModel.php';
require_once __DIR__ . '/app/model/TransactionModel.php';

// Auth helper
require_once __DIR__ . '/app/auth/Auth.php';

// Services
require_once __DIR__ . '/app/services/AnomalyEngine.php';

// Controllers
require_once __DIR__ . '/app/controller/WelcomeController.php';
require_once __DIR__ . '/app/controller/AuthController.php';
require_once __DIR__ . '/app/controller/CashierController.php';
require_once __DIR__ . '/app/controller/ManagerController.php';

$routes = require __DIR__ . '/app/routes/routes.php';

// Resolve URI relative to this app's base path
$scriptDir  = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri        = trim(substr($requestUri, strlen($scriptDir)), '/');
$uri        = strtok($uri, '?') ?: '';

if (array_key_exists($uri, $routes)) {
    [$controllerClass, $method] = $routes[$uri];
    $db         = getDBConnection();
    $controller = new $controllerClass($db);
    $controller->$method();
} else {
    http_response_code(404);
    require __DIR__ . '/app/view/partials/404.php';
}
