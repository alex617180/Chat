<?php require_once 'db.php'; // подключение к БД


if (isset($_POST['show'])) {    // если нажата кнопка "показано", то перезаписываем параметр skip на "0" в БД:
    $sql = 'UPDATE comments SET skip = 0 WHERE id = :id';
    // подготавливаем запрос:
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['show']]);

    header('location:/admin.php');  //редирект в админку


}
if (isset($_POST['skip'])) {    // если нажата кнопка "скрыто", то перезаписываем параметр skip на "1" в БД:
    $sql = 'UPDATE comments SET skip = 1 WHERE id = :id';
    // подготавливаем запрос:
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['skip']]);

    header('location:/admin.php');  //редирект в админку
}
if (isset($_POST['del'])) {     // если нажата кнопка "удалить", то удаляем данные комментария из БД:
    $sql = 'DELETE FROM comments WHERE id = :id';
    // подготавливаем запрос:
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['del']]);

    header('location:/admin.php');  //редирект в админку
}