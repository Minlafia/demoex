<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Если пользователь не авторизован, перенаправьте на страницу входа
    exit();
}

$sql = "SELECT * FROM Applications WHERE user_id = ".$_SESSION['user_id'];

$result = mysqli_query($connection, $sql);

$applications = [];
while ($value = mysqli_fetch_row($result)) {
    $applications[] = [
        'address' => $value[2],
        'date' => $value[3],
        'time' => $value[4],
        'type' => $value[5],
        'status' => $value[6],
        'contacts' => $value[7]
    ];
}

header('Content-Type: application/json');
echo json_encode($applications);