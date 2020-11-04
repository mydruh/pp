<?php 
include '../config/db_connect.php';
if(isset($_POST['isclass'])) $isclass = 1; else $isclass = 0;
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'UPDATE groups SET name = ?, min_students = ?, 
max_students = ?, isclass = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['name']), $_POST['min'],
$_POST['max'], $isclass, $_POST['id']]); 

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