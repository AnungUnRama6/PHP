<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\User;

final class AuthController
{
    public function showRegister(): void
    {
        View::render('auth/register', ['errors' => []]);
    }

    public function register(): void
    {
        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '') {
            $errors[] = 'Name is required.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required.';
        }

        if (strlen($password) < 6) {
            $errors[] = 'Password must contain at least 6 characters.';
        }

        $userModel = new User();

        if ($userModel->findByEmail($email)) {
            $errors[] = 'User with this email already exists.';
        }

        if ($errors) {
            View::render('auth/register', ['errors' => $errors]);
            return;
        }

        $userModel->create($name, $email, $password);
        header('Location: /login');
    }

    public function showLogin(): void
    {
        View::render('auth/login', ['errors' => []]);
    }

    public function login(): void
    {
        $errors = [];
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Incorrect email or password.';
            View::render('auth/login', ['errors' => $errors]);
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        header('Location: /jobs');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /jobs');
    }
}
