<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
if($_GET['ingroup'] == '0') {
$sql = 'UPDATE groups_instances SET isdeleted = 1
		WHERE id_group = ? AND id_instance = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id_group'], $_GET['id']]); 
} else if($_GET['ingroup'] == '1') {
$sql = 'INSERT INTO groups_instances (id_group, id_instance) VALUES(?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id_group'], $_GET['id']]); 	
}
$data['success'] = true;
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