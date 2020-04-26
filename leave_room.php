<?php
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$link = mysqli_connect($host, $user, $password, $database) or die("error");
	$query ="UPDATE `users` SET `room_id`=null WHERE (`id`=".$_GET['U'].")";
	$result = mysqli_query($link, $query) or die("error"); 
	$query ="
		SELECT `id`
		FROM `users`
		WHERE (`room_id`=".$_GET['id'].")";
	$result = mysqli_query($link, $query) or die("error"); 
	$num_rows = mysqli_num_rows($result);
	if($num_rows==0){
		$query ="DELETE FROM `room` WHERE (`id`=".$_GET['id'].")";
		$result = mysqli_query($link, $query) or die("error"); 
	}
	mysqli_close($link);
?>