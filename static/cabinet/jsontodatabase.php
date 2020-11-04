<?php 
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   

$data['message'] = 'Error'; 
$jsonString = $_POST['json'];

$json = json_decode($jsonString, true);
$count = 0;
foreach($json as $key=>$value) if (filter_var(trim($value["email"]), FILTER_VALIDATE_EMAIL)) {
	$sql = 'SELECT id FROM mailing_list WHERE email = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($value["email"])]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$check = $stmt->fetch();	
if(isset($check['id']))  $data['message'] = 'Пользователь уже существует!';
else {
if(isset($value["phone"])) {
$sql = 'INSERT INTO `mailing_list`( `email`, `phone`) 
VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($value["email"]),trim($value["phone"])]); 
} else {
$sql = 'INSERT INTO `mailing_list`( `email`) 
VALUES (?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($value["email"])]); 	
}
$id = $conn->lastInsertId();
$count = $count +1;
$data['count'] = $count;
 $data['message'] = 'Данные занесены!';
$data['id'] = $id;
}

}
echo  $data['count']; 

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
?>