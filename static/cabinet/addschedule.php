<?php 
include '../config/db_connect.php';
if(isset($_GET['lang'])) $lang = $_GET['lang']; else $lang = 'kz';
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'INSERT INTO `schedule`(`startdate`, `enddate`) VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['startdate'],$_POST['enddate']]); 
$id = $conn->lastInsertId();

$sql = 'INSERT INTO `schedule_names`( `schedule_id`, `schedule_name`, `lang`) 
		VALUES (?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$id,$_POST['name_ru'],"ru"]); 

$sql = 'INSERT INTO `schedule_names`( `schedule_id`, `schedule_name`, `lang`) 
		VALUES (?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$id,$_POST['name_kz'],"kz"]); 

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