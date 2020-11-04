<?php 
$lang = "ru";
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

  
$sql = 'DELETE FROM courses_types WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 

$sql = 'DELETE FROM courses_types_values WHERE id_type = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   $data['success'] = true;
   echo json_encode($data);
?>