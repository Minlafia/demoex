<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Создание заявления</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Система Заявлений</a>
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
        <h2 class="text-center">Новое Заявление</h2>
        <form id="applicationForm">
            <div class="form-group">
                <label for="carNumber">Адрес</label>
                <input type="text" class="form-control" id="address" required>
            </div>
            <div class="form-group">
                <label for="carNumber">Контактные данные</label>
                <input type="text" class="form-control" id="contacts" required>
            </div>
            <div class="form-group">
                <label for="carNumber">Дата</label>
                <input type="date" class="form-control" id="date" required>
            </div>
            <div class="form-group">
                <label for="carNumber">Время</label>
                <input type="time" class="form-control" id="time" required>
            </div>
            <div class="form-group">
                <label for="description">Тип уборки</label><br>
                <select id="type" class="form-select">
                    <option value="Общий клининг">Общий клининг</option>
                    <option value="Генеральная уборка">Генеральная уборка</option>
                    <option value="Послестроительная уборка">Послестроительная уборка</option>
                    <option value="Химчистка ковров и мебели">Химчистка ковров и мебели</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Отправить Заявление</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        // Получение данных о заявлениях при загрузке страницы
        $(document).ready(function() {
            // Обработка отправки нового заявления
            $('#applicationForm').submit(function(event) {
                event.preventDefault();

                const applicationData = {
                    address: $('#address').val(),
                    contacts: $('#contacts').val(),
                    date: $('#date').val(),
                    time: $('#time').val(),
                    type: $('#type').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '/utils/add_application.php',
                    data: applicationData,
                    success: function(response) {
                        $('#message').html(response);
                        //location.reload(); // Перезагрузка страницы для обновления заявлений
                    },
                    error: function() {
                        $('#message').html('Произошла ошибка. Попробуйте снова.');
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>