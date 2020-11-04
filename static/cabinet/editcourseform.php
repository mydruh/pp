<?php 
$lang = "ru";
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT ct.* FROM courses_types ct
		ORDER BY type_order';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$types = $stmt->fetchAll();	
	   
$sql = 'SELECT c.* FROM courses c 
		WHERE c.course_id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$course = $stmt->fetch();	

$sql = 'SELECT id_type FROM courses_types_values WHERE id_course = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$tv = $stmt->fetchAll();	

if(!empty($tv)) foreach($tv as $key=>$value) {
	$typevalues[$key] = $value['id_type'];
}

$sql = 'SELECT cn.course_name, cn.cn_id, cn.isactive, cn.course_description FROM courses_names cn 
		WHERE cn.course_id = ? AND cn.lang_id = 1';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn_ru =  $stmt->fetch();	
$cn_ru['course_name'] = str_replace('"', '&quot;',$cn_ru['course_name']);

$sql = 'SELECT cn.course_name, cn.cn_id,cn.isactive, cn.course_description FROM courses_names cn 
		WHERE cn.course_id = ? AND cn.lang_id = 2';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn_kz =  $stmt->fetch();	
$cn_kz['course_name'] = str_replace('"', '&quot;',$cn_kz['course_name']);
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
?>
<form id = "editcourse" method = "POST" action = "editcourse.php"> 
	<input type = "hidden" name = "course_id" value = "<?php echo $_GET['id']?>">
	<div class = "form-group">
		<label for="edithours">Количество часов</label>
		<input type = "number" id = "#edithours" name = "hours" class = "form-control" placeholder = "Количество часов" value = "<?php echo $course['number of_hours']?>" required> 
	</div>
	
	<div class = "form-group">
	<label for="editprice">Цена</label>
		<input type = "number"  id = "#editprice" name = "price" class = "form-control" placeholder = "Цена" value = "<?php echo $course['course_price']?>" required> 
	</div>
	<div class = "form-group">
	<label for="editname_ru">Название курса</label>
		<input type = "text" id = "#editname_ru" name = "name_ru" class = "form-control" placeholder = "Название курса" value = "<?php echo $cn_ru['course_name']?>" required> 
	</div>
	
	<div class = "form-group">
	<label for="editdesc_ru">Описание</label>
		<textarea name = "desc_ru" id = "#editdesc_ru" class = "form-control" placeholder = "Описание"><?php echo $cn_ru['course_description']?></textarea>
	</div>
	<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "active_ru" value = "1" class="custom-control-input" id="editactive_ru" <?php if($cn_ru['isactive'] == '1') echo "checked"?>>
			<label class="custom-control-label" for="editactive_ru">Активный</label>
	</div>
	
	<div class = "form-group">
	<label for="editname_kz">Аты</label>
		<input type = "text" id = "#editname_kz"  name = "name_kz" class = "form-control" placeholder = "Аты"  value = "<?php echo $cn_kz['course_name']?>" required> 
	</div>
		
	<div class = "form-group">
	<label for="editdesc_kz">Сипаттау</label>
		<textarea name = "desc_kz" id = "#editdesc_kz"  class = "form-control" placeholder = "Сипаттау"><?php echo $cn_kz['course_description']?></textarea>
	</div>
	<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "active_kz" value = "1" class="custom-control-input" id="editactive_kz" <?php if($cn_kz['isactive'] == '1') echo "checked"?>>
			<label class="custom-control-label" for="editactive_kz">Активный</label>
	</div>
	
	<?php if(!empty($types)) foreach($types as $key=>$value) {?>
	<div class="custom-control custom-checkbox form-group">
		<input type="checkbox" name = "id_type[]" value = "<?php echo $value['id']?>" class="custom-control-input" 
		id="eid_type<?php echo $value['id']?>"<?php if(isset($typevalues)) if(in_array($value['id'], $typevalues)) echo ' checked'?>>
		<label class="custom-control-label" for="eid_type<?php echo $value['id']?>" 
		><?php echo $value['name_ru']?></label>
	</div>
	<?php }?>
	
	<div class = "form-group">
		<button type = "submit" class = "btn btn-outline-grey">Редактировать</button>
	</div>
	</form>
	
	<div class = "form-group">
		<button class = "btn btn-outline-grey deletecourse">Удалить</button>
	</div>
	<div class="alert alert-danger" id = "deletecoursealert" role="alert" style = "display:none"><p>Удалить курс?</p>
	<button type = "button"  id = "deletecourseconfirm" data-id = "<?php echo $_GET['id']?>" 
	class = "btn btn-sm btn-outline-red">Удалить</button>
	<button type = "button"  id = "canceldeletecourse"  class = "btn btn-sm btn-outline-green">Отмена</button>
	</div>