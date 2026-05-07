<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\JobController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$authController = new AuthController();
$jobController = new JobController();
$adminController = new AdminController();

if ($path === '/') {
    header('Location: /jobs');
    exit;
}

if ($path === '/register' && $method === 'GET') {
    $authController->showRegister();
} elseif ($path === '/register' && $method === 'POST') {
    $authController->register();
} elseif ($path === '/login' && $method === 'GET') {
    $authController->showLogin();
} elseif ($path === '/login' && $method === 'POST') {
    $authController->login();
} elseif ($path === '/logout') {
    $authController->logout();
} elseif ($path === '/jobs' && $method === 'GET') {
    $jobController->index();
} elseif ($path === '/jobs/create' && $method === 'GET') {
    $jobController->create();
} elseif ($path === '/jobs/store' && $method === 'POST') {
    $jobController->store();
} elseif ($path === '/admin' && $method === 'GET') {
    $adminController->dashboard();
} elseif ($path === '/admin/users' && $method === 'GET') {
    $adminController->users();
} elseif ($path === '/admin/create-admin' && $method === 'GET') {
    $adminController->createAdmin();
} elseif ($path === '/admin/create-admin' && $method === 'POST') {
    $adminController->storeAdmin();
} elseif ($path === '/admin/users/delete' && $method === 'POST') {
    $adminController->deleteUser();
} elseif ($path === '/admin/jobs' && $method === 'GET') {
    $adminController->jobs();
} elseif ($path === '/admin/jobs/edit' && $method === 'GET') {
    $adminController->editJob();
} elseif ($path === '/admin/jobs/update' && $method === 'POST') {
    $adminController->updateJob();
} elseif ($path === '/admin/jobs/delete' && $method === 'POST') {
    $adminController->deleteJob();
} else {
    http_response_code(404);
    echo '404 Page Not Found';
}
