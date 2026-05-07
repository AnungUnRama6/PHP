<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Job
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $sql = 'SELECT jobs.*, users.name AS author_name FROM jobs JOIN users ON jobs.user_id = users.id ORDER BY jobs.id DESC';
        return $this->db->query($sql)->fetchAll();
    }

     public function search(array $filters): array
{
    $sql = "SELECT * FROM jobs WHERE 1=1";
    $params = [];

    if (!empty($filters['keyword'])) {
        $sql .= " AND (title ILIKE :keyword OR company ILIKE :keyword OR description ILIKE :keyword)";
        $params['keyword'] = '%' . $filters['keyword'] . '%';
    }

    if (!empty($filters['city'])) {
        $sql .= " AND city ILIKE :city";
        $params['city'] = '%' . $filters['city'] . '%';
    }

    if (!empty($filters['employment_type'])) {
        $sql .= " AND employment_type = :employment_type";
        $params['employment_type'] = $filters['employment_type'];
    }

  if (isset($filters['is_remote']) && in_array((string)$filters['is_remote'], ['0', '1'], true)) {
    $sql .= " AND is_remote = CASE WHEN :is_remote = '1' THEN TRUE ELSE FALSE END";
    $params['is_remote'] = (string)$filters['is_remote'];
    }

    $sql .= " ORDER BY created_at DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM jobs WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $job = $stmt->fetch();

        return $job ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO jobs (user_id, title, company, city, salary, employment_type, description, is_remote)
                VALUES (:user_id, :title, :company, :city, :salary, :employment_type, :description,
                        CASE WHEN :is_remote = '1' THEN TRUE ELSE FALSE END)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'company' => $data['company'],
            'city' => $data['city'],
            'salary' => $data['salary'] !== '' ? $data['salary'] : null,
            'employment_type' => $data['employment_type'],
            'description' => $data['description'],
            'is_remote' => (string)($data['is_remote'] ?? '0'),
        ]);
    }


    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE jobs 
                SET title = :title,
                    company = :company,
                    city = :city,
                    salary = :salary,
                    employment_type = :employment_type,
                    description = :description,
                    is_remote = CASE WHEN :is_remote = '1' THEN TRUE ELSE FALSE END
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'company' => $data['company'],
            'city' => $data['city'],
            'salary' => $data['salary'] !== '' ? $data['salary'] : null,
            'employment_type' => $data['employment_type'],
            'description' => $data['description'],
            'is_remote' => (string)($data['is_remote'] ?? '0'),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM jobs WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
