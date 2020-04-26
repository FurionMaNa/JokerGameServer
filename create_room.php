<?php
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$link = mysqli_connect($host, $user, $password, $database) or die("error");
	$query ="SELECT `name` FROM `room` WHERE(`name`='".$_GET['N']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$num_rows = mysqli_num_rows($result);
	if($num_rows==0){
		$query ="INSERT INTO `room`(`id`, `name`) VALUES (null,'".$_GET['N']."')";
		$result = mysqli_query($link, $query) or die("error"); 
		$query ="SELECT `id` FROM `room` WHERE(`name`='".$_GET['N']."')";
		$result = mysqli_query($link, $query) or die("error"); 
		while ($row=mysqli_fetch_assoc($result)) {
			$id=$row['id'];
		}	
		echo $id;
		$query ="UPDATE `users` SET `room_id`=".$id." WHERE (`id`=".$_GET['U'].")";
		$result = mysqli_query($link, $query) or die("error"); 
	}else{
		echo "error";
	}
	mysqli_close($link);
?>