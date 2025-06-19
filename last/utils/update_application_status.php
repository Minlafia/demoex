<?php
session_start();
require_once 'connect.php';

$id = $_GET['id'];
$status = $_GET['status'];
$reason = $_GET['cancelReason'];

// Подготовка и выполнение SQL-запроса для обновления статуса
$sql = "UPDATE `orders` SET `status` = '".$status."', `reason` = '".$reason."' WHERE `orders`.`order_id` = ".$id;
$result = mysqli_query($connection, $sql);

if ($result) {
    echo "Статус успешно изменён!";
} else {
    echo "Ошибка";
}