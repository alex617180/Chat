<?php session_start(); // старт сессии

$driver = 'mysql'; // тип базы данных, с которой мы будем работать
$host = 'localhost'; // альтернатива '127.0.0.1' - адрес хоста, в нашем случае локального
$db_name = 'marlin'; // имя базы данных
$db_user = 'root'; // имя пользователя для базы данных
$db_password = ''; // пароль пользователя
$charset = 'utf8'; // кодировка по умолчанию

// массив с дополнительными настройками подключения. В данном примере мы установили отображение ошибок, связанных с базой данных, в виде исключений
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Далее из нескольких переменных формируем строку DSN соединения и сохраняем в отдельную переменную (можно этого и не делать, но так удобнее и читабельнее):
$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";

// И в конечном итоге создаём объект PDO, передавая ему следующие переменные:
$pdo = new PDO($dsn, $db_user, $db_password, $opt);

// Емейл админа, для получения доступа к админке - создаётся $_SESSION['admin']:
$admin = 'alexeysannikov@mail.com';
if ($_SESSION['user_info']->email == $admin) {
    $_SESSION['admin'] = 'ADMIN';
}

function redirect($url)
	{
		header('location: /' . $url);
		exit;
	}
function getImageUser($image) {
	if ($image == '')	{
		$image = 'img/no-user.jpg';
	} else {
		$image = 'img/' . $image;
	}
	echo $image;
}
function getComments()
	{
		$sql = 'SELECT * FROM comments LEFT JOIN users ON comments.user_id = users.user_id ORDER BY comments.id DESC';
		global $pdo;
		$stmt = $pdo->query($sql);
		$comments = $stmt->fetchAll();
		return $comments;
	}
function getNameUser()
	{
		if (isset($_SESSION['user_info'])) {
			$name_aut = $_SESSION['user_info']->name;
			return $name_aut;
		}
		elseif (isset($_COOKIE['user_aut'])) {
            require_once 'get_user.php';
            $name_aut = $_SESSION['user_info']->name;
            return $name_aut;
        }
        else {
        	return false;
        }
	}
function issetMessage()
	{
		$bool = false;
		if (isset($_SESSION['result']) || isset($_SESSION['new_name']) || isset($_SESSION['new_email']) || isset($_SESSION['image_err_ext']) || isset($_SESSION['image_err_size']) || isset($_SESSION['image_err_upl']) || isset($_SESSION['image_new']) || isset($_SESSION['email_err']) || isset($_SESSION['password_upd']) || isset($_SESSION['password_err']) || isset($_SESSION['password_err1']) || isset($_SESSION['password_err2']) || isset($_SESSION['login_err']) || isset($_SESSION['login_err1']) || isset($_SESSION['login_pas_err']))

			$bool = true;

		return $bool;
	}
	function textMessage()
	{
		$bool = false;
		if (isset($_SESSION['result'])){
			echo $_SESSION['result'];
			unset($_SESSION['result']);
			$bool = true;
		}
		if (isset($_SESSION['new_name'])){
			echo $_SESSION['new_name'] . '  ';
			unset($_SESSION['new_name']);
			$bool = true;
		}
		if (isset($_SESSION['new_email'])){
			echo $_SESSION['new_email'] . '  ';
			unset($_SESSION['new_email']);
			$bool = true;
		}
		if (isset($_SESSION['image_err_ext'])){
			echo $_SESSION['image_err_ext'] . '  ';
			unset($_SESSION['image_err_ext']);
			$bool = true;
		}
		if (isset($_SESSION['image_err_size'])){
			echo $_SESSION['image_err_size'] . '  ';
			unset($_SESSION['image_err_size']);
			$bool = true;
		}
		if (isset($_SESSION['image_err_upl'])){
			echo $_SESSION['image_err_upl'] . '  ';
			unset($_SESSION['image_err_upl']);
			$bool = true;
		}
		if (isset($_SESSION['image_new'])){
			echo $_SESSION['image_new'] . '  ';
			unset($_SESSION['image_new']);
			$bool = true;
		}
		if (isset($_SESSION['email_err'])){
			echo $_SESSION['email_err'] . '  ';
			unset($_SESSION['email_err']);
			$bool = true;
		}
		if (isset($_SESSION['password_upd'])){
			echo $_SESSION['password_upd'];
			unset($_SESSION['password_upd']);
			$bool = true;
		}
		if (isset($_SESSION['password_err'])){
			echo $_SESSION['password_err'];
			unset($_SESSION['password_err']);
			$bool = true;
		}
		if (isset($_SESSION['password_err1'])){
			echo $_SESSION['password_err1'];
			unset($_SESSION['password_err1']);
			$bool = true;
		}
		if (isset($_SESSION['password_err2'])){
			echo $_SESSION['password_err2'];
			unset($_SESSION['password_err2']);
			$bool = true;
		}
		if (isset($_SESSION['login_err1'])){
			echo $_SESSION['login_err1'];
			unset($_SESSION['login_err1']);
			$bool = true;
		}
		if (isset($_SESSION['login_err'])){
			echo $_SESSION['login_err'];
			unset($_SESSION['login_err']);
			$bool = true;
		}
		if (isset($_SESSION['login_pas_err'])){
			echo $_SESSION['login_pas_err'];
			unset($_SESSION['login_pas_err']);
			$bool = true;
		}
		return $bool;
	}