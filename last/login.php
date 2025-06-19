<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СпортGo - Аренда спортивного инвентаря</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>
    <? include('utils/header.php') ?>
    <!-- Страница авторизации -->
    <div id="login-page" class="container">
        <div class="card">
            <h2>Вход в систему</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="login-login">Логин</label>
                    <input type="text" id="login-login" name="login" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Пароль</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                
            <?php
                require_once 'utils/connect.php';

                $data = $_POST;
                if(!empty($data)) {
                    $connect = mysqli_query($connection, 'SELECT * FROM `users` WHERE login="'.$data['login'].'"');
                    $user = mysqli_fetch_assoc($connect);
                }

                if( !empty($data['login']) and !empty($data['password']) ) {
                    if( isset($user['login']) and $user['login'] == $data['login'] ) {
                        if( $user['password'] == $data['password']) {
                            echo '<div class="mb-2" style="color: green;">Авторизовано</div>';
                            session_start();
                            $_SESSION['user_id'] = $user['user_id'];
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
                <button type="submit" class="btn">Войти</button>
            </form>
        </div>
    </div>
</body>
</html>