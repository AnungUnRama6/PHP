<?php /** @var array $jobs */ ?>

<h1>Управление вакансиями</h1>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Компания</th>
        <th>Город</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($jobs as $job): ?>
        <tr>
            <td><?= htmlspecialchars((string)$job['id']) ?></td>
            <td><?= htmlspecialchars($job['title']) ?></td>
            <td><?= htmlspecialchars($job['company']) ?></td>
            <td><?= htmlspecialchars($job['city']) ?></td>
            <td class="actions">
                <a href="/admin/jobs/edit?id=<?= htmlspecialchars((string)$job['id']) ?>">Редактировать</a>
                <form method="POST" action="/admin/jobs/delete" onsubmit="return confirm('Удалить вакансию?')">
                    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$job['id']) ?>">
                    <button type="submit" class="danger">Удалить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
