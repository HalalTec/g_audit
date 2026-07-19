<?php
/**
 * Route map: URI segment => [ControllerClass, method]
 * The front controller (index.php) resolves these.
 */
return [
    // Welcome
    ''                    => ['WelcomeController', 'index'],

    // Auth
    'login'               => ['AuthController',    'showLogin'],
    'auth'                => ['AuthController',    'login'],
    'logout'              => ['AuthController',    'logout'],

    // Cashier (officer)
    'sale'                => ['CashierController', 'showForm'],
    'save-sale'           => ['CashierController', 'saveSale'],

    // Manager
    'dashboard'           => ['ManagerController', 'index'],
    'review-transaction'  => ['ManagerController', 'reviewTransaction'],
];
