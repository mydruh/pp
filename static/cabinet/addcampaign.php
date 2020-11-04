<?php 
 
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   

$sql = 'INSERT INTO `campaigns`( `capmaign_name`) 
VALUES (?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST["campaign_name"])]); 

}

catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
  
header('Location:sendingform.php');	
	
?>