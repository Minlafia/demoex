<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Авторизация</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
        <h2 class="text-center">Авторизация</h2>
        <form id="loginForm" action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <?php
						require_once 'utils/connect.php';

						$data = $_POST;
						if(!empty($data)) {
							$connect = mysqli_query($connection, 'SELECT * FROM `users` WHERE username="'.$data['username'].'"');
							$user = mysqli_fetch_assoc($connect);
						}

						if( !empty($data['username']) and !empty($data['password']) ) {
							if( isset($user['username']) and $user['username'] == $data['username'] ) {
								if( $user['password'] == $data['password']) {
									echo '<div class="mb-2" style="color: green;">Авторизовано</div>';
                                    session_start();
									$_SESSION['user_id'] = $user['id'];
									echo '<meta http-equiv="refresh" content="1; url=/">';
								} else {
									$errors[] = 'Неправильный пароль';
								}
							} else {
								$errors[] = 'Пользователь не найден';
							}

							if( !empty($errors) ) {
								echo '<div class="mb-2" style="color: red;">'.array_shift($errors).'</div>';
							}
						};
					?>
            <button type="submit" class="btn btn-primary btn-block">Войти</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>