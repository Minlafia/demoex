<?php
session_start();
require_once 'connect.php';

// Получение данных из формы
$equipment_id = $_POST['equipment_type'];
$date = $_POST['date'];
$point_id = $_POST['pickup-point'];
$payment = $_POST['payment'];

$user_id = $_SESSION['user_id']; // Получаем ID пользователя из сессии

// Подготовка и выполнение SQL-запроса
$sql = "INSERT INTO orders (user_id, equipment_id, point_id, `date`, `total_price`, `payment_method`, `status`) VALUES ('$user_id', '$equipment_id', '$point_id', '$date', 0, '$payment', 'new')";

$result = mysqli_query($connection, $sql);

if ($result) {
    header('Location: /profile.php');
} else {
    echo "Ошибка";
}