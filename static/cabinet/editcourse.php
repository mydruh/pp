<?php 
include '../config/db_connect.php';
if(isset($_POST['active_ru'])) $active_ru = $_POST['active_ru'] = 1; else $active_ru = 0;
if(isset($_POST['active_kz'])) $active_kz = $_POST['active_kz'] = 1; else $active_kz = 0;
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

	   
$sql = 'UPDATE `courses` SET `number of_hours` = ?,`course_price` = ?  
		WHERE course_id = ? ';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['hours'],$_POST['price'], $_POST['course_id']]); 


$sql = 'UPDATE `courses_names` SET  `course_name` = ?, `course_description` = ?, `isactive` = ? 
WHERE `course_id` = ? AND `lang_id` = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['name_ru'], $_POST['desc_ru'],$active_ru, $_POST['course_id'], 1]); 

$sql = 'UPDATE `courses_names` SET  `course_name` = ?, `course_description` = ?, `isactive` = ? 
WHERE `course_id` = ? AND `lang_id` = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['name_kz'], $_POST['desc_kz'],$active_kz, $_POST['course_id'], 2]); 

$sql = 'DELETE FROM courses_types_values WHERE id_course = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['course_id']]); 
if(isset($_POST['id_type'])) {
	foreach($_POST['id_type'] as $key=>$value) {
		$sql = 'INSERT INTO `courses_types_values`(`id_course`, `id_type`) 
				VALUES (?,?)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$_POST['course_id'], $value]); 
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