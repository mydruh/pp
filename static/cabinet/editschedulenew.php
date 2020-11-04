<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
if(isset($_POST['everyweek'])) $_POST['everyweek'] = 1; else $_POST['everyweek'] = 0;
$sql = 'UPDATE `course_schedule` SET `courses_names_id` = ?, `startdate` = ?, 
`enddate` = ?, `everyweek` = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['cn_id'], $_POST['startdate'],
$_POST['enddate'], $_POST['everyweek'], $_POST['id']]); 

$sql = 'DELETE FROM `courses_teachers`
WHERE course_id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['id']]); 	

if(isset($_POST['emp'])) foreach($_POST['emp'] as $key=>$value) {
$sql = 'INSERT INTO `courses_teachers`(`course_id`, `emp_pos_id`) 
VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['id'], $value]); 	
} else if(isset($_POST['description']) AND trim($_POST['description']) !== '') {
$sql = 'INSERT INTO `courses_teachers`(`course_id`, `description`) 
VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['id'], trim($_POST['description'])]); 
}

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