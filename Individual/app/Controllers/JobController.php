<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\Job;

final class JobController
{
    public function index(): void
    {
        $jobModel = new Job();
        $jobs = $jobModel->search($_GET);

        View::render('jobs/index', ['jobs' => $jobs]);
    }

    public function create(): void
    {
        Auth::requireAuth();
        View::render('jobs/create', ['errors' => [], 'job' => null]);
    }

    public function store(): void
    {
        Auth::requireAuth();

        $data = $this->validateJobData();

        if ($data['errors']) {
            View::render('jobs/create', ['errors' => $data['errors'], 'job' => $_POST]);
            return;
        }

        $jobModel = new Job();
        $jobModel->create([
            ...$data['values'],
            'user_id' => $_SESSION['user']['id'],
        ]);

        header('Location: /jobs');
    }

    private function validateJobData(): array
    {
        $errors = [];

        $title = trim($_POST['title'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $salary = $_POST['salary'] ?? null;
        $employmentType = $_POST['employment_type'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $isRemote = isset($_POST['is_remote']);

        $allowedTypes = ['full-time', 'part-time', 'remote', 'internship'];

        if ($title === '') {
            $errors[] = 'Job title is required.';
        }

        if ($company === '') {
            $errors[] = 'Company is required.';
        }

        if ($city === '') {
            $errors[] = 'City is required.';
        }

        if (!is_numeric($salary) || (float)$salary < 0) {
            $errors[] = 'Salary must be a positive number.';
        }

        if (!in_array($employmentType, $allowedTypes, true)) {
            $errors[] = 'Invalid employment type.';
        }

        if (strlen($description) < 10) {
            $errors[] = 'Description must contain at least 10 characters.';
        }

        return [
            'errors' => $errors,
            'values' => [
                'title' => $title,
                'company' => $company,
                'city' => $city,
                'salary' => $salary,
                'employment_type' => $employmentType,
                'description' => $description,
                'is_remote' => $isRemote,
            ],
        ];
    }
}
