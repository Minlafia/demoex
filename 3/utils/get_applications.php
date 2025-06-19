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
    if($value[8] === 'новое') $newStatus = 'Новая заявка';
    if($value[8] === 'подтверждено') $newStatus = 'Новая заявка';
    if($value[8] === 'выполнено') $newStatus = 'Услуга оказана';
    if($value[8] === 'отклонено') $newStatus = 'Услуга отменена';
    $applications[] = [
        'address' => $value[2],
        'date' => $value[3],
        'time' => $value[4],
        'payment' => $value[5],
        'type' => $value[6],
        'reason' => $value[7],
        'status' => $newStatus,
        'contacts' => $value[9],
    ];
}

header('Content-Type: application/json');
echo json_encode($applications);