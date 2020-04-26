<?php
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$L=$_GET['L'];
	$P=$_GET['P'];
	$i=0;
	$link = mysqli_connect($host, $user, $password, $database) or die("error");
	$query ="
			SELECT `room`.id,`room`.name, count(`users`.id) as 'count'
			FROM `users` 
			inner join `room` on(`users`.`room_id`=`room`.id) 
			GROUP by `room`.id,`room`.name";
	$result = mysqli_query($link, $query) or die("error"); 
	$data=array();
	while ($row=mysqli_fetch_assoc($result)) {
		$data[]=$row;

	}	
	echo '{"data":'.json_encode($data).'}';
	mysqli_close($link);
?>