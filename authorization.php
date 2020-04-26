<?php
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$L=$_GET['L'];
	$P=$_GET['P'];
	$i=0;
	$link = mysqli_connect($host, $user, $password, $database) or die("error");
	$query ="SELECT `id`
			 FROM users
			 WHERE((`login`='".$L."')and(`password`='".$P."'))";
	$result = mysqli_query($link, $query) or die("error"); 
	$f=true;
	while ($row=mysqli_fetch_assoc($result)) {
		echo $row['id'];
		$f=false;
	}	
	if($f){
		echo "error";
	}
	mysqli_close($link);
?>