<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Главная Страница</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Мой не сам</a>
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
        <h2 class="text-center">Добро пожаловать в Клининговую компания "Мой Не Сам"</h2>
        <p class="text-center">На этой странице вы можете:</p>
        <ul>
            <li>Создать новую заявку</li>
            <li>Войти в систему для просмотра своих заявок</li>
            <li>Войти в систему как администратор для управления всеми заявками</li>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>