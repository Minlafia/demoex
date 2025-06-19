    <header>
        <div class="container header-content">
            <a href="/" class="logo">Спорт<span>Go</span></a>
            <nav>
                <ul>
                <?php
                session_start();
                    if(isset($_SESSION['admin_logged_in'])) {
                        header("Location: /admin.php");
                        die();
                    }
                    if(!isset($_SESSION['user_id'])) {
                        echo '
                    <li><a href="/login.php">Вход</a></li>
                    <li><a href="/register.php">Регистрация</a></li>
                    <li><a href="/admin_login.php">Админ-панель</a></li>
                    ';
                    } else {
                        echo '
                    <li><a href="/profile.php">Личный кабинет</a></li>
                    <li><a href="/logout.php">Выход</a></li> 
                    ';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </header>