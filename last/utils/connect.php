<?php
$config = [
	'host' => 'localhost',
	'login' => 'root',
	'password' => '',
	'name' => 'last'
];
//error_reporting(0);
$connection = mysqli_connect(
	$config['host'],
	$config['login'],
	$config['password'],
	$config['name']
);

if( $connection == false )
{
	echo '<h5 style="text-align: center; margin-top: 20px;">Failed to connect to DB<h5><br>';
	echo '<h5 style="text-align: center;">'.mysqli_connect_error();
	exit();
}