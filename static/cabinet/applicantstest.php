<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT ai.*, client.firstname,client.lastname,client.email, client.phone,
a.token,a.app_date, a.ispaid, a.id AS appid,
		cn.course_name, ci.name  
		FROM applications_instances ai
		INNER JOIN applications a ON a.id = ai.id_application
		INNER JOIN clients client ON client.id = a.client_id
		INNER JOIN course_instances ci ON ci.id = ai.id_instance 
		INNER JOIN courses_names cn ON cn.cn_id = ci.id_course_name
		WHERE ai.id_instance = ? AND a.ispaid = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['ciid'],  $_GET['ispaid']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$applicants = $stmt->fetchAll();

if(!empty($applicants)) foreach($applicants as $key=>$value) {
	$date = new DateTime($value['app_date']);     
	$applicants[$key]['date'] = $date->format('d.m.Y');
}		   
	
/*	   
	   
$sql = 'SELECT cn.*,c.course_number,c.course_price,ci.name FROM course_instances ci
		INNER JOIN courses_names cn ON ci.id_course_name = cn.cn_id
		INNER JOIN courses c ON c.course_id = cn.course_id
		WHERE ci.id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['course_id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$course= $stmt->fetch();	
if($course['course_price'] !== '0') {
$sql = 'SELECT a.*, a.id AS appid, c.* FROM applications a 
		INNER JOIN clients c ON c.id = a.client_id 
		WHERE a.id_instance = ? AND a.ispaid = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['ciid'],  $_GET['ispaid']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$applicants = $stmt->fetchAll();	
} else {
	$sql = 'SELECT a.*, a.id AS appid, c.* FROM applications a 
		INNER JOIN clients c ON c.id = a.client_id 
		WHERE a.id_instance = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$_GET['ciid']]); 
		$stmt->setFetchMode(PDO::FETCH_ASSOC); 
		$applicants = $stmt->fetchAll();	
}
foreach($applicants as $key=>$value) {
$date = new DateTime($value['app_date']);     
	$applicants[$key]['date'] = $date->format('d.m.Y');
	
	$sql = 'SELECT g.id, g.name FROM groups g  
		INNER JOIN groups_clients gc ON g.id = gc.id_group 
		WHERE gc.id_client = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$value['id']]); 
		$stmt->setFetchMode(PDO::FETCH_ASSOC); 
		$group[$key] = $stmt->fetch();
}

$sql = 'SELECT gi.id_group, g.* FROM groups_instances gi 
		INNER JOIN groups g ON g.id = gi.id_group 
		WHERE gi.id_instance = ? AND g.isdeleted = 0 AND gi.isdeleted = 0';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$_GET['ciid']]); 
		$stmt->setFetchMode(PDO::FETCH_ASSOC); 
		$groups = $stmt->fetchAll();	
		
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
<h4><?php echo $applicants[0]['course_name'].' | '.$applicants[0]['name']?></h4>
<table class = "table table-sm table-striped"><tbody>
		  <?php $i = 0; foreach($applicants as $key=>$value) {?>
		 <tr>
		 <td><?php $i++; echo $i?></td>
		 <td>
		  <?php echo $value['firstname'].' '.$value['lastname'];?>
		  </td>
		  <td>
		  <?php echo $value['email'];?>
		  </td>
		  <td>
		  <?php echo $value['phone'];?>
		  </td>
		 
		  <td><?php echo $value['token'];?></td>
		  <td><?php echo $value['date'];?></td>
		  <td>
		  <?php if($course['course_price'] !== '0') {?>
		  <div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input ispaid" value = "<?php echo $value['appid']?>" 
			id="defaultUnchecked<?php echo $value['appid']?>" <?php if($_GET['ispaid'] == '1') echo " checked"?>>
			<label class="custom-control-label" for="defaultUnchecked<?php echo $value['appid']?>">Оплачено</label>
			</div>
		  <?php } else {?>Бесплатно<?php }?>
		  </td>
		  <!--
		  <td><?php if(!empty($groups)) { if(empty($group[$key])) {?>
		  <button class = "btn btn-outline-grey btn-sm my-0 togroup" 
		  data-id = "<?php echo $value['client_id']?>" 
		  data-cn = "<?php echo $course['cn_id']?>">В группу</button>
		  <?php } else {?>
		  <?php echo $group[$key]['name']?>
		  <?php } } else {?>
		   <?php echo 'Группа не создана'?>
		  <?php }?>
		  </td>
		  -->
		  </tr>
		  <?php }?>
		  </tbody></table>