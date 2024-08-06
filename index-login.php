<?php
// Подключение к базе данных
include 'include/database.php';

// Проверка подключения
if (!$db) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Обработка формы входа
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Подготовка запроса
    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Пользователь найден
        $row = $stmt->fetch();

        // Авторизация успешна
        session_start();
        $_SESSION["user_id"] = $row["user_id"];

        // Перенаправление на страницу с закладками
        header("Location: index.php");
        exit;
    } else {
        // Неверный пароль или пользователь не найден
        $error_message = "Неверный пароль или пользователь не найден";
    }
}

// Отображение формы входа
?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
</head>
<link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="/css/font-awesome.css" />
  <link rel="stylesheet" href="/css/style.css" />
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <style>
        body {
            background-color: #06090F;
            color: #fff;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #12171F;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 325px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: -7px
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #555;
            border-radius: 3px;
            background-color: #444;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0069d9;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Вход</h1>
        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="username">Имя пользователя:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Войти">
        </form>
    </div>
</body>
</html>