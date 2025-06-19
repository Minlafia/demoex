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
    <!-- Страница оформления заказа -->
    <div id="order-page" class="container">
        <div class="card">
            <h2>Оформление заказа</h2>
            <form action="utils/create_application.php" method="post">
                <div class="form-group">
                    <label for="equipment_type">Тип инвентаря</label>
                    <select id="equipment_type" name="equipment_type" required>
                        <option value="">Выберите тип инвентаря</option>
                        <option value="1">Велосипед</option>
                        <option value="2">Лыжи</option>
                        <option value="3">Роликовые коньки</option>
                        <option value="4">Туристическое снаряжение</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Дата и время аренды</label>
                    <input type="datetime-local" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="pickup-point">Пункт выдачи</label>
                    <select id="pickup-point" name="pickup-point" required>
                        <option value="">Выберите пункт выдачи</option>
                        <option value="1">Российская 100/3</option>
                        <option value="2">Малая шелководная 1</option>
                        <option value="3">Проспект октября 107/2 кв.9 (местный притон)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Способ оплаты</label>
                    <div>
                        <input type="radio" id="cash" name="payment" value="cash" checked>
                        <label for="cash" style="display: inline;">Наличные</label>
                    </div>
                    <div>
                        <input type="radio" id="card" name="payment" value="card">
                        <label for="card" style="display: inline;">Банковская карта</label>
                    </div>
                </div>
                <button type="submit" class="btn">Подтвердить заказ</button>
            </form>
        </div>
    </div>
</body>
</html>