<?php require_once 'db.php'; // подключаемся к БД и радуемся:

// подготавливаем переменные, убирая пробелы и защищая от скриптовой атаки (привет, Игорю):
$email = htmlentities(trim($_POST['email']));
$password = htmlentities(trim($_POST['password']));

if (!empty($email) && !empty($password)) { // убеждаемся, что емейл и пароль не пусты:

    // подготавливаем запрос к БД и получаем пароль и емейл:
    $sql_get = 'SELECT email, password FROM users WHERE email = :email';
    $stmt_get = $pdo->prepare($sql_get);
    $stmt_get->execute([':email' => $email]);
    $email_log = $stmt_get->fetch(PDO::FETCH_OBJ);

    if ($email_log) { // если такой емейл существует в БД, то проверяем пароль от него:

        if (strlen($_POST['password']) < 6) {

            $_SESSION['password_err1'] = 'Пароль должен быть не менее 6 символов';
            header('location:/login.php');
            exit;

        } elseif (password_verify($password, $email_log->password)) { // если емейл и пароль совпадает, то подключаем скрипт для записи данных авторизованного пользователя в сессию:
            require 'get_user.php';

            // если отмечена галочка (запомнить меня), то в принципе можно создать куку, записав в неё емейл авторизованного пользователя:
            if (isset($_POST['remember'])) {
                setcookie('user_aut', $email_log->email, time() + 3600);
            }
            // редирект на главную:
            header('location:/');
            exit;
        } else {
            // запись ошибки в сессию и редирект:
            $_SESSION['login_pas_err'] = 'Неверно введен пароль';
            header('location:/login.php');
            exit;
        }
    } else {
        // запись ошибки в сессию и редирект:
        $_SESSION['login_err'] = 'Неверно введен логин (email)';
        header('location:/login.php');
        exit;
    }
} else {
    // запись ошибки в сессию и редирект:
    $_SESSION['login_err1'] = 'заполните все поля';
    header('location:/login.php');
    exit;
}
