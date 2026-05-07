<?php /** @var array $jobs */ ?>

<h1>Список вакансий</h1>

<form method="GET" action="/jobs" class="search-form">
    <input type="text" name="keyword" placeholder="Название или компания" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    <input type="text" name="city" placeholder="Город" value="<?= htmlspecialchars($_GET['city'] ?? '') ?>">
    <select name="employment_type">
        <option value="">Все типы</option>
        <option value="full-time">Full-time</option>
        <option value="part-time">Part-time</option>
        <option value="remote">Remote</option>
        <option value="internship">Internship</option>
    </select>
    <select name="is_remote">
        <option value="">Remote / Office</option>
        <option value="1">Remote</option>
        <option value="0">Office</option>
    </select>
    <button type="submit">Поиск</button>
</form>

<div class="cards">
    <?php foreach ($jobs as $job): ?>
        <article class="card">
            <h2><?= htmlspecialchars($job['title']) ?></h2>
            <p><strong>Компания:</strong> <?= htmlspecialchars($job['company']) ?></p>
            <p><strong>Город:</strong> <?= htmlspecialchars($job['city']) ?></p>
            <p><strong>Зарплата:</strong> <?= htmlspecialchars((string)$job['salary']) ?></p>
            <p><strong>Тип:</strong> <?= htmlspecialchars($job['employment_type']) ?></p>
            <p><strong>Формат:</strong> <?= $job['is_remote'] ? 'Remote' : 'Office' ?></p>
            <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
        </article>
    <?php endforeach; ?>
</div>
