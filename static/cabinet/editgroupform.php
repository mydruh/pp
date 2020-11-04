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

$sql = 'SELECT * FROM  groups 
		WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$group = $stmt->fetch();	

/*
$sql = 'SELECT * FROM courses_names WHERE isdeleted = 0 AND isactive = 1 ORDER BY lang_id, course_name';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn = $stmt->fetchAll();

if($group['isclass'] == '1') {
	$sql = 'SELECT id_cn FROM groups_courses_names WHERE id_group = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_GET['id']]); 
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$gcn = $stmt->fetchAll();
	$cgnalues = [];
	foreach($gcn as $key=>$value) {
		$cgnalues[$key] = $value['id_cn'];
	}
} else {
	$sql = 'SELECT id_cn FROM groups_courses_names WHERE id_group = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_GET['id']]); 
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$gcn = $stmt->fetch();
}
*/
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   } else {
	header('Location:loginform.php');
   }
?>

		  <h4>Редактировать группу</h4>
		 <form id = "editgroup" method = "post" action = "editgroup.php">
		 <input type = "hidden" name = "id" value = "<?php echo $_GET['id']?>">
		 <div class="form-group">
			<input type="text"  class="form-control" name = "name" 
			value = "<?php echo $group['name']?>" required placeholder = "Название">
			</div>

			<div class="form-group">
				<input type="number"  class="form-control" name = "min" 
				value = "<?php echo $group['min_students']?>" required placeholder = "Минимальное количество">
			</div>
			
			<div class="form-group">
				<input type="number"  class="form-control" name = "max" 
				value = "<?php echo $group['max_students']?>" required placeholder = "Максимальное количество">
			</div>
<!--
			<div class="custom-control custom-radio form-group">
			<input type="radio" name = "isclass" value = "1" class="custom-control-input" 
			id="editisclass" required <?php if($group['isclass'] == '1') echo "checked"?>>
			<label class="custom-control-label" for="editisclass">Постоянная группа (класс)</label>
			</div>
			
			<div class="custom-control custom-radio form-group">
			<input type="radio" name = "isclass" value = "0" class="custom-control-input" 
			id="editisnotclass" required <?php if($group['isclass'] == '0') echo "checked"?>>
			<label class="custom-control-label" for="editisnotclass">Для одного курса</label>
			</div>
			
			<div id = "editcn_class"  <?php if($group['isclass'] == '0') {?> style = "display:none"<?php }?>>
				<?php if(!empty($cn)) foreach($cn as $key=>$value) {?>
					<div class="custom-control custom-checkbox form-group">
					<input type="checkbox" name = "cn[]" value = "<?php echo $value['cn_id']?>" class="custom-control-input" 
					id="editcn<?php echo $key?>" <?php if($group['isclass'] == '1') 
						if(in_array($value['cn_id'],$cgnalues)) echo "checked"?>>
					<label class="custom-control-label" for="editcn<?php echo $key?>"><?php echo $value['course_name']?></label>
					</div>
				<?php }?>
			</div>
			
			<div id = "editcn_group"   <?php if($group['isclass'] == '1') {?> style = "display:none"<?php }?>>
				<?php if(!empty($cn)) foreach($cn as $key=>$value) {?>
					<div class="custom-control custom-radio form-group">
					<input type="radio" name = "cn" value = "<?php echo $value['cn_id']?>" 
					class="custom-control-input" id="editcng<?php echo $key?>"
					 <?php if($group['isclass'] == '0') 
						if($value['cn_id'] == $gcn['id_cn']) echo "checked"?>>
					<label class="custom-control-label" for="editcng<?php echo $key?>"><?php echo $value['course_name']?></label>
					</div>
				<?php }?>
			</div>
-->		
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
		<div class = "form-group">
		<button type = "button"  id = "deletegroup" data-id = "<?php echo $_GET['id']?>" class = "btn btn-sm btn-outline-red">Удалить</button> 
		</div>
		<div class="alert alert-danger" id = "deletealert" role="alert" style = "display:none">
		<p>Удалить курс?</p>
  		<button type = "button"  id = "deletegroupconfirm" data-id = "<?php echo $_GET['id']?>" class = "btn btn-sm btn-outline-red">Удалить</button> 
		 <button type = "button"  id = "cancel"  class = "btn btn-sm btn-outline-green">Отмена</button> 

		</div>