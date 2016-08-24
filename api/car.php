<?php

//if statement detecting the request method.
//if so, pull data to update, delete, add
if($_GET['todo']=='update'){
	echo 'update';
}
if($_GET['todo']=='delete'){
	echo 'update';
}
if($_GET['todo']=='add'){
	echo 'update';
}

function database($query){
	//specify if we're exporting a list or the user specifies what they want to use
	$DBH = new PDO("mysql:host=localhost;dbname=limo", 'root', 'apple360');
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$STH = $DBH->query($query);
	//$STH->setFetchMode(PDO::FETCH_ASSOC);
	$j=0;
	while($row = $STH->fetch()){
		for($i=0;$i<5;$i++){
			$json[$j][$i] = $row[$i];
		}
		$j++;
	}
	return $json;
}

$query = "SELECT * FROM `cars`";
$json = database($query);
echo json_encode($json);



?>