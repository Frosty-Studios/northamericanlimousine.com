<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

$obj = new main();
  class main {

    public function __construct() {

      $page_request = 'table';
      if(isset($_REQUEST['page'])) {
        $page_request = $_REQUEST['page'];
      }
	   
      $page = new $page_request;
 
      if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $page->get();
      } else {
        $page->post();
      }

    }

  }

class page {
	
    public function get() {
      echo 'I am a get method page';
    }

    public function post() {
      echo 'i am a post method';
      print_r($_POST);
    }
}

class table extends page{
	public $arrays;
	public $csvfile='users.csv';
	
    public function __construct(){
		$csvfile='users.csv';
		$this->arrays= $this::readCSV($this->csvfile);
		echo 'Records VIew<br>';
	}
    public function get() {
		$this::tableFactory($this->arrays);
		echo '<br><form method="get" action="index.php">
		<input type="submit" name="page" value="add">
		</form>';
    }
	public function post(){
		if($_REQUEST['add']=='delete'){
			$this::delete();
		}elseif($_POST['id']==0){
			$this->arrays[]=$this::receive();
		}else{
			$this::modify();
		}
		$this::tableFactory($this->arrays);
		echo '<br><form method="get" action="index.php">
		<input type="submit" name="page" value="add">
		</form>';
	}
	public function receive(){
		$input[]= $_POST['first'];
		$input[]= $_POST['last'];
		$input[]= $_POST['email'];
		$output=userFactory::create($input);
		return $output;
	}
	public function delete(){
		$id = $_POST['id']-1;
		array_splice($this->arrays,$id,1);
	}
	public function modify(){
		$id = $_POST['id']-1;
		$this->arrays[$id]= $this::receive();
	}
	public function tableFactory($list){
		$id=1;
		echo '<br><table border="1">';
		echo '<tr><th>First Name</th><th>Last Name</th><th>Email Address</th></tr>';
		foreach($list as $row){
			echo '<tr>';
			foreach($row as $col){
				echo '<td>' . $col . '</td>';
				$data[]=$col;
			}
			echo '<td><form method="post" action="index.php">
			<input type="hidden" name="first" value="';
			echo $data[0];
			echo '"><input type="hidden" name="last" value="';
			echo $data[1];
			echo '"><input type="hidden" name="email" value="';
			echo $data[2];
			echo '"><input type="hidden" name="id" value="';
			echo $id;
			echo '"><input type="submit" name="page" value="edit">
			</form>';
			$id++;
			$data= array();
			echo '</td></tr>';
		}
		echo '</table>';
	}
	function readCSV($csvFile){
		$file = fopen($csvFile, 'r') or die('cant open file');
		while ($buffer=fgetcsv($file,1024)){
			$line_of_text[]= userFactory::create($buffer);
		}
		fclose($file);
		return $line_of_text;
	}
	
	function saveCSV($csvFile){
		$file = fopen($csvFile, 'w') or die('cant open file');
		foreach($this->arrays as $line){
			fputcsv($file,explode(',',$line->getAll()));
		}
		fclose($file);
	}
	
	public function __destruct(){
		$this::saveCSV($this->csvfile);
	}
}

class add extends page{
    public function get() {
		echo 'Submit Items <br>';
		echo '<br><form method="post" action="index.php">
		First Name <input type="text" name="first"><br>
		Last Name <input type="text" name="last"><br>
		Email Address <input type="text" name="email"><br>
		<input type="hidden" name="id" value="0">
		<input type="submit" name="add" value="Submit">
		</form>';
    }
}

class edit extends add{
    public function post() {
		echo 'Modify Items <br>';
		echo '<br><form method="post" action="index.php">
		First Name <input type="text" name="first" value="';
		echo $_POST['first'];
		echo '"><br> Last Name <input type="text" name="last" value="';
		echo $_POST['last'];
		echo '"><br> Email Address <input type="text" name="email" value="';
		echo $_POST['email'];
		echo '"><br> <input type="hidden" name="id" value="';
		echo $_POST['id'];
		echo '"><input type="submit" name="add" value="Submit">
		<input type="submit" name="add" value="delete">
		</form>';
    }
	
}

class users{
	public $first;
	public $last;
	public $email;
	public function __construct($f,$l,$e){
		$this->first=$f;
		$this->last=$l;
		$this->email=$e;
	}
	public function getAll(){
		return $this->first . ',' . $this->last . ',' . $this->email;
	}
}

class userFactory{
	public static function create($list){
		return new users($list[0],$list[1],$list[2]);
	}
}

?>
