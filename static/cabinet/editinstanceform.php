<?php 
include '../config/db_connect.php';
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 



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

$sql = 'SELECT ci.* FROM course_instances ci
		WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$instance = $stmt->fetch();

$date = new DateTime($instance['startdate']);     
$startdate = $date->format('Y-m-d');

$date = new DateTime($instance['enddate']);     
$enddate = $date->format('Y-m-d');

$sql = 'SELECT course_name  FROM   courses_names 
		WHERE cn_id = ? ';
$stmt = $conn->prepare($sql);
$stmt->execute([$value['id_course_name']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn = $stmt->fetch();

$sql = 'SELECT id_teacher FROM `teachers_instances` WHERE id_instance = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$_GET['id']]); 
		$stmt->setFetchMode(PDO::FETCH_ASSOC); 
		$selectedteachers = $stmt->fetchAll();
		
	if(!empty($selectedteachers))	foreach($selectedteachers as $key=>$value) {
			$selected[$key] = $value['id_teacher'];
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
<tr><td colspan = "4">
<h4><?php echo $cn['course_name']?></h4>
<form id = "editinstance">
<input type = "hidden" name = "id" value = "<?php echo $_GET['id']?>">
		<div class="form-group">
			<input type="text"  class="form-control" name = "name" 
			 required placeholder = "Название" value = "<?php echo $instance['name']?>">
		</div>
		
		<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "bysubscription" class="custom-control-input" 
			id="editbysubscription" value = "1" <?php if($instance['bysubscription'] == '1') echo 'checked'?>>
			<label class="custom-control-label" for="editbysubscription">
			Начало по мере записи
			</label>
		</div>
			<div id = "editdates" <?php if($instance['bysubscription'] == '1') echo 'style = "display:none"'?>>
		<div class="form-group">
			<input type="text"  id = "editstartdate" class="form-control" name = "startdate" required placeholder = "Дата начала" value = "<?php echo $startdate?>">
			</div>

			<div class="form-group">
				<input type="text"  id = "editenddate" class="form-control" name = "enddate" required placeholder = "Дата окончания" value = "<?php echo $enddate?>">
			</div>
			</div>
<?php foreach($companies as $key=>$value) {?>
	<div class="custom-control custom-radio form-group">
			<input type="radio" name = "id_company" value = "<?php echo $value['id']?>" 
			class="custom-control-input" id="editid_company<?php echo $value['id']?>" required 
			<?php if($value['id'] == $instance['id_company']) echo 'checked'?>>
			<label class="custom-control-label" for="editid_company<?php echo $value['id']?>">
			<?php echo $value['name_ru']?></label>
	</div>
	<?php }?>
	<?php foreach($companies as $key=>$value) {?>
	<div class = "teachers form-group" data-company = "<?php echo $value['id']?>" style = "display:none">
	<?php if(!empty($teachers[$key])) foreach($teachers[$key] as $k=>$v) {?>
			<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" name = "emp[]" class="custom-control-input" id="editt<?php echo $v['id']?>" 
			value = "<?php echo $v['epid']?>" <?php if(isset($selected)) if(in_array($v['epid'], $selected)) echo "checked"?>>
			<label class="custom-control-label" for="editt<?php echo $v['id']?>">
			<?php echo $v['firstname'].' '.$v['lastname']?>
			</label>
			</div>
			<?php }?>
	</div>
	<?php }?>
	
	<div class="form-group">
	 <label for="editchat<?php echo $_GET['id']?>">Телеграм чат</label>
			<input type="text"  class="form-control" name = "telegram_chat"  id = "editchat<?php echo $_GET['id']?>"
			 placeholder = "Телеграм чат" value = "<?php echo $instance['telegram_chat']?>">
		</div>

		<div class = "form-group">
			<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
		</div>	
</form>
<div class = "form-group">
			<button  class = "btn btn-sm btn-outline-grey canceleditinstance">Отмена</button> 
		</div>	
</td>
</tr>