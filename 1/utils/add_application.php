<?php
session_start();
require_once 'connect.php';

// Получение данных из формы
$car_number = $_POST['car_number'];
$description = $_POST['description'];
$user_id = $_SESSION['user_id']; // Получаем ID пользователя из сессии

// Подготовка и выполнение SQL-запроса
$sql = "INSERT INTO Applications (user_id, car_number, description) VALUES ('$user_id', '$car_number', '$description')";

$result = mysqli_query($connection, $sql);

if ($result) {
    echo "Заявление успешно добавлено!";
} else {
    echo "Ошибка";
}