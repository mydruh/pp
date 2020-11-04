<?php 
include 'config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT id FROM mailing_list WHERE email = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST["email"])]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$check = $stmt->fetch();	
if(isset($check['id']))  $data['message'] = 'Пользователь уже существует!';
else {
$sql = 'INSERT INTO `mailing_list`( `email`) 
VALUES (?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST["email"])]); 	
} 
$id = $conn->lastInsertId();

 $data['success'] = true;
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
 echo json_encode($data);  
   ?>