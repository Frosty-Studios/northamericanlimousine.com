<?php

if($_GET['fx']&&$_GET['tx']){
	$fx = $_GET['fx'];
	$fy = $_GET['fy'];
	$tx = $_GET['tx'];
	$ty = $_GET['ty'];
	//echo $fx . '<br>' . $fy . '<br>';
	//echo $tx . '<br>' . $ty . '<br><br>';
	

	
	$from = locationFactory::create($fx,$fy);
	$to = locationFactory::create($tx,$ty);
	$price = task($from,$to);
	echo $price;
	//print_r($from);
	//print_r($to);
	//echo $from->air;

}

function database($query,$data){
	//specify if we're exporting a list or the user specifies what they want to use
	$DBH = new PDO("mysql:host=localhost;dbname=limo", 'root', 'apple360');
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$STH = $DBH->query($query);
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	if($row = $STH->fetch()){
		return $row[$data];
	}else{
		//invoke the distance function here
		
	}
}


function task($from,$to){
	if($from->air!=null&&$to->air!=null){
		return airport($from,$to);
	}elseif($from->air!=null||$to->air!=null){
		if($from->air==null){
			return city($from,$to);
		}else{
			return city($to,$from);
		}
	}else{
		return distance($from,$to);
	}
}
function airport($from,$to){
	if($from->air==$to->air){
		echo 'both are same place';
		//output error code here
	}else{
		//confirm the pricing for where it's going to
		$query='SELECT * FROM airport where airport="'.$to->air.'"';
		$price=database($query,'sedan');
		return $price;
	}
}
function city($city,$air){
	$co=null;
    switch ($city->county) {
		case "Essex County":
			$co='essex';
			break;
		case "Bergen County":
			$co='bergen';
			break;
		case "Hudson County":
			$co='hudson';
			break;
		case "Morris County":
			$co='morris';
			break;
		case "Passaic County":
			$co='passaic';
			break;
		case "Rockland County":
			$co='rockland';
			break;
		case "Union County":
			$co='unionc';
			break;
		default:
			return distance($city,$air);
	}
	$query='SELECT * FROM '.$co.' WHERE city="'.$city->city.'"';
	return database($query,$air->air);
	echo $query;
}
function distance($from,$to){
		$api="AIzaSyBSh88g_lkYH74WZq_B63OAcwKOkxkV6cQ";
		$jsonurl='https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=' . $from->x . ',' . $from->y . '&destinations=' . $to->x . ',' . $to->y . '&key=' . $api;
		$json = file_get_contents($jsonurl);
		$obj = json_decode($json);
		$value = $obj->{'rows'}[0]->{'elements'}[0]->{'distance'}->{'text'};
		$price = preg_replace("/[^0-9,.]/", "", $value);
		return distcalc($price);
}
//distance calculation, may need to put in a query
function distcalc($in){
	return $in*2.75;
}
class location{
	public $x;
	public $y;
	public $air;
	public $city=null;
	public $county=null;
	public function __construct($x,$y){
		$this->x=$x;
		$this->y=$y;
		$this->air = $this::airp($this->x,$this->y);
		
	}
	function airp($x,$y){
		if($x<40.690880380292 && $x>40.688182419708 && $y<-74.173113419708 && $y>-74.175811380291){
			return 'ewr';
		}elseif($x<40.642660080291 && $x>40.639962119708 && $y<-73.776790119708 && $y>-73.779488080292){
			return 'jfk';
		}elseif($x<40.778276080291 && $x>40.775578119709 && $y<-73.872616919709 && $y>-73.875314880292){
			return 'lga';
		}elseif($x<40.850371480291 && $x>40.847673519709 && $y<-74.061604519708 && $y>-74.064302480292){
			return 'teb';
		}elseif($x<41.069681480292 && $x>41.066983519709 && $y<-73.707315119708 && $y>-73.710013080291){
			return 'hpn';
		}elseif($x<40.791194080291 && $x>40.788496119708 && $y<-73.096219019708 && $y>-73.098916980292){
			return 'isp';
		}else{
			$this::google($x,$y);
			return null;
		}
	}
	function google($x,$y){
		$api="AIzaSyBSh88g_lkYH74WZq_B63OAcwKOkxkV6cQ";
		$jsonurl='https://maps.googleapis.com/maps/api/geocode/json?latlng='.$x.','.$y.'&key='.$api.'&result_type=administrative_area_level_2|locality';
		$json = file_get_contents($jsonurl);
		$obj = json_decode($json);
		echo '<br>';
		
		$this->city = $obj->{'results'}[0]->{'address_components'}[0]->{'long_name'};
		$this->county = $obj->{'results'}[0]->{'address_components'}[1]->{'long_name'};
		echo '<br>city: ';
		echo $this->city;
		echo '<br>county: ';
		echo $this->county;
		
		echo '<br><br>';
		
	}
}

class locationFactory{
	public static function create($x,$y){
		return new location($x,$y);
	}
}
?>
<html>
<body>
<form action="index.php" method="get">
from:<br>
<input type="text" name="fx" value="40.6413">
<input type="text" name="fy" value="-73.7781">
<br>to:<br>
<input type="text" name="tx" value="40.6895">
<input type="text" name="ty" value="-74.1745"><br>
<input type="submit" value="Sumbit">
</form>

</body>
</html>
