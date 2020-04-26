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
			SELECT `room`.id,`room`.name, `users`.nick
			FROM `users` 
			inner join `room` on(`users`.`room_id`=`room`.id)
			WHERE (`room`.id=".$_GET['id'].") ";
	$result = mysqli_query($link, $query) or die("error"); 
	$data=array();
	while ($row=mysqli_fetch_assoc($result)) {
		$data[]=$row;
	}	
	$nameRoom="";
	$idRoom=0;
	if(count($data)>0){
		$nameRoom=$data[$i]['name'];
		$idRoom=$data[$i]['id'];
	}
	$d=array();
	for($i=0;$i<count($data);$i++){
		$d[$i]=array('nick'=>$data[$i]['nick']);
	}
	echo '{"name":"'.$nameRoom.'","id":'.$idRoom.',"nick":'.json_encode($d).'}';
	mysqli_close($link);
?>