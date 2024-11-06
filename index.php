<?php
require 'vendor/autoload.php';
    session_start();
    if (isset($_SESSION['user_id'])) {
       // Пользователь уже авторизован, перенаправляем его на главную страницу
        header("Location: dashboard.php");
        exit();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Авторизация</title>
        <style>
            body {
                background-color: <?= isset($_COOKIE['background_color']) ? $_COOKIE['background_color'] : '#ffffff' ?>;
                color: <?= isset($_COOKIE['font_color']) ? $_COOKIE['font_color'] : '#000000' ?>;
            }
        </style>
    </head>
    <body>

    <h1>Регистрация</h1>
    <form method="POST" action="auth.php">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="color" name="background_color" placeholder="Фоновый цвет">
        <input type="color" name="font_color" placeholder="Цвет шрифта">
        <button type="submit" name="register">Зарегистрироваться</button>
    </form>

    <h1>Авторизация</h1>
    <form method="POST" action="auth.php">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="login">Войти</button>
    </form>

    </body>
    </html>