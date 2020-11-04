<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 
if(isset($_POST['bysubscription'])) $bysubscription = 1; else $bysubscription = 0;
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


$sql = 'UPDATE `course_instances` SET  `name` = ?, `bysubscription` = ?,
		`id_company` = ?, `telegram_chat` = ?
		WHERE `id` = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([trim($_POST['name']), $bysubscription,
	$_POST['id_company'],trim($_POST['telegram_chat']), $_POST['id']]); 
	
if($bysubscription == 0) {	
	$sql = 'UPDATE `course_instances` SET  `startdate` = ?, `enddate` = ?,
			WHERE `id` = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_POST['startdate'],$_POST['enddate'],
	 $_POST['id']]); 
}	
	$sql = 'DELETE FROM `teachers_instances` WHERE id_instance = ?';
		$stmt = $conn->prepare($sql);
	$stmt->execute([$_POST['id']]);

if(isset($_POST['emp'])) 
	foreach($_POST['emp'] as $key=>$value) {
		$sql = 'INSERT INTO `teachers_instances`(`id_teacher`, `id_instance`) 
		VALUES (?,?)';
		$stmt = $conn->prepare($sql);
	$stmt->execute([$value, $_POST['id']]);
	}

$data['success'] = true;
$data['name'] = trim($_POST['name']);

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   echo json_encode($data);
   } else {
	header('Location:loginform.php');
   }
?>