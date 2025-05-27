<?php
$config = [
	'host' => 'MySQL-5.7',
	'login' => 'root',
	'password' => '',
	'name' => 'govnoo'
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