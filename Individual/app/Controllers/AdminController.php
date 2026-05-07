<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\Job;
use App\Models\User;

final class AdminController
{
    public function dashboard(): void
    {
        Auth::requireAdmin();
        View::render('admin/dashboard');
    }

    public function users(): void
    {
        Auth::requireAdmin();
        $users = (new User())->all();
        View::render('admin/users', ['users' => $users]);
    }

    public function createAdmin(): void
    {
        Auth::requireAdmin();
        View::render('admin/create_admin', ['errors' => []]);
    }

    public function storeAdmin(): void
    {
        Auth::requireAdmin();

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
            View::render('admin/create_admin', ['errors' => $errors]);
            return;
        }

        $userModel->create($name, $email, $password, 'admin');
        header('Location: /admin/users');
    }

    public function deleteUser(): void
    {
        Auth::requireAdmin();
        (new User())->delete((int)$_POST['id']);
        header('Location: /admin/users');
    }

    public function jobs(): void
    {
        Auth::requireAdmin();
        $jobs = (new Job())->all();
        View::render('admin/jobs', ['jobs' => $jobs]);
    }

    public function editJob(): void
    {
        Auth::requireAdmin();
        $job = (new Job())->find((int)($_GET['id'] ?? 0));
        View::render('admin/edit_job', ['job' => $job, 'errors' => []]);
    }

    public function updateJob(): void
    {
        Auth::requireAdmin();

        $id = (int)$_POST['id'];
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'salary' => $_POST['salary'] ?? 0,
            'employment_type' => $_POST['employment_type'] ?? 'full-time',
            'description' => trim($_POST['description'] ?? ''),
            'is_remote' => isset($_POST['is_remote']),
        ];

        (new Job())->update($id, $data);
        header('Location: /admin/jobs');
    }

    public function deleteJob(): void
    {
        Auth::requireAdmin();
        (new Job())->delete((int)$_POST['id']);
        header('Location: /admin/jobs');
    }
}
