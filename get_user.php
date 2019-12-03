<?php require_once 'db.php'; // подключение к БД

// проверка на наличие данных емейла авторизованного пользователя:
if (empty($email)) {
	// если есть куки - извлекаем из них данные емейла:
    if (isset($_COOKIE['user_aut'])) {
        $email = $_COOKIE['user_aut'];
    }
    // если есть сессия - извлекаем из неё данные емейла:
    elseif (isset($_SESSION['user_info'])) {
        $email = $_SESSION['user_info']->email;
    }
    else {
        echo 'Ошибка загрузки данных';
    }
}
// Подготавливаем запрос и получаем из БД всю информацию об авторизованном пользователе в виде объекта и присваиваем её сессии:
$sql_get = 'SELECT * FROM users WHERE email = :email';
$stmt_get = $pdo->prepare($sql_get);
$stmt_get->execute([':email' => $email]);
$_SESSION['user_info'] =  $stmt_get->fetch(PDO::FETCH_OBJ);
