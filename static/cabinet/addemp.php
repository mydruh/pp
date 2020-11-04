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


$sql = 'INSERT INTO `employees`(`firstname`, `secondname`, `lastname`) VALUES (?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['firstname']),trim($_POST['secondname']),trim($_POST['lastname'])]); 
$id = $conn->lastInsertId();

$sql = 'INSERT INTO `emp_pos`(`id_position`, `id_emp`) VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['id_position'], $id]); 

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   header('Location:employeesform.php');
   } else {
	header('Location:loginform.php');
   }
?>