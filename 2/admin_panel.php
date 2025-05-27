<?php
session_start();
// Проверка, авторизован ли администратор
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); // Если не авторизован, перенаправить на страницу логина
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Панель Администратора</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="logout_all.php">Выйти</a>
                </li>
            </ul>

        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center">Панель Администратора</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Адресс</th>
                    <th>Контакты</th>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Тип</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody id="applicationsTableBody">
                <!-- Данные заявлений будут добавлены сюда с помощью JavaScript -->
            </tbody>
        </table>
        <img src="preloader.gif" id="loader" alt="" style="margin: 0 auto;display:none;">
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        // Получение данных о заявлениях при загрузке страницы
        document.getElementById('loader').style.display = "block";
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: '/utils/get_all_applications.php',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    const tbody = $('#applicationsTableBody');
                    data.forEach(application => {
                        tbody.append(`
                            <tr>
                                <td>${application.full_name}</td>
                                <td>${application.address}</td>
                                <td>${application.contacts}</td>
                                <td>${application.date}</td>
                                <td>${application.time}</td>
                                <td>${application.type}</td>
                                <td>${application.status}</td>
                                <td>
                                    <select class="form-control" onchange="changeStatus(${application.id}, this.value)">
                                        <option value="новое" ${application.status === "новое" ? 'selected' : ''}>Новое</option>
                                        <option value="подтверждено" ${application.status === "подтверждено" ? 'selected' : ''}>Подтверждено</option>
                                        <option value="отклонено" ${application.status === "отклонено" ? 'selected' : ''}>Отклонено</option>
                                    </select>
                                </td>
                            </tr>
                        `);
                    });
                    document.getElementById('loader').style.display = "none";
                },
                error: function() {
                    alert('Не удалось загрузить заявления.');
                }
            });
        });

        // Функция для изменения статуса заявления
        function changeStatus(applicationId, newStatus) {
            $.ajax({
                type: 'POST',
                url: '/utils/update_application_status.php',
                data: { id: applicationId, status: newStatus },
                success: function(response) {
                    alert(response);
                },
                error: function() {
                    alert('Ошибка изменения статуса.');
                }
            });
        }
    </script>
</body>
</html>