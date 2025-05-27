<?php
session_start();
require_once 'connect.php';

// Получение данных из формы
$address = $_POST['address'];
$contacts = $_POST['contacts'];
$date = $_POST['date'];
$time = $_POST['time'];
$type = $_POST['type'];

$user_id = $_SESSION['user_id']; // Получаем ID пользователя из сессии

// Подготовка и выполнение SQL-запроса
$sql = "INSERT INTO Applications (user_id, address, contacts, `date`, `time`, `type`, `status`) VALUES ('$user_id', '$address', '$contacts', '$date', '$time', '$type', 'новое')";

$result = mysqli_query($connection, $sql);

if ($result) {
    echo "Заявление успешно добавлено!";
} else {
    echo "Ошибка";
}