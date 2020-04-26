<?php
	
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$link = mysqli_connect($host, $user, $password, $database) or die("error");
	$query ="
		SELECT `tabel`
		FROM `room` 
		WHERE(`id`='".$_GET['id']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$data=array();
	while ($row=mysqli_fetch_assoc($result)) {
		echo str_replace('\\',"",substr(json_encode($row['tabel']),1,-1));
	}	
	
	mysqli_close($link);
?>