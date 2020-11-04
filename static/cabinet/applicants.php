<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT cn.*,c.course_number,c.course_price FROM courses_names cn
		INNER JOIN courses c ON c.course_id = cn.course_id
		INNER JOIN langs l ON cn.lang_id = l.lang_id
		WHERE l.lang_short = ? AND cn.course_id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['lang'], $_GET['course_id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$course= $stmt->fetch();	
if($course['course_price'] !== '0') {
$sql = 'SELECT a.*, a.id AS appid, c.* FROM applications a 
		INNER JOIN clients c ON c.id = a.client_id 
		WHERE a.course_id = ? AND a.lang = ? AND a.ispaid = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['course_id'], $_GET['lang'],  $_GET['ispaid']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$applicants = $stmt->fetchAll();	
} else {
	$sql = 'SELECT a.*, a.id AS appid, c.* FROM applications a 
		INNER JOIN clients c ON c.id = a.client_id 
		WHERE a.course_id = ? AND a.lang = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$_GET['course_id'], $_GET['lang']]); 
		$stmt->setFetchMode(PDO::FETCH_ASSOC); 
		$applicants = $stmt->fetchAll();	
}
foreach($applicants as $key=>$value) {
$date = new DateTime($value['app_date']);     
	$applicants[$key]['date'] = $date->format('d.m.Y');
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
<h4>
<?php echo $course['course_number'].'. '.$course['course_name'].' ('.$course['course_price'].' тенге)';?>
</h4>
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
		  <td><button class = "btn btn-outline-grey btn-sm my-0 togtoup" 
		  data-id = "<?php echo $value['client_id']?>" data-cn = "<?php echo $course['cn_id']?>">В группу</button></td>
		  </tr>
		  <?php }?>
		  </tbody></table>