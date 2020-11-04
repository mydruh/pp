<?php 
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'INSERT INTO `applications`(`app_firstname`, `app_lastname`, 
`app_email`, `app_phone`, `app_course_name`, `app_date`) 
VALUES (?,?,?,?,?,NOW())';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST["firstname"],$_POST["lastname"],trim($_POST["email"]),
trim($_POST["phone"]), trim($_POST["coursename"])]); 
echo $conn->lastInsertId();
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   
   ?>