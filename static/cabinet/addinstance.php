<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
if(isset($_POST['bysubscription'])) $bysubscription = 1; else $bysubscription = 0;

$sql = 'INSERT INTO `course_instances`(`id_course_name`, `name`, `id_company` , `bysubscription`, `telegram_chat`) 
	VALUES (?,?,?,?,?)';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_POST['cn_id'], trim($_POST['name']),$_POST['id_company'],$bysubscription,trim($_POST['telegram_chat'])]); 
	
	
$id = $conn->lastInsertId();

if($bysubscription == 0) {
$sql = 'UPDATE `course_instances` SET `startdate` = ?, `enddate` = ? 
	WHERE id = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_POST['startdate'],$_POST['enddate'],$id]); 
}

if(isset($_POST['emp'])) 
	foreach($_POST['emp'] as $key=>$value) {
		$sql = 'INSERT INTO `teachers_instances`(`id_teacher`, `id_instance`) 
		VALUES (?,?)';
		$stmt = $conn->prepare($sql);
	$stmt->execute([$value, $id]);
	}

$data['success'] = true;
$data['html'] = '<tr>
<td>'.trim($_POST['name']).'</td>

<td><button class = "btn btn-sm btn-outline-grey my-0 editinstance" data-id = "'.$id.'">Редактировать</button></td>
<td><button class = "btn btn-sm btn-outline-grey my-0 deleteinstance" data-id = "'.$id.'">Удалить</button></td>
<td>
<div class="custom-control custom-checkbox">
	<input type="checkbox" name = "isopened" value = "1" data-id = "'.$id.'" class="custom-control-input isopened" 
	id="isopened'.$id.'">
	<label class="custom-control-label" for="isopened'.$id.'">Прием заявок</label>
</div>
</td>
</tr>';

}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   echo json_encode($data);
   } else {
	header('Location:index.php');
   }
?>