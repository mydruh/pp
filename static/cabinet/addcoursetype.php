<?php 
$lang = "ru";
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT MAX(type_order) AS lastorder FROM courses_types';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$lastorder = $stmt->fetchColumn(); 
$neworder = $lastorder + 1;	 
  
$sql = 'INSERT INTO courses_types (name_ru, name_kz, type_order) VALUES (?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['name_ru']), trim($_POST['name_kz']),$neworder]); 

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage(); 
   }
   header('Location:courses_typesform.php')
?>