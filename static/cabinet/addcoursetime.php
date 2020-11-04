<?php 
include '../config/db_connect.php';

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

if($_POST['action'] == 'add') {
	   
$sql = 'INSERT INTO `schedule_times`(`course_schedule_id`, `day`, `starttime`, `endtime`) 
		VALUES (?,?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['id'],$_POST['day'], $_POST['starttime'],$_POST['endtime']]); 
$id = $conn->lastInsertId();

$data['html'] = '<span>'.$_POST['starttime'].' - '.$_POST['endtime'].'
		<a href = "#" class = "edittime" data-id = "'.$id.'" 
		data-starttime = "'.$_POST["starttime"].'"
		data-endtime = "'.$_POST["endtime"].'"><i class="fas fa-edit mx-2"></i></a>
		<a href = "#" class = "removetime" data-id = "'.$id.'">
		<i class="fas fa-trash mx-2"></i></a></span>';
} else if($_POST['action'] == 'update') {
	$sql = 'UPDATE `schedule_times` SET `starttime` = ?, `endtime` = ? 
			WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['starttime'],$_POST['endtime'],$_POST['id']]); 
$data['html'] = $_POST['starttime'].' - '.$_POST['endtime'].'
		<a href = "#" class = "edittime" data-id = "'.$_POST['id'].'" 
		data-starttime = "'.$_POST["starttime"].'"
		data-endtime = "'.$_POST["endtime"].'"><i class="fas fa-edit mx-2"></i></a>
		<a href = "#" class = "removetime" data-id = "'.$_POST['id'].'">
		<i class="fas fa-trash mx-2"></i></a>';

}
$data['success'] = true; 
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   echo json_encode($data);
   
 
	
?>