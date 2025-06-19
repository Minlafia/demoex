<? require 'utils/connect.php';
    session_start();
    if(!isset($_SESSION['user_id']))
        header('location:login.php')
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СпортGo - Аренда спортивного инвентаря</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>
    <? include('utils/header.php') ?>
    <!-- Личный кабинет пользователя -->
    <div id="profile-page" class="container">
        <div class="card">
            <h2>Личный кабинет</h2>
            <h3>История заказов</h3>
            <table>
                <thead>
                    <tr>
                        <th>№ заказа</th>
                        <th>Дата</th>
                        <th>Инвентарь</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                        $user_id = $_SESSION['user_id'];
                        $sql = "SELECT orders.*, equipment.name
                                FROM orders
                                INNER JOIN equipment ON orders.equipment_id = equipment.equipment_id
                                WHERE user_id = '$user_id'";
                        $result = mysqli_query($connection, $sql);
                        while($myrow = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td>#<? echo $myrow['order_id'] ?></td>
                        <td><? echo $myrow['created_at'] ?></td>
                        <td><? echo $myrow['name'] ?></td>
                        <td>
                            <?
                                if($myrow['status'] === 'new')
                                    echo 'Ожидает подтверждения';
                                else if($myrow['status'] === 'confirmed')
                                    echo 'Подтверждено';
                                else if($myrow['status'] === 'completed')
                                    echo 'Выполнено';
                                else if($myrow['status'] === 'cancelled')
                                    echo 'Отменено'
                            ?>
                        </td>
                    </tr>
                    <? } ?>
                    <!-- <tr>
                        <td>#12344</td>
                        <td>10.04.2023</td>
                        <td>Горные лыжи</td>
                        <td>Завершен</td>
                    </tr> -->
                </tbody>
            </table>
            <a href="/application.php" class="btn" onclick="showPage('order-page')">Создать заказ</a>
        </div>
    </div>
</body>
</html>