<?php
session_start();
require_once 'connect.php';

$sql = "
    SELECT a.id, u.full_name, a.address, a.contacts, a.date, a.time, a.type, a.payment, a.status
    FROM Applications a
    JOIN Users u ON a.user_id = u.id
";
$result = mysqli_query($connection, $sql);

$applications = [];
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $applications[] = [
            'id' => $row['id'],
            'full_name' => $row['full_name'],
            'address' => $row['address'],
            'contacts' => $row['contacts'],
            'date' => $row['date'],
            'time' => $row['time'],
            'type' => $row['type'],
            'payment' => $row['payment'],
            'status' => $row['status']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($applications);