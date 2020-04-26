<?php
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$link = mysqli_connect($host, $user, $password, $database) or die("error1");
	$query ="SELECT `nick` FROM `users` WHERE(`nick`='".$_GET['N']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$num_rows = mysqli_num_rows($result);
	if($num_rows==0){
		$query ="SELECT `login` FROM `users` WHERE(`login`='".$_GET['L']."')";
		$result = mysqli_query($link, $query) or die("error"); 
		$num_rows = mysqli_num_rows($result);
		if($num_rows==0){
			$query ="INSERT INTO `users`(`id`, `nick`, `login`, `password`) VALUES (null,'".$_GET['N']."','".$_GET['L']."','".$_GET['P']."')";
			$result = mysqli_query($link, $query) or die("error"); 
		}else{
			echo "error";
		}
	}else{
		echo "error";
	}
	mysqli_close($link);
?>