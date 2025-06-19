<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СпортGo - Аренда спортивного инвентаря</title>
    <link href="style.css" rel="stylesheet" />
    <style>
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }
        .was-validated .form-control:invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
    <? include('utils/header.php') ?>
    <!-- Страница регистрации -->
    <div id="registration-page" class="container">
        <div class="card">
            <h2>Регистрация</h2>
            <form id="registrationForm" action="register.php" method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input type="text" class="form-control" name="login" id="login" required minlength="6">
                    <div class="invalid-feedback">
                        Логин должен содержать минимум 6 символов
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password" id="password" required minlength="6">
                    <div class="invalid-feedback">
                        Пароль должен содержать минимум 6 символов
                    </div>
                </div>
                <div class="form-group">
                    <label for="fullName">ФИО</label>
                    <input type="text" class="form-control" name="fullName" id="fullName" required pattern="[А-Яа-яЁё\s]+">
                    <div class="invalid-feedback">
                        Введите ФИО кириллицей (допускаются только буквы и пробелы)
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="tel" class="form-control" name="phone" id="phone" required pattern="\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}">
                    <div class="invalid-feedback">
                        Введите телефон в формате +7(XXX)-XXX-XX-XX
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Адрес электронной почты</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                    <div class="invalid-feedback">
                        Введите корректный email адрес
                    </div>
                </div>

                <?php
                require_once 'utils/connect.php';
                
                $data = $_POST;
                if( !empty($data) ) {
                    // Проверка валидации на сервере
                    $errors = array();
                    
                    // Проверка логина
                    if (strlen($data['login']) < 6) {
                        $errors[] = "Логин должен содержать минимум 6 символов";
                    }
                    
                    // Проверка пароля
                    if (strlen($data['password']) < 6) {
                        $errors[] = "Пароль должен содержать минимум 6 символов";
                    }
                    
                    // Проверка ФИО
                    if (!preg_match('/^[А-Яа-яЁё\s]+$/u', $data['fullName'])) {
                        $errors[] = "ФИО должно содержать только кириллические буквы и пробелы";
                    }
                    
                    // Проверка телефона
                    if (!preg_match('/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', $data['phone'])) {
                        $errors[] = "Телефон должен быть в формате +7(XXX)-XXX-XX-XX";
                    }
                    
                    // Проверка email
                    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Введите корректный email адрес";
                    }
                    
                    if (empty($errors)) {
                        $connect = mysqli_query($connection, 'SELECT * FROM `users` WHERE login="'.$data['login'].'" OR email="'.$data['email'].'"');
                        $user = mysqli_fetch_assoc($connect);

                        if( empty($user) ) {
                            echo '<div class="mb-3 alert alert-success">Успешная регистрация</div>';
                            $login = mysqli_real_escape_string($connection, $data['login']);
                            $full_name = mysqli_real_escape_string($connection, $data['fullName']);
                            $email = mysqli_real_escape_string($connection, $data['email']);
                            $phone = mysqli_real_escape_string($connection, $data['phone']);
                            $password = mysqli_real_escape_string($connection, $data['password']);

                            $result = mysqli_query($connection, "INSERT INTO `users` (`login`, `password`, `full_name`, `phone`, `email`) VALUES ('$login', '$password', '$full_name', '$phone', '$email')");
                            session_start();
                            echo '<meta http-equiv="refresh" content="1; url=/">';
                        } else {
                            echo '<div class="mb-3 alert alert-danger">Пользователь с таким логином или email уже существует</div>';
                        }
                    } else {
                        echo '<div class="mb-3 alert alert-danger">'.implode('<br>', $errors).'</div>';
                    }
                }
                ?>

                <button type="submit" class="btn">Зарегистрироваться</button>
            </form>
        </div>
    </div>

    <script>
        // Клиентская валидация
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        
        // Маска для телефона
        document.getElementById('phone').addEventListener('input', function(e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = !x[2] ? x[1] : '+' + x[1] + '(' + x[2] + (x[3] ? ')-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
        });
    </script>
</body>
</html>