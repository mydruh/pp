<?php 
 $data['message'] = 'Ошибка!';
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   

$sql = 'INSERT INTO campaigns_list ( id_mailing_list, id_campaign) 
VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET["id_mailing_list"], $_GET['id_camaign']]); 
$id = $conn->lastInsertId();
 $data['message'] = 'Данные занесены!';
$data['id'] = $id;
$data['success'] = true;
}

catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
  
	echo json_encode($data);
	
?>