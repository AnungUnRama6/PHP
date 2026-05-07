<h1>Создать вакансию</h1>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/jobs/store" class="form">
    <label>Название вакансии</label>
    <input type="text" name="title" required>

    <label>Компания</label>
    <input type="text" name="company" required>

    <label>Город</label>
    <input type="text" name="city" required>

    <label>Зарплата</label>
    <input type="number" name="salary" min="0" required>

    <label>Тип занятости</label>
    <select name="employment_type" required>
        <option value="full-time">Full-time</option>
        <option value="part-time">Part-time</option>
        <option value="remote">Remote</option>
        <option value="internship">Internship</option>
    </select>

    <label>Описание</label>
    <textarea name="description" minlength="10" required></textarea>

    <label class="checkbox">
        <input type="checkbox" name="is_remote"> Можно работать удалённо
    </label>

    <button type="submit">Сохранить</button>
</form>
