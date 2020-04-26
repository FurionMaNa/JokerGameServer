<?php
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$link = mysqli_connect($host, $user, $password, $database) or die("error1");
	$query ="
		SELECT `id`
		FROM `users` 
		WHERE(`room_id`='".$_GET['id']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$data=array();
	$cards=array();
	while ($row=mysqli_fetch_assoc($result)) {
		$data[]=$row['id'];
	}	
	for($i=0;$i<count($data);$i++){
		if($data[$i]==$_GET['U']){
			if($i==3){
				echo("<script language='JavaScript'>document.location.href='next_step.php?id=".$_GET['id']."+&Round=".$_GET['Round']."'</script>");
			}else{
				$query ="
				SELECT `tabel`
				FROM `room` 
				WHERE(`id`='".$_GET['id']."')";
				$result = mysqli_query($link, $query) or die("error"); 
				$data2=array();
				$row=mysqli_fetch_assoc($result);
				$data2=json_decode($row['tabel']);
				$data2->move=$data[$i+1];
				$query ="
					UPDATE `room`
					set `tabel` =".json_encode($data2)."
					WHERE(`id`='".$_GET['id']."')";
				$result = mysqli_query($link, $query) or die("error"); 
				break;														
			}
		}
	}
	mysqli_close($link);
?>