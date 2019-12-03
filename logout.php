<?php
require_once 'db.php';

$_SESSION = [];

// Если есть кука авторизации, то уничтожаем её:
if (isset($_COOKIE['user_aut'])) {
    setcookie('user_aut', '', time() - 3600, '/');
}
// закрываем сессию:
session_destroy();

// редирект на страницу авторизации:
header('location:/login.php');
