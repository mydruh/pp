<?php 
include '../config/db_connect.php';
if(isset($_POST['active_ru'])) $active_ru = $_POST['active_ru'] = 1; else $active_ru = 0;
if(isset($_POST['active_kz'])) $active_kz = $_POST['active_kz'] = 1; else $active_kz = 0;
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT MAX(course_number) AS lastorder FROM courses;';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$lastorder = $stmt->fetchColumn(); 
$neworder = $lastorder + 1;
	   
$sql = 'INSERT INTO `courses`(`number of_hours`,`course_price`,`course_number`) VALUES (?, ?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['hours'],$_POST['price'], $neworder]); 

$course_id = $conn->lastInsertId();

$sql = 'INSERT INTO `courses_langs`(`course_id`, `lang_id`) VALUES (?,1)';
$stmt = $conn->prepare($sql);
$stmt->execute([$course_id]); 
$sql = 'INSERT INTO `courses_langs`(`course_id`, `lang_id`) VALUES (?,2)';
$stmt = $conn->prepare($sql);
$stmt->execute([$course_id]); 

$sql = 'INSERT INTO `courses_names`(`course_id`, `lang_id`, `course_name`, `course_description`, `isactive`) 
VALUES (?,1,?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$course_id, $_POST['name_ru'],$_POST['desc_ru'], $active_ru]); 

$sql = 'INSERT INTO `courses_names`(`course_id`, `lang_id`, `course_name`, `course_description`, `isactive`) 
VALUES (?, 2,?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$course_id, $_POST['name_kz'],$_POST['desc_kz'],$active_kz]); 

if(isset($_POST['id_type'])) {
	foreach($_POST['id_type'] as $key=>$value) {
		$sql = 'INSERT INTO `courses_types_values`(`id_course`, `id_type`) 
				VALUES (?,?)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$course_id, $value]); 
	}
}
$data['success'] = true;
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   echo json_encode($data);
?>