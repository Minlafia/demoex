<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Создание заявки</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .other-service-container {
            display: none;
            margin-top: 10px;
        }
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
        <h2 class="text-center">Новое Заявление</h2>
        <form id="applicationForm" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="address">Адрес</label>
                <input type="text" class="form-control" id="address" required>
                <div class="invalid-feedback">
                    Пожалуйста, укажите адрес
                </div>
            </div>
            <div class="form-group">
                <label for="contacts">Контактные данные</label>
                <input type="tel" class="form-control" name="contacts" placeholder="+7(XXX)-XXX-XX-XX" id="contacts" required pattern="\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}">
                <div class="invalid-feedback">
                    Введите телефон в формате +7(XXX)-XXX-XX-XX
                </div>
            </div>
            <div class="form-group">
                <label for="date">Дата</label>
                <input type="date" class="form-control" id="date" required>
                <div class="invalid-feedback">
                    Пожалуйста, укажите дату
                </div>
            </div>
            <div class="form-group">
                <label for="time">Время</label>
                <input type="time" class="form-control" id="time" required>
                <div class="invalid-feedback">
                    Пожалуйста, укажите время
                </div>
            </div>
            <div class="form-group">
                <label for="type">Тип уборки</label><br>
                <select id="type" class="form-select form-control" required>
                    <option value="">Выберите тип уборки</option>
                    <option value="Общий клининг">Общий клининг</option>
                    <option value="Генеральная уборка">Генеральная уборка</option>
                    <option value="Послестроительная уборка">Послестроительная уборка</option>
                    <option value="Химчистка ковров и мебели">Химчистка ковров и мебели</option>
                </select>
                <div class="invalid-feedback">
                    Пожалуйста, выберите тип уборки
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="otherCheckbox">
                    <label class="form-check-label" for="otherCheckbox">Иная услуга</label>
                </div>
                <div id="otherServiceContainer" class="other-service-container">
                    <input type="text" class="form-control mt-2" id="otherService" placeholder="Укажите свою услугу">
                    <div class="invalid-feedback">
                        Пожалуйста, укажите свою услугу
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="payment">Тип оплаты</label><br>
                <select id="payment" class="form-select form-control" required>
                    <option value="">Выберите тип оплаты</option>
                    <option value="Наличка">Наличка</option>
                    <option value="Банковская карта">Банковская карта</option>
                </select>
                <div class="invalid-feedback">
                    Пожалуйста, выберите тип оплаты
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Отправить Заявление</button>
        </form>
        <div id="message" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            // Обработчик для чекбокса "Иная услуга"
            $('#otherCheckbox').change(function() {
                if(this.checked) {
                    $('#otherServiceContainer').show();
                    $('#type').val('').prop('disabled', true);
                    $('#otherService').prop('required', true);
                } else {
                    $('#otherServiceContainer').hide();
                    $('#type').prop('disabled', false);
                    $('#otherService').prop('required', false);
                }
            });

            // Обработка отправки формы
            $('#applicationForm').submit(function(event) {
                event.preventDefault();
                
                // Проверка валидности формы
                if (this.checkValidity() === false) {
                    event.stopPropagation();
                    $(this).addClass('was-validated');
                    return;
                }

                // Подготовка данных для отправки
                const applicationData = {
                    address: $('#address').val(),
                    contacts: $('#contacts').val(),
                    date: $('#date').val(),
                    time: $('#time').val(),
                    type: $('#otherCheckbox').is(':checked') ? $('#otherService').val() : $('#type').val(),
                    payment: $('#payment').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '/utils/add_application.php',
                    data: applicationData,
                    success: function(response) {
                        $('#message').html('<div class="alert alert-success">' + response + '</div>');
                        // setTimeout(function() {
                        //     window.location.href = "/applications.php";
                        // }, 1500);
                    },
                    error: function(error) {
                        console.log(error);
                        $('#message').html('<div class="alert alert-danger">Произошла ошибка. Попробуйте снова.</div>');
                    }
                });
            });

            // Маска для телефона
            $('#contacts').on('input', function(e) {
                var x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
                e.target.value = !x[2] ? x[1] : '+' + x[1] + '(' + x[2] + (x[3] ? ')-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>