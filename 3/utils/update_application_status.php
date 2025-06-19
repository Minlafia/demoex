<?php
session_start();
require_once 'connect.php';

$id = $_POST['id'];
$status = $_POST['status'];
$reason = $_POST['reason'];

// Подготовка и выполнение SQL-запроса для обновления статуса
$sql = "UPDATE `Applications` SET `status` = '".$status."', `reason` = '".$reason."' WHERE `Applications`.`id` = ".$id;
$result = mysqli_query($connection, $sql);

if ($result) {
    echo "Статус успешно изменён!";
} else {
    echo "Ошибка";
}