<?php
// Main entry point for the ERP system
session_start();

require_once '../config/database.php';
require_once '../app/core/Controller.php';

// Very basic routing
$controller = $_GET['controller'] ?? 'Dashboard';
$action = $_GET['action'] ?? 'index';

// Authentication Check
$publicControllers = ['Auth'];
if (!isset($_SESSION['user_id']) && !in_array($controller, $publicControllers)) {
    header('Location: index.php?controller=Auth&action=login');
    exit;
}

$controllerClass = $controller . 'Controller';
$controllerFile = '../app/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $ctrl = new $controllerClass();
        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
        } else {
            die("Action not found");
        }
    } else {
        die("Controller class not found");
    }
} else {
    // Default to Dashboard if not found
    if ($controller === 'Dashboard') {
        require_once '../app/controllers/DashboardController.php';
        $ctrl = new DashboardController();
        $ctrl->index();
    } else {
        die("Controller file not found: " . $controllerClass);
    }
}

