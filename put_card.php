<?php
	class card{
		var $suit;
		var $weight;
		function card($suit,$weight){
			$this->suit=$suit;
			$this->weight=$weight;
		}
	}

	class gameClass{
		var $round;
		var $trump;
		var $firstId;
		var $secondId;
		var $thirdId;
		var $forthId;
		var $firstPlayer;
		var $secondPlayer;
		var $thirdPlayer;
		var $forthPlayer;
		function gameClass($round,$trump,$firstId,$secondId,$thirdId,$forthId,$firstPlayer,$secondPlayer,$thirdPlayer,$forthPlayer){
			$this->round=intval($round);
			$this->trump=$trump;
			$this->firstId=intval($firstId);
 			$this->secondId=intval($secondId);
 			$this->thirdId=intval($thirdId);
 			$this->forthId=intval($forthId);
 			$this->firstPlayer=$firstPlayer;
 			$this->secondPlayer=$secondPlayer;
 			$this->thirdPlayer=$thirdPlayer;
 			$this->forthPlayer=$forthPlayer;
		}
	}

	function distributionCards($trump,$first,$second,$third,$forth,$id1,$id2,$id3,$id4,$round){
		$firstPlayer =array();
		$secondPlayer=array();
		$thirdPlayer =array();
		$forthPlayer =array();
		$firstPlayer[0]=$first;
		$secondPlayer[0]=$second;
		$thirdPlayer[0]=$third;
		$forthPlayer[0]=$forth;
		return json_encode(new gameClass($round,$trump,$id1,$id2,$id3,$id4,$firstPlayer,$secondPlayer,$thirdPlayer,$forthPlayer));
	}

	function addCard($suit,$weight,$data,$i){
		$host = 'localhost'; 
		$database = 'JokerGame'; 
		$user = 'mysql'; 
		$password = 'mysql';
		$link = mysqli_connect($host, $user, $password, $database) or die("error1");
		switch ($i) {
			case 1:
				$query ="UPDATE `room` SET `tabel`='".distributionCards($data->trump,new card($suit,$weight),$data->secondPlayer[0],$data->thirdPlayer[0],$data->forthPlayer[0],$data->firstId,$data->secondId,$data->thirdId,$data->forthId,$data->round)."', `round`=".($data->round+1)."  WHERE (`id`=".$_GET['id'].")";
				echo $query;
				$result = mysqli_query($link, $query) or die("error"); 
				break;
			case 2:
				$query ="UPDATE `room` SET `tabel`='".distributionCards($data->trump,$data->firstPlayer[0],new card($suit,$weight),$data->thirdPlayer[0],$data->forthPlayer[0],$data->firstId,$data->secondId,$data->thirdId,$data->forthId,$data->round)."', `round`=".($data->round+1)."  WHERE (`id`=".$_GET['id'].")";
				$result = mysqli_query($link, $query) or die("error"); 
				break;
			case 3:
				$query ="UPDATE `room` SET `tabel`='".distributionCards($data->trump,$data->firstPlayer[0],$data->secondPlayer[0],new card($suit,$weight),$data->forthPlayer[0],$data->firstId,$data->secondId,$data->thirdId,$data->forthId,$data->round)."', `round`=".($data->round+1)."  WHERE (`id`=".$_GET['id'].")";
				$result = mysqli_query($link, $query) or die("error"); 
				break;
			case 4:
				$query ="UPDATE `room` SET `tabel`='".distributionCards($data->trump,$data->firstPlayer[0],$data->secondPlayer[0],$data->thirdPlayer[0],new card($suit,$weight),$data->firstId,$data->secondId,$data->thirdId,$data->forthId,$data->round)."', `round`=".($data->round+1)."  WHERE (`id`=".$_GET['id'].")";
				echo $query;
				$result = mysqli_query($link, $query) or die("error"); 
				break;
				
		}
	}

	function deleteCard($d,$suit,$weight,$gamer){
		switch ($gamer) {
			case 1:
				for($i=0;$i<count($d->firstPlayer);$i++){
					if(($d->firstPlayer[$i]->suit==$suit)&&($d->firstPlayer[$i]->weight==$weight)){
						array_splice($d->firstPlayer, $i,1);
						break;
					}
				}
				break;
			case 2:
				for($i=0;$i<count($d->secondPlayer);$i++){
					if(($d->secondPlayer[$i]->suit==$suit)&&($d->secondPlayer[$i]->weight==$weight)){
						array_splice($d->secondPlayer, $i,1);
						break;
					}
				}
				break;
			case 3:
				for($i=0;$i<count($d->thirdPlayer);$i++){
					if(($d->thirdPlayer[$i]->suit==$suit)&&($d->thirdPlayer[$i]->weight==$weight)){
						array_splice($d->thirdPlayer, $i,1);
						break;
					}
				}
				break;
			case 4:
				for($i=0;$i<count($d->forthPlayer);$i++){
					if(($d->forthPlayer[$i]->suit==$suit)&&($d->forthPlayer[$i]->weight==$weight)){
						array_splice($d->forthPlayer, $i,1);
						break;
					}
				}
				break;
		}
		$host = 'localhost'; 
		$database = 'JokerGame'; 
		$user = 'mysql'; 
		$password = 'mysql';
		$link = mysqli_connect($host, $user, $password, $database) or die("error");
		$query ="
			UPDATE `room`
			SET `cards`='".json_encode($d)."'
			WHERE(`id`='".$_GET['id']."')";
		$result = mysqli_query($link, $query) or die("error"); 

	}


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
	$row=mysqli_fetch_assoc($result);
	$data=json_decode($row['tabel']);
	$query ="
		SELECT `cards`
		FROM `room` 
		WHERE(`id`='".$_GET['id']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$row=mysqli_fetch_assoc($result);
	$data2=json_decode($row['cards']);
	$name;
	$f=true;
	if((count($data->forthPlayer)!=0)&&(count($data->thirdPlayer)==0)){
		$name='forthPlayer';
		$f=true;
	}else{
		if((count($data->thirdPlayer)!=0)&&(count($data->secondPlayer)==0)){
			$name='thirdPlayer';
			$f=true;
		}else{
			if((count($data->secondPlayer)!=0)&&(count($data->firstPlayer)==0)){
				$name='secondPlayer';
				$f=true;
			}else{
				if(count($data->firstPlayer)!=0){
					$name='firstPlayer';
					$f=true;
				}else{
					if($_GET['U']==$data2->firstId){
						deleteCard($data2,$_GET['suit'],$_GET['weight'],1);
						addCard($_GET['suit'],$_GET['weight'],$data,1);
					}else{
						if($_GET['U']==$data2->secondId){
							deleteCard($data2,$_GET['suit'],$_GET['weight'],2);
							addCard($_GET['suit'],$_GET['weight'],$data,2);
						}else{
							if($_GET['U']==$data2->thirdId){
								deleteCard($data2,$_GET['suit'],$_GET['weight'],3);
								addCard($_GET['suit'],$_GET['weight'],$data,3);
							}else{
								deleteCard($data2,$_GET['suit'],$_GET['weight'],4);
								addCard($_GET['suit'],$_GET['weight'],$data,4);
							}
						}
					}
					$f=false;
				}
			}	
		}
	}
	if($f){
		$d;
		switch ($name) {
			case 'forthPlayer':
				$d=$data->forthPlayer;
				break;
			case 'thirdPlayer':
				$d=$data->thirdPlayer;
				break;
			case 'secondPlayer':
				$d=$data->secondPlayer;
				break;
			case 'firstPlayer':
				$d=$data->firstPlayer;
				break;
			
		}
		if($d[0]->suit==$_GET['suit']){
			if($_GET['U']==$data2->firstId){
				deleteCard($data2,$_GET['suit'],$_GET['weight'],1);
				addCard($_GET['suit'],$_GET['weight'],$data,1);
			}else{
				if($_GET['U']==$data2->secondId){
					deleteCard($data2,$_GET['suit'],$_GET['weight'],2);
					addCard($_GET['suit'],$_GET['weight'],$data,2);
				}else{
					if($_GET['U']==$data2->thirdId){
						deleteCard($data2,$_GET['suit'],$_GET['weight'],3);
						addCard($_GET['suit'],$_GET['weight'],$data,3);
					}else{
						deleteCard($data2,$_GET['suit'],$_GET['weight'],4);
						addCard($_GET['suit'],$_GET['weight'],$data,4);
					}
				}
			}
		}else{
			if($_GET['suit']==$data->trump->suit){
				if($_GET['U']==$data2->firstId){
					deleteCard($data2,$_GET['suit'],$_GET['weight'],1);
					addCard($_GET['suit'],$_GET['weight'],$data,1);
				}else{
					if($_GET['U']==$data2->secondId){
						deleteCard($data2,$_GET['suit'],$_GET['weight'],2);
						addCard($_GET['suit'],$_GET['weight'],$data,2);
					}else{
						if($_GET['U']==$data2->thirdId){
							deleteCard($data2,$_GET['suit'],$_GET['weight'],3);
							addCard($_GET['suit'],$_GET['weight'],$data,3);
						}else{
							deleteCard($data2,$_GET['suit'],$_GET['weight'],4);
							addCard($_GET['suit'],$_GET['weight'],$data,4);
						}
					}
				}
			}else{
				if($_GET['suit']=='j'){
					$t=true;
					if($_GET['U']==$data2->firstId){
						for($i=0;$i<count($data2->firstPlayer);$i++){
							if($data2->firstPlayer[$i]->suit==$_GET['suit']){
								echo "errorGame";
								$t=false;
							}
						}
					}else{
						if($_GET['U']==$data2->secondId){
							for($i=0;$i<count($data2->secondId);$i++){
								if($data2->secondId[$i]->suit==$_GET['suit']){
									echo "errorGame";
									$t=false;
								}
							}
						}else{
							if($_GET['U']==$data2->thirdId){
								for($i=0;$i<count($data2->thirdId);$i++){
									if($data2->thirdId[$i]->suit==$_GET['suit']){
										echo "errorGame";
										$t=false;
									}
								}
							}else{
								for($i=0;$i<count($data2->forthPlayer);$i++){
									if($data2->forthPlayer[$i]->suit==$_GET['suit']){
										echo "errorGame";
										$t=false;
									}
								}
							}
						}
					}
					if($t){
						//Вопрос по джокеру
					}


				}else{
					if($_GET['U']==$data2->firstId){
						deleteCard($data2,$_GET['suit'],$_GET['weight'],1);
						addCard($_GET['suit'],$_GET['weight'],$data,1);
					}else{
						if($_GET['U']==$data2->secondId){
							deleteCard($data2,$_GET['suit'],$_GET['weight'],2);
							addCard($_GET['suit'],$_GET['weight'],$data,2);
						}else{
							if($_GET['U']==$data2->thirdId){
								deleteCard($data2,$_GET['suit'],$_GET['weight'],3);
								addCard($_GET['suit'],$_GET['weight'],$data,3);
							}else{
								deleteCard($data2,$_GET['suit'],$_GET['weight'],4);
								addCard($_GET['suit'],$_GET['weight'],$data,4);
							}
						}
					}
				}
			}
		}
	}	
	mysqli_close($link);
?>