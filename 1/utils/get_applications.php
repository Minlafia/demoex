<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Если пользователь не авторизован, перенаправьте на страницу входа
    exit();
}

$sql = "SELECT car_number, description, status FROM Applications WHERE user_id = ".$_SESSION['user_id'];

$result = mysqli_query($connection, $sql);

$applications = [];
while ($value = mysqli_fetch_row($result)) {
    $applications[] = [
        'car_number' => $value[0],
        'description' => $value[1],
        'status' => $value[2]
    ];
}

header('Content-Type: application/json');
echo json_encode($applications);