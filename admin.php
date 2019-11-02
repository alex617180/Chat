<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Chat</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Chat
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php if ($_SESSION['admin']) {
                            ?>

                            <div class="dropdown">
                                <button onclick="myFunction()" class="dropbtn"><?php echo 'Привет, ' . htmlspecialchars($_SESSION['admin']) . ' !'; ?></button>
                                <div id="myDropdown" class="dropdown-content">
                                    <a href="profile.php">Профиль</a>
                                    <a href="logout.php">Выход</a>
                                </div>
                            </div>

                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php if ($_SESSION['admin']) { ?>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Админ панель</h3>
                            </div>

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    // вывод комментов:
                                        $comments = getComments();
                                     foreach ($comments as $user) { ?>
                                        <tr>
                                            <td>
                                                <img src="<?php getImageUser($user["image"]); ?>
                                                    " alt="" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td><?php echo   $user["name"]; ?></td>
                                            <td><?php echo  date('d/m/Y', strtotime($user["date"])); ?></td>
                                            <td><?php echo   $user["text"]; ?></td>
                                            <td>
                                            <?php if ($user["skip"] == 1) { ?>
                                                <form action="admin_handling.php" method="post">
                                                <button type="submit" name="show" value="<?php echo $user["id"]; ?>" class="btn btn-success">Показано</button>
                                                </form>
                                            <?php } else {?>
                                                <form action="admin_handling.php" method="post">
                                                <button type="submit" name="skip" value="<?php echo $user["id"]; ?>" class="btn btn-warning">Скрыто</button>
                                                </form>
                                            <?php } ?><form action="admin_handling.php" method="post">
                                                <button onclick="return confirm('are you sure?')" type="submit" name="del" value="<?php echo $user["id"]; ?>" class="btn btn-danger">Удалить</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php }
        else {
            echo "В ДОСТУПЕ ОТКАЗАНО!";
        } ?>
    </div>
    <script src="js/main.js"></script>
</body>

</html>