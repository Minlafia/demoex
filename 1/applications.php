<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Заявления</title>
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
        <h2 class="text-center">Ваши Заявления</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Номер автомобиля</th>
                    <th>Описание нарушения</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody id="applicationsTableBody">
                <!-- Данные заявлений будут добавлены сюда с помощью JavaScript -->
            </tbody>
        </table>
        <h4>Новое Заявление</h4>
        <form id="applicationForm">
            <div class="form-group">
                <label for="carNumber">Номер автомобиля</label>
                <input type="text" class="form-control" id="carNumber" required>
            </div>
            <div class="form-group">
                <label for="description">Описание нарушения</label>
                <textarea class="form-control" id="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Отправить Заявление</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        // Получение данных о заявлениях при загрузке страницы
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: '/utils/get_applications.php',
                dataType: 'json',
                success: function(data) {
                    const tbody = $('#applicationsTableBody');
                    data.forEach(application => {
                        tbody.append(`
                            <tr>
                                <td>${application.car_number}</td>
                                <td>${application.description}</td>
                                <td>${application.status}</td>
                            </tr>
                        `);
                    });
                },
                error: function() {
                    alert('Не удалось загрузить заявления.');
                }
            });

            // Обработка отправки нового заявления
            $('#applicationForm').submit(function(event) {
                event.preventDefault();

                const applicationData = {
                    car_number: $('#carNumber').val(),
                    description: $('#description').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '/utils/add_application.php',
                    data: applicationData,
                    success: function(response) {
                        //$('#message').html(response);
                        location.reload(); // Перезагрузка страницы для обновления заявлений
                    },
                    error: function() {
                        $('#message').html('Произошла ошибка. Попробуйте снова.');
                    }
                });
            });
        });
    </script>
</body>
</html>