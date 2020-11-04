<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT s.*, s.id AS sid FROM  schedule s WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$schedule = $stmt->fetch();	





	$date = new DateTime($schedule['startdate']); 
	$beginstring = $date->format('Y-m-d');  
	$schedule['startdate'] = $date->format('d.m.Y');
	
	$date = new DateTime($schedule['enddate']); 
	$endstring  = $date->format('Y-m-d');    
	$schedule['enddate'] = $date->format('d.m.Y');
	
	
	$sql = 'SELECT `schedule_name` FROM `schedule_names` 
			WHERE schedule_id = '.$schedule['sid'].' AND lang = "ru"';
			$stmt = $conn->prepare($sql);
			$stmt->execute(); 
			$stmt->setFetchMode(PDO::FETCH_ASSOC); 
			$name = $stmt->fetch();	
			$schedule['name_ru'] = $name['schedule_name'];
			
			
			
			$sql = 'SELECT `schedule_name` FROM `schedule_names` 
			WHERE schedule_id = ? AND lang = "kz"';
			$stmt = $conn->prepare($sql);
			$stmt->execute([$schedule['sid']]); 
			$stmt->setFetchMode(PDO::FETCH_ASSOC); 
			$name = $stmt->fetch();	
			
			$schedule['name_kz'] = $name['schedule_name'];

$begin = new DateTime($beginstring);
$end = new DateTime($endstring);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ($period as $dt) {
    echo $dt->format("Y-m-d").'<br>';
}

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   } else {
	header('Location:loginform.php');
   }
?>
<h4 class = "text-center">
<?php echo $schedule['name_ru'].' / '.$schedule['name_kz']?>
</h4>
<h5 class = "text-center">
<?php echo $schedule['startdate'].' - '.$schedule['enddate']?>
</h5>

