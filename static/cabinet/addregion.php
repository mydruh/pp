<?php 
include '../config/db_connect.php';
if(isset($_GET['lang'])) $lang = $_GET['lang']; else $lang = 'kz';
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 2) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


$sql = 'INSERT INTO `regions`(`rname_ru`, `rname_kz`) VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['name_ru']),trim($_POST['name_kz'])]); 
$id = $conn->lastInsertId();


}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   header('Location:regions.php');
   } else {
	header('Location:loginform.php');
   }
?>