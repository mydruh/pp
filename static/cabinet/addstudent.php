<?php 
 $data['message'] = 'Ошибка!';
include '../config/db_connect.php';
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

$sql = 'INSERT INTO `mailing_list`( `email`, `phone`, `firstname`, `lastname`) 
VALUES (?,?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST["email"]), trim($_POST["phone"]), trim($_POST["firstname"]),
trim($_POST["lastname"])]); 
$id = $conn->lastInsertId();
 $data['message'] = 'Данные занесены!';
$data['id'] = $id;
}
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
  
	echo json_encode($data);
	
?>