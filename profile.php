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
        <?php if ($name_aut) { ?>
            <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Профиль пользователя</h3>
                                </div>

                                <div class="card-body">

                                    <div class="alert alert-success <?php if (empty(issetMessage())) echo 'd-none';?>" role="alert">
                                        <?php textMessage(); ?>
                                    </div>

                                    <form action="profile_handling_name.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Name</label>
                                                    <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $_SESSION['user_info']->name; ?>" required>

                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Email</label>
                                                    <input type="email" class="form-control" name="email" id="exampleFormControlInput1" value="<?php echo $_SESSION['user_info']->email; ?>" required>

                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Аватар</label>
                                                    <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <img src="<?php getImageUser($_SESSION['user_info']->image); ?>" alt="" class="img-fluid">
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-warning">Edit profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Безопасность</h3>
                                </div>

                                <div class="card-body">
                                    <form action="profile_handling_password.php" method="post">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Current password</label>
                                                    <input type="password" name="pas_cur" class="form-control" id="exampleFormControlInput1" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">New password</label>
                                                    <input type="password" name="password" class="form-control" id="exampleFormControlInput1" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Password confirmation</label>
                                                    <input type="password" name="pas_conf" class="form-control" id="exampleFormControlInput1" required>
                                                </div>

                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        <?php } ?>
    </div>
    <script src="js/main.js"></script>
</body>

</html>