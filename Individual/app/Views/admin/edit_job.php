<?php /** @var array $job */ ?>

<h1>Редактировать вакансию</h1>

<?php if (!$job): ?>
    <p>Вакансия не найдена.</p>
<?php else: ?>
<form method="POST" action="/admin/jobs/update" class="form">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$job['id']) ?>">

    <label>Название вакансии</label>
    <input type="text" name="title" value="<?= htmlspecialchars($job['title']) ?>" required>

    <label>Компания</label>
    <input type="text" name="company" value="<?= htmlspecialchars($job['company']) ?>" required>

    <label>Город</label>
    <input type="text" name="city" value="<?= htmlspecialchars($job['city']) ?>" required>

    <label>Зарплата</label>
    <input type="number" name="salary" value="<?= htmlspecialchars((string)$job['salary']) ?>" min="0" required>

    <label>Тип занятости</label>
    <select name="employment_type" required>
        <?php foreach (['full-time', 'part-time', 'remote', 'internship'] as $type): ?>
            <option value="<?= $type ?>" <?= $job['employment_type'] === $type ? 'selected' : '' ?>><?= $type ?></option>
        <?php endforeach; ?>
    </select>

    <label>Описание</label>
    <textarea name="description" minlength="10" required><?= htmlspecialchars($job['description']) ?></textarea>

    <label class="checkbox">
        <input type="checkbox" name="is_remote" <?= $job['is_remote'] ? 'checked' : '' ?>> Можно работать удалённо
    </label>

    <button type="submit">Обновить</button>
</form>
<?php endif; ?>
