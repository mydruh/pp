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

$sql = 'SELECT cs.*, cn.course_name FROM course_schedule cs
		INNER JOIN courses_names cn ON cn.cn_id = cs.courses_names_id WHERE cs.id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cs = $stmt->fetch();


$date = new DateTime($cs['startdate']);     
$csstartdate = $date->format('d.m.Y');
	
$date = new DateTime($cs['enddate']);     
$csenddate = $date->format('d.m.Y');




	$date = new DateTime($cs['startdate']);     
	$csstart = $date->format('Y-m-d');
	
	$date = new DateTime($cs['enddate']);  
	$lastday = $date->format('l d.m.Y');
	$csend = $date->format('Y-m-d');
	$start = new DateTime($csstart);
	$end =  new DateTime($csend);
	$interval = $interval = new DateInterval('P1D');
	

$period = new DatePeriod($start, $interval, $end);
	
function convertday_ru($date){
	$date = str_replace('Monday', 'Понедельник', $date);
	$date = str_replace('Tuesday', 'Вторник', $date);
	$date = str_replace('Wednesday', 'Среда', $date);
	$date = str_replace('Thursday', 'Четверг', $date);
	$date = str_replace('Friday', 'Пятница', $date);
	$date = str_replace('Saturday', 'Суббота', $date);
	$date = str_replace('Sunday', 'Воскресенье', $date);
	return $date;
};

foreach($period as $key=>$value) {
	$sql = 'SELECT * FROM schedule_times WHERE course_schedule_id = ? AND day = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_GET['id'], $value->format('Y-m-d')]); 
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$st[$key] = $stmt->fetchAll();
}
$sql = 'SELECT * FROM schedule_times WHERE course_schedule_id = ? AND day = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$_GET['id'], $csend]); 
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$stlast = $stmt->fetchAll();
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   } else {
	header('Location:loginform.php');
   }
?>
<h4 class = "text-center"><?php echo $cs['course_name']?></h4>
<h5 class = "text-center mb-3"><?php echo $csstartdate.' - '.$csenddate?></h5>
<table class = "table table-sm table-striped"><tbody>
<?php foreach ($period as $key=>$value) {?>
	<tr data-date = "<?php echo $value->format('Y-m-d')?>">
	<td>
	<?php $date = $value->format('l d.m.Y');
			echo convertday_ru($date);
	?></td>
	<td class = "times">
	<?php if(!empty($st[$key])) foreach($st[$key] as $k=>$v) {?>
		<span><?php echo substr($v['starttime'],0,-3).' - '.substr($v['endtime'],0,-3) ?>
		<a href = "#" class = "edittime" data-id = "<?php echo $v['id']?>" data-starttime = "<?php echo $v['starttime']?>"
		data-endtime = "<?php echo $v['endtime']?>"><i class="fas fa-edit mx-2"></i></a>
		<a href = "#" class = "removetime" data-id = "<?php echo $v['id']?>">
		<i class="fas fa-trash mx-2"></i></a></span>
	<?php }?>
	</td>
	<td>
	<button class = "btn btn-outline-grey btn-sm my-0 adddaytime" 
		><i class="fas fa-plus"></i></button>
	</td>
	
	</tr>
    <tr style = "display:none">
	
		<td>
	
            <input type="text" 
      required class="form-control input-small selecttime" name = "starttime" placeholder = "Начало">
			
	</td>
	<td>
	
            <input type="text" required class="form-control input-small selecttime"  name = "endtime"  placeholder = "Окончание">
			
    </div>
	</td>
	<td>
	<button type = "submit" class = "btn btn-outline-grey btn-sm my-0 addtime" 
	data-id = "<?php echo $_GET['id']?>" data-day = "<?php echo $value->format('Y-m-d')?>"	><i class="far fa-save fa-2x"></i></i>
	</button>
	<button type = "submit" class = "btn btn-outline-grey btn-sm my-0 cancel" 
	>Отмена
	</button>
	</td>
	
	</tr>    
<?php }?>
<tr><td>
<?php echo convertday_ru($lastday);?>
</td>
<td class = "times">
<?php if(!empty($stlast)) foreach($stlast as $k=>$v){?>
<span><?php echo substr($v['starttime'],0,-3).' - '.substr($v['endtime'],0,-3) ?>
		<a href = "#" class = "edittime" data-id = "<?php echo $v['id']?>" data-starttime = "<?php echo $v['starttime']?>"
		data-endtime = "<?php echo $v['endtime']?>"><i class="fas fa-edit mx-2"></i></a>
		<a href = "#" class = "removetime" data-id = "<?php echo $v['id']?>">
		<i class="fas fa-trash mx-2"></i></a></span>
<?php }?>
</td>

<td>
	<button class = "btn btn-outline-grey btn-sm my-0 adddaytime" 
		><i class="fas fa-plus"></i></button>
	
</td>
<tr style = "display:none">
	
		<td>
	
            <input type="text" 
      required class="form-control input-small selecttime" name = "starttime" placeholder = "Начало">
			
	</td>
	<td>
	
            <input type="text" required class="form-control input-small selecttime"  name = "endtime"  placeholder = "Окончание">
			
    </div>
	</td>
	<td>
	<button type = "submit" class = "btn btn-outline-grey btn-sm my-0 addtime" 
	data-id = "<?php echo $_GET['id']?>" data-day = "<?php echo $csend?>"	><i class="far fa-save fa-2x"></i></i>
	</button>
	<button type = "submit" class = "btn btn-outline-grey btn-sm my-0 cancel" 
	>Отмена
	</button>
	</td>
	
	</tr>   
</tr>

</tbody></table>
