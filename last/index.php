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

    <!-- Главная страница -->
    <div id="home-page" class="container">
        <section class="hero">
            <h1>Аренда спортивного инвентаря</h1>
            <p>Арендуйте велосипеды, лыжи, ролики и другое снаряжение по выгодным ценам</p>
            <a href="#" class="btn" onclick="showPage('registration-page')">Зарегистрироваться</a>
        </section>

        <h2>Наш инвентарь</h2>
        <div class="inventory-list">
            <div class="inventory-item">
                <h3>Велосипеды</h3>
                <p>Горные, городские, шоссейные</p>
            </div>
            <div class="inventory-item">
                <h3>Лыжи</h3>
                <p>Горные и беговые лыжи с ботинками</p>
            </div>
            <div class="inventory-item">
                <h3>Роликовые коньки</h3>
                <p>Разные размеры и уровни катания</p>
            </div>
            <div class="inventory-item">
                <h3>Туристическое снаряжение</h3>
                <p>Палатки, рюкзаки, спальники</p>
            </div>
        </div>
    </div>
</body>
</html>