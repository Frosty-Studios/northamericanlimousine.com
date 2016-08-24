<?php
echo "<h1>Admin Page (Here)</h1><br>";
$city = $_GET['city'];
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
$query = "SELECT * FROM `".$city."`";
$json = database($query);
echo json_encode($json);
?>
