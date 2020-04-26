<?php
	class GameData{
		var $dataCard;
		var $dataUser;

		function GameData($dataCard,$dataUser){
			$this->dataCard=$dataCard;
			$this->dataUser=$dataUser;
		}
	}
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$link = mysqli_connect($host, $user, $password, $database) or die("error1");
	$query ="
		SELECT `Round`,`tabel`
		FROM `room` 
		WHERE(`id`='".$_GET['id']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$data=array();
	$cards=array();
	while ($row=mysqli_fetch_assoc($result)) {
		$data[]=$row;
	}	
	$query ="
		SELECT `id`,`points`
		FROM `users` 
		WHERE(`room_id`='".$_GET['id']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$data2=array();
	while ($row=mysqli_fetch_assoc($result)) {
		$data2[]=$row;
	}
	echo str_replace('\\',"",json_encode(new GameData($data,$data2)));
	mysqli_close($link);
?>