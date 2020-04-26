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
		var $move;
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
		function gameClass($round,$trump,$firstId,$secondId,$thirdId,$forthId,$firstPlayer,$secondPlayer,$thirdPlayer,$forthPlayer,$move){
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
 			$this->move=$move;
		}
	}

	function distributionCards($col,$cards,$id1,$id2,$id3,$id4,$round){
		$firstPlayer =array();
		$secondPlayer=array();
		$thirdPlayer =array();
		$forthPlayer =array();
		$j=1;
		$f=true;
		$weight=14;
		$id=0;
		for($i=0;$i<$col;$i++){
			$firstPlayer[$i]=$cards[$j];
			$j++;
			$secondPlayer[$i]=$cards[$j];
			$j++;
			$thirdPlayer[$i]=$cards[$j];
			$j++;
			$forthPlayer[$i]=$cards[$j];
			$j++;
			if($cards->suit!='j'){
				if($firstPlayer[$i]->suit==$cards[0]->suit){
					if($weight>$firstPlayer[$i]->weight){
						$weight=$firstPlayer[$i]->weight;
						$id=$id1;
					}
				}
				if($secondPlayer[$i]->suit==$cards[0]->suit){
					if($weight>$secondPlayer[$i]->weight){
						$weight=$secondPlayer[$i]->weight;
						$id=$id2;
					}
				}
				if($thirdPlayer[$i]->suit==$cards[0]->suit){
					if($weight>$thirdPlayer[$i]->weight){
						$weight=$thirdPlayer[$i]->weight;
						$id=$id3;
					}
				}
				if($forthPlayer[$i]->suit==$cards[0]->suit){
					if($weight>$forthPlayer[$i]->weight){
						$weight=$forthPlayer[$i]->weight;
						$id=$id4;
					}
				}
			}
		}

		switch (rand(0,3)) {
			case 0:
				$id=$id1;
				break;
			case 1:
				$id=$id2;
				break;
			case 2:
				$id=$id3;
				break;
			case 3:
				$id=$id4;
				break;
		}
		return json_encode(new gameClass($round,$cards[0],$id1,$id2,$id3,$id4,$firstPlayer,$secondPlayer,$thirdPlayer,$forthPlayer,$id));
	}

	$cards=array(
		new card('d',6),
		new card('d',7),
		new card('d',8),
		new card('d',9),
		new card('d',10),
		new card('d',11),
		new card('d',12),
		new card('d',13),
		new card('d',14),
		new card('j',''),
		new card('c',7),
		new card('c',8),
		new card('c',9),
		new card('c',10),
		new card('c',11),
		new card('c',12),
		new card('c',13),
		new card('c',14),
		new card('h',6),
		new card('h',7),
		new card('h',8),
		new card('h',9),
		new card('h',10),
		new card('h',11),
		new card('h',12),
		new card('h',13),
		new card('h',14),
		new card('j',''),
		new card('s',7),
		new card('s',8),
		new card('s',9),
		new card('s',10),
		new card('s',11),
		new card('s',12),
		new card('s',13),
		new card('s',14),
		);
	shuffle($cards);
	$host = 'localhost'; 
	$database = 'JokerGame'; 
	$user = 'mysql'; 
	$password = 'mysql';
	$i=0;
	$link = mysqli_connect($host, $user, $password, $database) or die("error");
	$query ="
			SELECT Round
			FROM `room` 
			WHERE id=".$_GET['id'];
	$result = mysqli_query($link, $query) or die("error"); 

	$query2 ="
		SELECT `users`.id
		FROM `users` 
		inner join `room` on(`users`.`room_id`=`room`.id)
		WHERE (`room`.id=".$_GET['id'].") ";
	$result2 = mysqli_query($link, $query2) or die("error"); 
	$data=array();
	while ($row=mysqli_fetch_assoc($result2)) {
		$data[]=$row;
	}
	while ($row=mysqli_fetch_assoc($result)) {
		if($row['Round']!=$_GET['Round']){
			switch ($_GET['Round']) {
				case 19:case 0:
					$query3="UPDATE `room` SET `cards`='".distributionCards(1,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error"); 

					break;
				case 18:case 1:
					$query3="UPDATE `room` SET `cards`='". distributionCards(2,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error"); 
					break;
				case 17:case 2:
					$query3="UPDATE `room` SET `cards`='".  distributionCards(3,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error");
					break;
				case 16:case 3:
					$query3="UPDATE `room` SET `cards`='".  distributionCards(4,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error");
					break;
				case 15:case 4:
					$query3="UPDATE `room` SET `cards`='".  distributionCards(5,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error");
					break;
				case 14:case 5:
					$query3="UPDATE `room` SET `cards`='".  distributionCards(6,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error");
					break;
				case 13:case 6:
					$query3="UPDATE `room` SET `cards`='".  distributionCards(7,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error");
					break;
				case 12:case 7:
					$query3="UPDATE `room` SET `cards`='".  distributionCards(8,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error");
					break;
				case 20:case 21:case 22:case 23:case 8:case 9:case 10:case 11:
					$query3="UPDATE `room` SET `cards`='".  distributionCards(9,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
					$result3 = mysqli_query($link, $query3) or die("error");
					break;	
				case 24:
					break;		
			}
		}
	}	

	$query3="UPDATE `room` SET `tabel`='".distributionCards(0,$cards,$data[0]['id'],$data[1]['id'],$data[2]['id'],$data[3]['id'],$row['Round'])."', `Round`=".($_GET['Round']+1)."  WHERE (`id`=".$_GET['id'].")"; 
	$result3 = mysqli_query($link, $query3) or die("error"); 

	mysqli_close($link);


?>
