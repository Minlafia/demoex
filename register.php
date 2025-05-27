<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Регистрация</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
        <h2 class="text-center">Регистрация</h2>
        <form id="registrationForm" action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="fullName">ФИО</label>
                <input type="text" class="form-control" name="fullName" required>
            </div>
            <div class="form-group">
                <label for="phone">Телефон</label>
                <input type="text" class="form-control" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Адрес электронной почты</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <?php
				require_once 'utils/connect.php';
				
				$data = $_POST;
				if( !empty($data) ) {
					$connect = mysqli_query($connection, 'SELECT * FROM `Users` WHERE username="'.$data['username'].'"');
					$user = mysqli_fetch_assoc($connect);

					$errors = Array();

					if( empty($user) ) {
						echo '<div class="mb-3" style="color: green;">Успешная регистрация</div>';
						$username = $data['username'];
                        $full_name = $data['fullName'];
                        $email = $data['email'];
                        $phone = $data['phone'];
						$password = ($data['password']);

						$result = mysqli_query($connection, "INSERT INTO `users` (`username`, `password`, `full_name`, `phone`, `email`) VALUES ('$username', '$password', '$full_name', '$phone', '$email')");
						session_start();
						echo '<meta http-equiv="refresh" content="1; url=/">';
					} else {
						echo '<div class="mb-3 text-danger">Эта почта уже зарегистрирована</div>';
					}
				}
				?>
            <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>