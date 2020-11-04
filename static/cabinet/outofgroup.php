<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 



$sql = 'DELETE FROM groups_clients WHERE id_client = ? AND id_group = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id'], $_GET['group']]); 

$data['success'] = true;
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   } 
   echo json_encode($data);
   } else {
	$data['success'] = false;
	 echo json_encode($data);
   }
?>