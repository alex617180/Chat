<?php require_once 'db.php'; // подключение к БД

$user_id = $_SESSION['user_info']->user_id; //получаем ID пользователя из сессии
$name = $_SESSION['user_info']->name; // получаем имя пользователя из сессии
$date = date("Y.m.d"); // получаем текущую дату в формате (Год.месяц.день)
$text = htmlentities(trim($_POST['text'])); // получаем текст комментария, избавляемся от пробелов с его концов, предотвращаем возможность скриптовой атаки

if (!empty($text)) {    // проверяем наличие текста комментария, подготавливаем запрос и записываем текст комментария в БД:

    $sql = 'INSERT INTO comments (date, text, user_id) VALUES (:date, :text, :user_id)';
    $values = [':date' => $date, ':text' => $text, ':user_id' => $user_id];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);

    // запись сообщения в сессию и редирект на главную:
    $_SESSION['result'] = 'Комментарий успешно добавлен';
    header('location:/');
} else {

        // запись сообщения в сессию и редирект на главную:
        $_SESSION['text'] = 'Сначала нужно написать комментарий';
        header('location: /');

}
