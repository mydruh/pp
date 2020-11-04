<?php 
include '../config/db_connect.php';
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT course_name, cn_id FROM   courses_names 
		WHERE course_id = ? AND isdeleted = 0';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn = $stmt->fetchAll();

$sql = 'SELECT * FROM  companies';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$companies = $stmt->fetchAll();	

foreach($companies as $key=>$value) {
	$sql = 'SELECT e.*, ep.id AS epid FROM employees e 
		INNER JOIN emp_pos ep ON ep.id_emp = e.id 
		INNER JOIN positions p ON p.id = ep.id_position WHERE p.id = 1 AND p.id_company = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$value['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$teachers[$key] = $stmt->fetchAll();		
}

foreach($cn as $key=>$value) {
$sql = 'SELECT * FROM   course_instances  
		WHERE id_course_name = ? AND isdeleted = 0 ORDER BY id DESC';
$stmt = $conn->prepare($sql);
$stmt->execute([$value['cn_id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$instances[$key] = $stmt->fetchAll();	
}




}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage(); 
   }
 } else {
	header('Location:loginform.php');
   }  
?>
<h4>Добавить поток</h4>
<form id = "addinstance">
<input type = "hidden" name = "id" value = "<?php echo $_GET['id']?>">
		<div class="form-group">
			<input type="text"  class="form-control" name = "name" 
			 required placeholder = "Название">
		</div>
		
		<?php foreach($cn as $key=>$value) {?>
		<div class="custom-control custom-radio form-group">
			<input type="radio" name = "cn_id" value = "<?php echo $value['cn_id']?>" class="custom-control-input" 
			id="cn<?php echo $key?>">
			<label class="custom-control-label" for="cn<?php echo $key?>"><?php echo $value['course_name']?></label>
		</div>
		
		<?php }?>
		<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "bysubscription" class="custom-control-input" id="bysubscription" value = "1">
			<label class="custom-control-label" for="bysubscription">
			Начало по мере записи
			</label>
			</div>
			<div id = "dates">
		<div class="form-group">
			<input type="text"  id = "startdate" class="form-control" name = "startdate" required placeholder = "Дата начала">
			</div>

			<div class="form-group">
				<input type="text"  id = "enddate" class="form-control" name = "enddate" required placeholder = "Дата окончания">
			</div>
			</div>
<?php foreach($companies as $key=>$value) {?>
	<div class="custom-control custom-radio form-group">
			<input type="radio" name = "id_company" value = "<?php echo $value['id']?>" 
			class="custom-control-input" id="id_company<?php echo $value['id']?>" required>
			<label class="custom-control-label" for="id_company<?php echo $value['id']?>">
			<?php echo $value['name_ru']?></label>
	</div>
	<?php }?>
	<?php foreach($companies as $key=>$value) {?>
	<div class = "teachers form-group" data-company = "<?php echo $value['id']?>" style = "display:none">
	<?php if(!empty($teachers[$key])) foreach($teachers[$key] as $k=>$v) {?>
			<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" name = "emp[]" class="custom-control-input" id="t<?php echo $v['id']?>" value = "<?php echo $v['epid']?>">
			<label class="custom-control-label" for="t<?php echo $v['id']?>">
			<?php echo $v['firstname'].' '.$v['lastname']?>
			</label>
			</div>
			<?php }?>
	</div>
	<?php }?>
	
	<div class="form-group">
			<input type="text"  class="form-control" name = "telegram_chat" 
			 placeholder = "Телеграм чат">
		</div>

		<div class = "form-group">
			<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
		</div>	
</form>
<?php foreach($cn as $key=>$value) {?>
<h4>Потоки для "<?php echo $value['course_name']?>"</h4>
<table class = "table table-sm table-striped">
<tbody class = "instancesclass" data-cn = "<?php echo $value['cn_id']?>">
<?php foreach($instances[$key] as $k=>$v) {?>
<tr>
<td><?php echo $v['name']?></td>

<td><button class = "btn btn-sm btn-outline-grey my-0 editinstance" data-id = "<?php echo $v['id']?>">Редактировать</button></td>
<td><button class = "btn btn-sm btn-outline-grey my-0 deleteinstance" data-id = "<?php echo $v['id']?>">Удалить</button></td>
<td>
<div class="custom-control custom-checkbox">
	<input type="checkbox" name = "isopened" value = "1" data-id = "<?php echo $v['id']?>" class="custom-control-input isopened" 
	id="isopened<?php echo $v['id']?>" <?php if($v['isopened'] == '1') echo "checked"?>>
	<label class="custom-control-label" for="isopened<?php echo $v['id']?>">Прием заявок</label>
</div>
</td>
</tr>
<?php }?>
</tbody>
</table>
<?php }?>