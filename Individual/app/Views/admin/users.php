<?php /** @var array $users */ ?>

<h1>Пользователи</h1>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars((string)$user['id']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
                <form method="POST" action="/admin/users/delete" onsubmit="return confirm('Удалить пользователя?')">
                    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$user['id']) ?>">
                    <button type="submit" class="danger">Удалить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
