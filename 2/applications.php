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
                    <th>Адресс</th>
                    <th>Контакты</th>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Тип</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody id="applicationsTableBody">
                <!-- Данные заявлений будут добавлены сюда с помощью JavaScript -->
            </tbody>

        </table>
        <a href="create_application.php" class="btn btn-primary">Создать заявление</a>
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
                                <td>${application.address}</td>
                                <td>${application.contacts}</td>
                                <td>${application.date}</td>
                                <td>${application.time}</td>
                                <td>${application.type}</td>
                                <td>${application.status}</td>
                            </tr>
                        `);
                    });
                },
                error: function(response) {
                    console.log(response.responseText);
                    alert('Не удалось загрузить заявления.');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>