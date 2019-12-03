<?php require_once 'get_user.php';  // подключение к БД

// подготавливаем переменные, убирая пробелы и защищая от скриптовой атаки (привет, Игорю):
$id = $_SESSION['user_info']->user_id; //получаем ID пользователя из сессии
$pas_cur = htmlentities(trim($_POST['pas_cur'])); //получаем старый пароль
$password = htmlentities(trim($_POST['password'])); //получаем новый пароль
$pas_conf = htmlentities(trim($_POST['pas_conf'])); //получаем повтор нового пароля
//хэшируем пароль перед отправкой в БД:
$pswd = password_hash($password, PASSWORD_DEFAULT);

//проверка при регистрации
if (!empty($pas_cur) && !empty($pswd) && !empty($pas_conf)) {

    // проверка на соответствие введённого пароля и пароля пользователя:
    if (password_verify($pas_cur, $_SESSION['user_info']->password)) {

        //если пароль менее 6 символов, то записать сообщение об ошибке  в сессию и произвести редирект:
        if (strlen($_POST['password']) < 6) {
            $_SESSION['password_err1'] = 'Новый пароль должен быть не менее 6 символов';
           redirect('profile.php');
        }
        //если пароли не совпадают, то записать сообщение об ошибке  в сессию и произвести редирект:
        elseif ($password !== $pas_conf) {
            $_SESSION['password_err2'] = 'Пароли должны совпадать';
            redirect('profile.php');
        } else {
            // подготовка и запрос в БД для перезаписи пароля пользователя:
            $sql = 'UPDATE users SET password = :password WHERE user_id = :id';
            $values = [':password' => $pswd, ':id' => $id];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);
            //Изменение в сессии пароля пользователя:
            $_SESSION['user_info']->password = $pswd;
            // запись сообщения в сессию и редирект:
            $_SESSION['password_upd'] = 'Пароль успешно обновлен';
            redirect('profile.php');
        }
    } else {
        // запись сообщения об ошибке в сессию и редирект:
        $_SESSION['password_err'] = 'Неверно указан старый пароль';
        redirect('profile.php');
    }
} else {
    // запись сообщения об ошибке в сессию и редирект:
    $_SESSION['login_err1'] = 'заполните все поля';
    redirect('profile.php');
}
