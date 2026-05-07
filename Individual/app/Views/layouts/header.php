<?php
use App\Core\Auth;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="header">
    <div class="container nav">
        <a class="logo" href="/jobs">Job Board</a>
        <nav>
            <a href="/jobs">Вакансии</a>
            <?php if (Auth::check()): ?>
                <a href="/jobs/create">Создать вакансию</a>
                <?php if (Auth::isAdmin()): ?>
                    <a href="/admin">Админ-панель</a>
                <?php endif; ?>
                <a href="/logout">Выйти</a>
            <?php else: ?>
                <a href="/login">Войти</a>
                <a href="/register">Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container main">
