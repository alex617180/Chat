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
                        <?php
                        $name_aut = getNameUser();
                        if ($name_aut) : ?>

                            <div class="dropdown">
                                <button onclick="myFunction()" class="dropbtn"><?php echo 'Привет, ' . htmlspecialchars($name_aut) . ' !'; ?></button>
                                <div id="myDropdown" class="dropdown-content">
                                <?php if ($_SESSION['admin']) { ?>
                                    <a href="admin.php">Админка</a>
                                <?php } ?>
                                    <a href="profile.php">Профиль</a>
                                    <a href="logout.php">Выход</a>
                                </div>
                            </div>

                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Комментарии</h3>
                            </div>
                            <div class="card-body">
                                <?php if (issetMessage()) { ?>

                                    <div class="alert alert-success" role="alert">
                                        <?php issetMessage(); ?>

                                    <?php } ?>
                                    </div>
                                    <?php
                                    // вывод комментов:
                                    $comments = getComments();
                                    foreach ($comments as $user) {
                                        if ($user["skip"] == 1) {
                                        ?>

                                        <div class="media">

                                            <img src='<?php getImageUser($user["image"]); ?>' class='mr-3' alt='...' width='64' height='64'>
                                            <div class='media-body'>
                                                <h5 class='mt-0'><?php echo   $user["name"]; ?>
                                                </h5>
                                                <span><small>
                                                        <?php echo  date('d/m/Y', strtotime($user["date"])); ?>
                                                    </small></span>
                                                <p>
                                                    <?php echo   $user["text"]; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php }} ?>

                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Оставить комментарий</h3>
                                </div>
                                <?php if (isset($name_aut)) { ?>

                                <div class="card-body">
                                    <form action="index_handling.php" method="post">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Сообщение</label>
                                            <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">Отправить</button>

                                    </form>
                                </div>
                                <?php }
                                else {?>
                                 <div class="card-body card__comment">
                                    <p>Чтобы оставить комментарий, </p>
                                     <a class="" href="register.php">зарегистрируйтесь</a>
                                     <p> или </p>
                                     <a class="" href="login.php">авторизуйтесь</a>
                                 </div>
                                 <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>