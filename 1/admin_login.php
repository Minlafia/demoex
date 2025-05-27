<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Авторизация Администратора</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Система Заявлений</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                session_start();
                    if(isset($_SESSION['admin_logged_in'])) {
                        header("Location: /admin_panel.php");
                        die();
                    }
                    if(!isset($_SESSION['user_id'])) {
                        echo '
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Войти как Гражданин</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Регистрация</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_login.php">Войти как Администратор</a>
                </li>
                        ';
                    } else {
                        echo '
                <li class="nav-item">
                    <a class="nav-link" href="applications.php">Посмотреть и Создать Заявления</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout_all.php">Выйти</a>
                </li>
                            ';
                    }
                
                ?>
            </ul>

        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="text-center">Авторизация Администратора</h2>
        <form id="adminLoginForm" action="admin_login.php" method="POST">
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <?php
            session_start();

            // Проверка логина и пароля
            $admin_username = "copp";
            $admin_password = "password";

            if(!empty($_POST['username']) && !empty($_POST['password'])) {

                if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {

                    $_SESSION['admin_logged_in'] = true; // Сохранение состояния авторизации
                    echo '<div class="mb-2" style="color: green;">Авторизовано</div>';
                    echo '<meta http-equiv="refresh" content="1; url=/admin_panel.php">';
                } else {
                    echo '<div class="mb-2" style="color: red;">Неверный логин или пароль</div>';
                }
            }
            ?>
            <button type="submit" class="btn btn-primary btn-block">Войти</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>
</body>
</html>