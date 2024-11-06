<?php
    session_start();
    $pdo = new mysqli("MySQL-5.7", "root", "", "php_AUTH");

    // Проверяем соединение
    if ($pdo->connect_error) {
        die("Ошибка подключения: " . $pdo->connect_error);
    }
    echo "Подключение успешно!". "<br>";

   // Регистрация
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $bg_color = $_POST['background_color'];
        $font_color = $_POST['font_color'];

        $stmt = $pdo->prepare("INSERT INTO users (username, password, background_color, font_color) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $bg_color, $font_color]);
    }

   // Авторизация
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            setcookie('background_color', $user['background_color'], time() + (86400 * 30), "/");
            setcookie('font_color', $user['font_color'], time() + (86400 * 30), "/");
            header("Location: index.php");
            exit();
        }
    }