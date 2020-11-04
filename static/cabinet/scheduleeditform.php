<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT s.*, s.id AS sid FROM  schedule s WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$schedule = $stmt->fetch();	

$sql = 'SELECT e.* FROM employees e 
		INNER JOIN emp_pos ep ON ep.id_emp = e.id 
		INNER JOIN positions p ON p.id = ep.id_position
		WHERE p.id = 1';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$employees = $stmt->fetchAll();	


	$date = new DateTime($schedule['startdate']);     
	
	
	$date = new DateTime($schedule['enddate']);     
	
	
	$sql = 'SELECT `schedule_name` FROM `schedule_names` 
			WHERE schedule_id = '.$schedule['sid'].' AND lang = "ru"';
			$stmt = $conn->prepare($sql);
			$stmt->execute(); 
			$stmt->setFetchMode(PDO::FETCH_ASSOC); 
			$name = $stmt->fetch();	
			$schedule['name_ru'] = $name['schedule_name'];
			
			$sql = 'SELECT `schedule_name` FROM `schedule_names` 
			WHERE schedule_id = ? AND lang = "kz"';
			$stmt = $conn->prepare($sql);
			$stmt->execute([$schedule['sid']]); 
			$stmt->setFetchMode(PDO::FETCH_ASSOC); 
			$name = $stmt->fetch();	
			
			$schedule['name_kz'] = $name['schedule_name'];



}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   } else {
	header('Location:loginform.php');
   }
?>
<input type = "hidden" name = "schedule" value = "<?php echo $schedule['sid']?>">
			<div class = "form-group">
				<input type = "text" class = "form-control" name = "name_ru" required 
				placeholder = "Название на русском"  value = "<?php echo $schedule['name_ru']?>">
			</div>
			<div class = "form-group">
				<input type = "text" class = "form-control" name = "name_kz" required 
				placeholder = "Название на казахском"  value = "<?php echo $schedule['name_kz']?>">
			</div>
			<div class="form-group">
			<input type="text"  id = "editstartdate" class="form-control" name = "startdate" required 
			placeholder = "Дата начала"  value = "<?php echo $schedule['startdate']?>">
			</div>

			<div class="form-group">
				<input type="text"  id = "editenddate" class="form-control" name = "enddate" required 
				placeholder = "Дата окончания"  value = "<?php echo $schedule['enddate']?>">
			</div>
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
			<script>
	$('#editstartdate').datepicker({
	  autoclose : true,
	  lang : "ru", 
	  todayHighlight : true,
	  format : "yyyy-mm-dd",
	 
  });
  
  
  $('#editenddate').datepicker({
	  autoclose : true,
	  lang : "ru", 
	  todayHighlight : true,
	  format : "yyyy-mm-dd",
	 
  });
			</script>