<?php 

include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$number = 0;

foreach($_POST['ids'] as $key=>$value) {
	$number = $number + 1;
$sql = 'UPDATE courses SET course_number = ? WHERE course_id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$number, $value]); 
}
$data['success'] = true;
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   echo json_encode($data);
?>