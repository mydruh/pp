<?php 
include '../config/db_connect.php';
if(isset($_POST['isclass'])) $isclass = $_POST['isclass']; else $isclass = 0;
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


$sql = 'INSERT INTO groups (name, min_students, max_students, isclass) VALUES (?,?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['name']),$_POST['min'],$_POST['max'], $isclass]); 
$id = $conn->lastInsertId();

/*
if($isclass == '1') {
	foreach($_POST['cn'] as $key=>$value) {
		$sql = 'INSERT INTO groups_courses_names (id_group, id_cn) VALUES (?,?)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$id, $value]); 
	}
} else {
	$sql = 'INSERT INTO groups_courses_names (id_group, id_cn) VALUES (?,?)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$id, $_POST['cn']]); 
}
*/
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   header('Location:groupsform.php');
   } else {
	header('Location:loginform.php');
   }
?>