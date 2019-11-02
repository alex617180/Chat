<?php require_once 'db.php';    // подключение к БД

// подготавливаем переменные, убирая пробелы и защищая от скриптовой атаки (привет, Игорю):
$name = htmlentities(trim($_POST['name'])); // получаем имя
$email = htmlentities(trim($_POST['email'])); // получаем емейл
$password = htmlentities(trim($_POST['password'])); // получаем пароль
$pas_conf= htmlentities(trim($_POST['pas_conf'])); // //получаем повтор нового пароля
$image = '';

//хэшируем пароль перед отправкой в БД:
$pswd = password_hash($password, PASSWORD_DEFAULT);

//проверка при регистрации
if (!empty($name) && !empty($email) && !empty($pswd) && !empty($pas_conf)) {

    // подготовка и запрос в БД для получения емейл:
    $sql_check = 'SELECT EXISTS( SELECT email FROM users WHERE email = :email )';
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([':email' => $email]);

    // проверяем введённый емейл на соответствию критериев регулярного выражения:
    if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)){
        //записываем сообщение об ошибке в сессию и производим редирект:
        $_SESSION['email_err'] = 'Укажите правильный EMAIL';
        header('location:/register.php');
        exit;
    }
    // если такой емейл есть в БД, то записать сообщение об ошибке  в сессию и произвести редирект:
    elseif ($stmt_check->fetchColumn()) {
        $_SESSION['email_err'] = 'Такой EMAIL уже зарегистрирован';
        header('location:/register.php');
        exit;

    }   //если пароль менее 6 символов, то записать сообщение об ошибке  в сессию и произвести редирект:
     elseif (strlen($_POST['password']) < 6) {
        $_SESSION['password_err1'] = 'Пароль должен быть не менее 6 символов';
        header('location:/register.php');
        exit;

    }   //если пароли не совпадают, то записать сообщение об ошибке  в сессию и произвести редирект:
    elseif ($password !== $pas_conf) {
        $_SESSION['password_err2'] = 'Пароли должны совпадать';
        header('location:/register.php');
        exit;

    } else {
        // подготовка запроса и запись в БД данных нового пользователя:
        $sql = 'INSERT INTO users (name, email, password, image) VALUES (?,?,?,?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $pswd, $image]);

        // запись сообщения в сессию и редирект:
        $_SESSION['new_user'] = 'Пользователь успешно зарегистрирован';
        header('location:/login.php');
        exit;
    }
}
else {
    // запись сообщения об ошибке в сессию и редирект:
    $_SESSION['login_err1'] = 'заполните все поля';
    header('location:/register.php');
    exit;
}