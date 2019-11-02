<?php require 'get_user.php'; // подключение к БД

// подготавливаем переменные, убирая пробелы и защищая от скриптовой атаки (привет, Игорю):
$id = $_SESSION['user_info']->user_id; //получаем ID пользователя из сессии
$name = htmlentities(trim($_POST['name'])); // получаем имя
$email = htmlentities(trim($_POST['email']));   // получаем емейл
$image = $_FILES['image'];  // получаем массива данных картинки
$userImage = $_SESSION['user_info']->image; // получаем название картинки пользователя

// проверка и перезапись имени пользователя в БД
if ($name && ($name != $_SESSION['user_info']->name)) {

    $sql = 'UPDATE users SET name = :name WHERE user_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => $name, ':id' => $id]);

    //Изменение в сессии имени пользователя:
    $_SESSION['user_info']->name = $name;
    // запись сообщения в сессию и редирект
    $_SESSION['new_name'] = 'Имя успешно обновлено';
}

//проверка нового email:
if (!empty($email) && ($email != $_SESSION['user_info']->email)) {

    // подготовка и запрос в БД для получения емейл:
    $sql_check = 'SELECT EXISTS( SELECT email FROM users WHERE email = :email )';
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([':email' => $email]);

    // проверяем введённый емейл на соответствию критериев регулярного выражения:
    if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $email)){
        //записываем сообщение об ошибке в сессию и производим редирект:
        $_SESSION['email_err'] = 'Укажите правильный EMAIL';
    }
    // если такой емейл есть в БД, то записать сообщение об ошибке  в сессию и произвести редирект:
    elseif ($stmt_check->fetchColumn()) {
        $_SESSION['email_err'] = 'Такой EMAIL уже зарегистрирован';
    } else {
        // подготовка и запрос в БД для перезаписи емейла пользователя:
        $sql = 'UPDATE users SET email = :email WHERE user_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email, ':id' => $id]);
        //Изменение в сессии емейла пользователя:
        $_SESSION['user_info']->email = $email;
        //записываем в сессию сообщение:
        $_SESSION['new_email'] = 'Email успешно обновлен';

        // если есть куки, то перезаписываем в них новый емейл:
        if (isset($_COOKIE['user_aut'])) {
            setcookie('user_aut', '', time() - 3600, '/');
            setcookie('user_aut', $email, time() + 3600);
        }
    }
}

// если картинка существует:
 if (!empty($image['name'])) {

        // задаём каталог для загружаемых файлов:
        $uploadDir = __DIR__ . '/img/';

        //указываем доступные расширения загружаемых файлов:
        $availableExtension = ['jpg', 'svg', 'png', 'gif'];

        // получение расширения загружаемого файла:
        $extension = mb_substr($image['name'], mb_strripos($image['name'], '.') + 1);

        // придаём файлу картинки уникальное имя:
        $imageName = uniqid() . '.' . $extension;

        // полный путь к месту назначения (папка img):
        $uploadImage = $uploadDir . $imageName;

         // если расширение не поддерживается:
    if (!in_array($extension, $availableExtension)) {
        $_SESSION['image_err_ext'] = 'Используйте поддерживаемое расширение: ' . implode(', ', $availableExtension);
        redirect('profile.php');
    }
    elseif ($image['size'] > 1024*1024) {
        $_SESSION['image_err_size'] = 'Размер загружаемой картинки не должен превышать 1Мб';
        redirect('profile.php');
    }
    elseif ($_FILES['image']['error'] > 0) {
        $_SESSION['image_err_upl'] = 'Ошибка загрузки файла';
        redirect('profile.php');
    }
     else {
            // если такая картинка уже существует:
            if($userImage != '') {
                // удалить старую картинку:
                unlink($uploadDir . $userImage);
                // загрузить картинку:
                move_uploaded_file($image['tmp_name'], $uploadImage);
            } else {
                //загрузить картинку:
                move_uploaded_file($image['tmp_name'], $uploadImage);
            }
        // подготовить запрос и перезаписать название картинки в БД:
        $sql = 'UPDATE users SET image = :image WHERE user_id = :id';
        $values = [':image' => $imageName, ':id' => $id];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);
        //Изменение в сессии название картинки пользователя:
            $_SESSION['user_info']->image = $imageName;
         // запись сообщения в сессию и редирект:
        $_SESSION['image_new'] = 'Картинка загружена';
        redirect('profile.php');
        }

}
redirect('profile.php');