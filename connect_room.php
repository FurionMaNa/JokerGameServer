<?php
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$link = mysqli_connect($host, $user, $password, $database) or die("error");
	$query ="UPDATE `users` SET `room_id`=".$_GET['id']." WHERE (`id`=".$_GET['U'].")";
	$result = mysqli_query($link, $query) or die("error");
	mysqli_close($link);
?>