<?php 
include '../config/db_connect.php';
$lang = 'ru';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'UPDATE applications SET ispaid = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['ispaid'],$_GET['id']]); 
$data['success'] = true;

$sql = 'SELECT id_instance FROM applications_instances WHERE id_application = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$instances = $stmt->fetchAll();

foreach($instances as $key=>$value) {
	$ins[$key] = $value['id_instance'];
}
$data['instances'] = json_encode($ins);

if($_GET['ispaid'] == '0') $data['paid'] = 0; else 	$data['paid'] = 1;
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
 echo json_encode($data);
   ?>