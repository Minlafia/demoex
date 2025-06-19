<?php
	if (!isset($_SESSION)) { session_start(); }
	unset($_SESSION['user_id']);
	unset($_SESSION['admin_logged_in']);
	header('Location: /');
?>