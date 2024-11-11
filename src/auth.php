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
        if ($stmt === false) {
            die("Ошибка подготовки запроса: " . $pdo->error);
        }
        $stmt->bind_param("ssss", $username, $password, $bg_color, $font_color);
        // Выполнение запроса
        if ($stmt->execute()) {
            echo "Регистрация прошла успешно!";
        } else {
            echo "Ошибка выполнения запроса: " . $stmt->error;
        }
    }

   // Авторизация
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        if ($stmt === false) {
            die("Ошибка подготовки запроса: " . $pdo->error);
        }
        $stmt->bind_param("s", $username);
        // Выполнение запроса
        $stmt->execute();
        // Получение результата
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            setcookie('background_color', $user['background_color'], time() + (86400 * 30), "/");
            setcookie('font_color', $user['font_color'], time() + (86400 * 30), "/");
            header("Location: index.php");
            exit();
        } else {
            echo "Неверное имя пользователя или пароль.";
        }
    }
