<?php 
include '../config/db_connect.php';


try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT * FROM  courses_names';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn = $stmt->fetchAll();	

foreach($cn as $key=>$value) {
	$sql = 'INSERT INTO `course_instances`(`id_course_name`, `name_kz`, `name_ru`) 
	VALUES (?,?,?)';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$value['cn_id'], 'Алғашқы ағын', 'Первый поток']); 
}

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage(); 
   }
   
?>