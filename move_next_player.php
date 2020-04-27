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
	$query ="
	SELECT `tabel`
	FROM `room` 
	WHERE(`id`='".$_GET['id']."')";
	$result = mysqli_query($link, $query) or die("error"); 
	$data2=array();
	$row=mysqli_fetch_assoc($result);
	$data2=json_decode($row['tabel']);
	$playerMoveFirst=0;
	$winUser = array('firstPlayer' =>false ,'secondPlayer' =>false ,'thirdPlayer' =>false ,'forthPlayer' =>false  );
	$weight;
	$suit;
	if(($data2->firstPlayer[0]!=null)&&($data2->secondPlayer[0]==null)){
		$data2->move=$$data2->secondId;
		echo "string";
		$query ="
			UPDATE `room`
			set `tabel` ='".json_encode($data2)."'
			WHERE(`id`='".$_GET['id']."')";
			echo $query;
		$result = mysqli_query($link, $query) or die("error"); 

		die();
	}
	if(($data2->secondPlayer[0]!=null)&&($data2->thirdPlayer[0]==null)){
		$data2->move=$data2->thirdId;
		echo "string";
		$query ="
			UPDATE `room`
			set `tabel` ='".json_encode($data2)."'
			WHERE(`id`='".$_GET['id']."')";
			echo $query;
		$result = mysqli_query($link, $query) or die("error"); 

		die();
	}
	if(($data2->thirdPlayer[0]!=0)&&($data2->forthPlayer[0]==null)){
		$data2->move=$data2->forthId;
		echo "string";
		$query ="
			UPDATE `room`
			set `tabel` ='".json_encode($data2)."'
			WHERE(`id`='".$_GET['id']."')";
			echo $query;
		$result = mysqli_query($link, $query) or die("error");

		die(); 
	}
	if(($data2->forthPlayer[0]!=0)&&($data2->firstPlayer[0]==null)){
		$data2->move=$data2->firstId;
		echo "string";
		$query ="
			UPDATE `room`
			set `tabel` ='".json_encode($data2)."'
			WHERE(`id`='".$_GET['id']."')";
			echo $query;
		$result = mysqli_query($link, $query) or die("error"); 

		die();
	}
	for($i=0;$i<count($data);$i++){
		if($data[$i]==$data2->move){
			if($i==3){
				if($data2->move==$data2->firstId){
					$weight=$data2->secondPlayer[0]->weight;
					$suit=$data2->secondPlayer[0]->suit;
				}else{
					if($data2->move==$data2->secondId){
						$weight=$data2->thirdPlayer[0]->weight;
						$suit=$data2->thirdPlayer[0]->suit;
					}else{
						if($data2->move==$data2->thirdId){	
							$weight=$data2->forthPlayer[0]->weight;
							$suit=$data2->forthPlayer[0]->suit;
						}else{
							$weight=$data2->firstPlayer[0]->weight;
							$suit=$data2->firstPlayer[0]->suit;
						}
					}
				}
				if($suit==$data2->firstPlayer[0]->suit){
					if($weight<=$data2->firstPlayer[0]->weight){
						$suit=$data2->firstPlayer[0]->suit;
						$weight=$data2->firstPlayer[0]->weight;
						if($suit==$data2->secondPlayer[0]->suit){
							if($weight<=$data2->secondPlayer[0]->weight){
								$suit=$data2->secondPlayer[0]->suit;
								$weight=$data2->secondPlayer[0]->weight;
								if($suit==$data2->thirdPlayer[0]->suit){
									if($weight<=$data2->thirdPlayer[0]->weight){
										$suit=$data2->thirdPlayer[0]->suit;
										$weight=$data2->thirdPlayer[0]->weight;
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}
									}
								}else{
									if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
										$winUser['thirdPlayer']=true;
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}
									}
								}
							}else{
								if($suit==$data2->thirdPlayer[0]->suit){
									if($weight<=$data2->thirdPlayer[0]->weight){
										$suit=$data2->thirdPlayer[0]->suit;
										$weight=$data2->thirdPlayer[0]->weight;
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}
									}
								}else{
									if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
										$winUser['thirdPlayer']=true;
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}
									}
								}
							}
						}else{
							if($suit==$data2->thirdPlayer[0]->suit){
								if($weight<=$data2->thirdPlayer[0]->weight){
									$suit=$data2->thirdPlayer[0]->suit;
									$weight=$data2->thirdPlayer[0]->weight;
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}
								}
							}else{
								if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
									$winUser['thirdPlayer']=true;
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}
								}
							}
						}
					}else{
						if($suit==$data2->secondPlayer[0]->suit){
							if($weight<=$data2->secondPlayer[0]->weight){
								$suit=$data2->secondPlayer[0]->suit;
								$weight=$data2->secondPlayer[0]->weight;
								if($suit==$data2->thirdPlayer[0]->suit){
									if($weight<=$data2->thirdPlayer[0]->weight){
										$suit=$data2->thirdPlayer[0]->suit;
										$weight=$data2->thirdPlayer[0]->weight;
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}
									}
								}else{
									if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
										$winUser['thirdPlayer']=true;
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['secondPlayer']=true;
											}
										}
									}
								}
							}else{
								if($suit==$data2->thirdPlayer[0]->suit){
									if($weight<=$data2->thirdPlayer[0]->weight){
										$suit=$data2->thirdPlayer[0]->suit;
										$weight=$data2->thirdPlayer[0]->weight;
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['thirdPlayer']=true;
											}
										}
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}
									}
								}else{
									if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
										$winUser['thirdPlayer']=true;
									}else{
										if($suit==$data2->forthPlayer[0]->suit){
											if($weight<=$data2->forthPlayer[0]->weight){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}else{
											if($data2->trump->suit==$data2->forthPlayer[0]->suit){
												$winUser['forthPlayer']=true;
											}else{
												$winUser['firstPlayer']=true;
											}
										}
									}
								}
							}
						}else{
							if($suit==$data2->thirdPlayer[0]->suit){
								if($weight<=$data2->thirdPlayer[0]->weight){
									$suit=$data2->thirdPlayer[0]->suit;
									$weight=$data2->thirdPlayer[0]->weight;
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}
								}
							}else{
								if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
									$winUser['thirdPlayer']=true;
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}
								}
							}
							
						}
					}
				}else{
					if($suit==$data2->secondPlayer[0]->suit){
						if($weight<=$data2->secondPlayer[0]->weight){
							$suit=$data2->secondPlayer[0]->suit;
							$weight=$data2->secondPlayer[0]->weight;
							if($suit==$data2->thirdPlayer[0]->suit){
								if($weight<=$data2->thirdPlayer[0]->weight){
									$suit=$data2->thirdPlayer[0]->suit;
									$weight=$data2->thirdPlayer[0]->weight;
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['secondPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['secondPlayer']=true;
										}
									}
								}
							}else{
								if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
									$winUser['thirdPlayer']=true;
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['secondPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['secondPlayer']=true;
										}
									}
								}
							}
						}else{
							if($suit==$data2->thirdPlayer[0]->suit){
								if($weight<=$data2->thirdPlayer[0]->weight){
									$suit=$data2->thirdPlayer[0]->suit;
									$weight=$data2->thirdPlayer[0]->weight;
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['thirdPlayer']=true;
										}
									}
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}
								}
							}else{
								if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
									$winUser['thirdPlayer']=true;
								}else{
									if($suit==$data2->forthPlayer[0]->suit){
										if($weight<=$data2->forthPlayer[0]->weight){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}else{
										if($data2->trump->suit==$data2->forthPlayer[0]->suit){
											$winUser['forthPlayer']=true;
										}else{
											$winUser['firstPlayer']=true;
										}
									}
								}
							}
						}
					}else{
						if($suit==$data2->thirdPlayer[0]->suit){
							if($weight<=$data2->thirdPlayer[0]->weight){
								$suit=$data2->thirdPlayer[0]->suit;
								$weight=$data2->thirdPlayer[0]->weight;
								if($suit==$data2->forthPlayer[0]->suit){
									if($weight<=$data2->forthPlayer[0]->weight){
										$winUser['forthPlayer']=true;
									}else{
										$winUser['thirdPlayer']=true;
									}
								}else{
									if($data2->trump->suit==$data2->forthPlayer[0]->suit){
										$winUser['forthPlayer']=true;
									}else{
										$winUser['thirdPlayer']=true;
									}
								}
							}else{
								if($suit==$data2->forthPlayer[0]->suit){
									if($weight<=$data2->forthPlayer[0]->weight){
										$winUser['forthPlayer']=true;
									}else{
										$winUser['firstPlayer']=true;
									}
								}else{
									if($data2->trump->suit==$data2->forthPlayer[0]->suit){
										$winUser['forthPlayer']=true;
									}else{
										$winUser['firstPlayer']=true;
									}
								}
							}
						}else{
							if($data2->trump->suit==$data2->thirdPlayer[0]->suit){
								$winUser['thirdPlayer']=true;
							}else{
								if($suit==$data2->forthPlayer[0]->suit){
									if($weight<=$data2->forthPlayer[0]->weight){
										$winUser['forthPlayer']=true;
									}else{
										$winUser['firstPlayer']=true;
									}
								}else{
									if($data2->trump->suit==$data2->forthPlayer[0]->suit){
										$winUser['forthPlayer']=true;
									}else{
										$winUser['firstPlayer']=true;
									}
								}
							}
						}
					}
				}
				if($winUser['firstPlayer']){
					$query ="
						SELECT `bribeCount`
						From `users`
						WHERE(`id`='".$data2->firstId."')";
					$result = mysqli_query($link, $query) or die("error"); 
					$row=mysqli_fetch_assoc($result);
					$query ="
						UPDATE `users`
						SET `bribeCount`=".($row['bribeCount']+1)."
						WHERE(`id`='".$data2->firstId."')";
					$result = mysqli_query($link, $query) or die("error"); 

				}else{
					if($winUser['secondPlayer']){
						$query ="
							SELECT `bribeCount`
							From `users`
							WHERE(`id`='".$data2->secondId."')";
						$result = mysqli_query($link, $query) or die("error"); 
						$row=mysqli_fetch_assoc($result);
						$query ="
							UPDATE `users`
							SET `bribeCount`=".($row['bribeCount']+1)."
							WHERE(`id`='".$data2->secondId."')";
						$result = mysqli_query($link, $query) or die("error"); 

					}else{
						if($winUser['thirdPlayer']){
							$query ="
								SELECT `bribeCount`
								From `users`
								WHERE(`id`='".$data2->thirdId."')";
							$result = mysqli_query($link, $query) or die("error"); 
							$row=mysqli_fetch_assoc($result);
							$query ="
								UPDATE `users`
								SET `bribeCount`=".($row['bribeCount']+1)."
								WHERE(`id`='".$data2->thirdId."')";
							$result = mysqli_query($link, $query) or die("error"); 

						}else{
							$query ="
								SELECT `bribeCount`
								From `users`
								WHERE(`id`='".$data2->forthId."')";
							$result = mysqli_query($link, $query) or die("error"); 
							$row=mysqli_fetch_assoc($result);
							$query ="
								UPDATE `users`
								SET `bribeCount`=".($row['bribeCount']+1)."
								WHERE(`id`='".$data2->forthId."')";
							$result = mysqli_query($link, $query) or die("error"); 
						}
					}
				}
			}else{
				$data2->move=$data[$i+1];
				echo "string";
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