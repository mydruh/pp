<?php 
include '../config/db_connect.php';
if(isset($_GET['lang'])) $lang = $_GET['lang']; else $lang = 'kz';
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT cs.*, cn.course_name FROM  course_schedule cs 
		INNER JOIN courses_names cn ON cn.cn_id = cs.courses_names_id
		WHERE cs.id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$schedule = $stmt->fetch();	

$sql = 'SELECT e.*, ep.id AS epid FROM employees e 
		INNER JOIN emp_pos ep ON ep.id_emp = e.id 
		INNER JOIN positions p ON p.id = ep.id_position WHERE p.id = 1';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$teachers = $stmt->fetchAll();	


$sql = 'SELECT * FROM  courses_teachers 
		WHERE course_id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$theteachers = $stmt->fetchAll();	

$checked = [];
$checked[0] = 0;

$description = '';
if(!empty($theteachers)) {
	foreach($theteachers as $key=>$value) {
		
		$checked[$key] = $value['emp_pos_id'];
		if($value['description'] !== '') 
			$description = $value['description'];
	}
}


$sql = 'SELECT cn.* FROM  courses_names cn';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$courses_names = $stmt->fetchAll();	
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   } else {
	header('Location:loginform.php');
   }
?>

		  <h4>Редактировать расписание</h4>
		 <form id = "editscheduleform" method = "post" action = "editschedulenew.php">
		 <input type = "hidden" name = "id" value = "<?php echo $schedule['id']?>">
		 <div class="form-group">
		<select class="browser-default custom-select" name = "cn_id">
		<?php foreach($courses_names as $key=>$value) {?>
		<option value = "<?php echo $value['cn_id']?>" 
		<?php if($schedule['courses_names_id'] == $value['cn_id']) echo "selected"?>>
		<?php echo $value['course_name']?></option>
		<?php }?>
		</select>
		</div>	
			<div class="form-group">
			<input type="text"  id = "editstartdate" class="form-control" name = "startdate" 
			required placeholder = "Дата начала" value = "<?php echo $schedule['startdate']?>">
			</div>

			<div class="form-group">
				<input type="text"  id = "editenddate" class="form-control" name = "enddate" 
				required placeholder = "Дата окончания" value = "<?php echo $schedule['enddate']?>">
			</div>
			<div class = "form-group">
			<?php foreach($teachers as $key=>$value) {?> 
			<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" name = "emp[]" class="custom-control-input" 
			id="et<?php echo $value['id']?>" value = "<?php echo $value['epid']?>"
			<?php if(in_array($value['epid'], $checked)) echo "checked"?>>
			<label class="custom-control-label" for="et<?php echo $value['id']?>" value = "<?php echo $value['epid']?>">
			<?php echo $value['firstname'].' '.$value['lastname']?>
			</label>
			</div>
			<?php }?>
			</div>
			<div class = "form-group">
			<textarea name = "description" class = "form-control" placeholder = "Другое, например, 
Сотрудники Национальной Академии Образования им. Ы.Алтынсарина"><?php echo $description?></textarea>
			</div>
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
		<div class = "form-group">
		<button type = "button"  id = "deletecourse" data-id = "<?php echo $_GET['id']?>" class = "btn btn-sm btn-outline-red">Удалить</button> 
		</div>
		<div class="alert alert-danger" id = "deletealert" role="alert" style = "display:none">
		<p>Удалить курс?</p>
  		<button type = "button"  id = "deletecourseconfirm" data-id = "<?php echo $_GET['id']?>" class = "btn btn-sm btn-outline-red">Удалить</button> 
		 <button type = "button"  id = "cancel"  class = "btn btn-sm btn-outline-green">Отмена</button> 

		</div>