<?php
session_start();

// Уничтожение сессии
session_destroy();

// Перенаправление на страницу входа
header("Location: index-login.php");
exit;
?>