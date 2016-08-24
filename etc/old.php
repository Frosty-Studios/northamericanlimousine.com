<?php
echo 'Google API test<br><br>';
if($_GET['fx']&&$_GET['tx']){
	$fx = $_GET['fx'];
	$fy = $_GET['fy'];
	$tx = $_GET['tx'];
	$ty = $_GET['ty'];
	echo $fx . '<br>' . $fy . '<br>';
	echo $tx . '<br>' . $ty . '<br><br>';
	$api="AIzaSyBSh88g_lkYH74WZq_B63OAcwKOkxkV6cQ";

	echo '<br><br>Airport: ';
	echo airport($fx,$fy);

	//newark
	
	
	
	/*
	//json Google API
	$jsonurl='https://maps.googleapis.com/maps/api/geocode/json?latlng='.$fx.','.$fy.'&key='.$api;
	$json = file_get_contents($jsonurl);
	
	$jsonIterator = new RecursiveIteratorIterator(
	new RecursiveArrayIterator(json_decode($json, TRUE)),
	RecursiveIteratorIterator::SELF_FIRST);

	foreach ($jsonIterator as $key => $val) {
		if(is_array($val)) {
			echo "$key:<br>\n";
		} else {
            echo "$key => $val<br>\n";
        }
    }
*/



	
	echo '<br><br>';
	//PHP initializer
	$DBH = new PDO("mysql:host=localhost;dbname=limo", 'root', 'apple360');
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$STH = $DBH->query('SELECT * FROM airport');
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	while($row = $STH->fetch()){
		echo $row['airport'];
		echo '<br>';
	}
}

function airport($x,$y){
	if($x<40.691811480291 && $x>40.689113519708 && $y<-74.175252719708 && $y>-74.177950680292){
		return 'ewr';
	}
	
}

?>
<html>
<body>
<form action="index.php" method="get">
from:<br>
<input type="text" name="fx" value="40.6895">
<input type="text" name="fy" value="-74.1745">
<br>to:<br>
<input type="text" name="tx" value="40.6895">
<input type="text" name="ty" value="-74.1745"><br>
<input type="submit" value="Sumbit">
</form>

<?php echo '<br>finalTest';?>
</body>
</html>
