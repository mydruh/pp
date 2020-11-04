<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'UPDATE `schedule` SET `startdate` = ?, `enddate` = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['startdate'],$_POST['enddate'],$_POST['schedule']]); 


$sql = 'UPDATE `schedule_names` SET  `schedule_name` = ? WHERE `schedule_id` =? AND `lang` = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['name_ru'], $_POST['schedule'],"ru"]); 

$sql = 'UPDATE `schedule_names` SET  `schedule_name` = ? WHERE `schedule_id` =? AND `lang` = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['name_kz'], $_POST['schedule'],"kz"]); 

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   header('Location:scheduleform.php');
   } else {
	header('Location:loginform.php');
   }
?>