<?php
session_start();
// Проверка, авторизован ли администратор
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php'); // Если не авторизован, перенаправить на страницу логина
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>СпортGo - Аренда спортивного инвентаря</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>
    <header>
        <div class="container header-content">
            <a href="/" class="logo">Спорт<span>Go</span></a>
            <nav>
                <ul>
                    <li><a href="/logout.php">Выход</a></li> 
                </ul>
            </nav>
        </div>
    </header>
<!-- Панель администратора -->
<style type="text/css">
    .container {
        max-width: 100%!important;
    }
    @media (max-width: 768px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    
    #admin-page .card {
        padding: 10px;
    }
    
    th, td {
        padding: 8px 10px;
        font-size: 14px;
    }
    
    select {
        font-size: 14px;
        padding: 5px;
    }
}
</style>
    <div id="admin-page" class="container">
        <div class="card">
            <h2>Панель администратора</h2>
            <table>
                <thead>
                    <tr>
                        <th>№ заказа</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Email</th>
                        <th>Инвентарь</th>
                        <th>Дата</th>
                        <th>Способ оплаты</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                        require('utils/connect.php');
                        $sql = "SELECT orders.*, equipment.name, users.full_name, users.phone, users.email
                                FROM orders
                                INNER JOIN equipment ON orders.equipment_id = equipment.equipment_id
                                INNER JOIN users ON orders.user_id = users.user_id";
                        $result = mysqli_query($connection, $sql);
                        while($myrow = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td>#<? echo $myrow['order_id'] ?></td>
                        <td><? echo $myrow['full_name'] ?></td>
                        <td><? echo $myrow['phone'] ?></td>
                        <td><? echo $myrow['email'] ?></td>
                        <td><? echo $myrow['name'] ?></td>
                        <td><? echo $myrow['date'] ?></td>
                        <td>
                            <?
                                if($myrow['payment_method'] === 'cash') echo 'Наличные';
                                else if($myrow['payment_method'] === 'card') echo 'Карта';
                            ?>
                                
                            </td>
                        <td>
                            <select onchange="changeStatus(<? echo $myrow['order_id'] ?>, this.value)">
                                <option <? if($myrow['status'] === 'new') echo 'selected'; ?> value="new">Новый</option>
                                <option <? if($myrow['status'] === 'confirmed') echo 'selected'; ?> value="confirmed">Подтвержден</option>
                                <option <? if($myrow['status'] === 'completed') echo 'selected'; ?> value="completed">Выполнен</option>
                                <option <? if($myrow['status'] === 'cancelled') echo 'selected'; ?> value="cancelled">Отменен</option>
                            </select>
                        </td>
                    </tr>
                    <?
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        function changeStatus(applicationId, newStatus) {
            let cancelReason = '';
            if(newStatus == "cancelled"){
                cancelReason = prompt('Укажите причину отклонения');
            }

            fetch(`utils/update_application_status.php?id=${applicationId}&status=${newStatus}&cancelReason=${cancelReason}`)
            .then(response => {
              // if (!response.ok) {
              //   throw new Error(`HTTP error! status: ${response.status}`);
              // }
              //return response.json(); // Parse the response as JSON
              alert('Статус успешно изменен')
            })
            .then(data => {
              console.log(data); // Process the fetched data
            })
            .catch(error => {
              alert('Error fetching data:', error); // Handle any errors
            });

            // $.ajax({
            //     type: 'POST',
            //     url: '/utils/update_application_status.php',
            //     data: { id: applicationId, status: newStatus, reason: cancelReason },
            //     success: function(response) {
            //         alert(response);
            //     },
            //     error: function() {
            //         alert('Ошибка изменения статуса.');
            //     }
            // });
        }
    </script>
</body>
</html>