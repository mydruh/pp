<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT c.course_price FROM courses c 
		INNER JOIN courses_names cn ON c.course_id = cn.course_id
		INNER JOIN  course_instances ci ON ci.id_course_name = cn.cn_id
		WHERE ci.id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$course= $stmt->fetch();

$sql = 'SELECT ai.*, client.firstname,client.lastname,client.email, client.phone,client.id AS id_client,
a.token,a.app_date, a.ispaid, a.id AS appid,
		cn.course_name, ci.name  
		FROM applications_instances ai
		INNER JOIN applications a ON a.id = ai.id_application
		INNER JOIN clients client ON client.id = a.client_id
		INNER JOIN course_instances ci ON ci.id = ai.id_instance 
		INNER JOIN courses_names cn ON cn.cn_id = ci.id_course_name
		WHERE ai.id_instance = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$applicants = $stmt->fetchAll();	

$sql = 'SELECT id_client FROM groups_clients WHERE  id_group = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['group']]);
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$in_group = $stmt->fetchAll();
var_dump($in_group);
$list = '0';
if(!empty($in_group))
foreach($in_group as $key=>$value) {
	echo $list .= ','.$value['id_client']; 
	$valuesarray[$key] = $value['id_client']; 
}	 	

var_dump($valuesarray);
/*
$sql = 'SELECT a.*, a.id AS appid, c.* FROM applications a 
		INNER JOIN clients c ON c.id = a.client_id 
		WHERE a.id_instance = ? AND a.client_id NOT IN ('.$list.')';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$applicants = $stmt->fetchAll();	
*/
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
<?php if(!empty($applicants)) {?>
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
			id="defaultUnchecked<?php echo $value['appid']?>" <?php if($value['ispaid'] == '1') echo " checked"?>>
			<label class="custom-control-label" for="defaultUnchecked<?php echo $value['appid']?>">Оплачено</label>
			</div>
		  <?php } else {?>Бесплатно<?php }?>
		  </td>
		  <td>
		  <?php if(isset($valuesarray) AND !in_array($value['id_client'], $valuesarray)) {?>
		  <button class = "btn btn-outline-grey btn-sm my-0 togroup" 
		  data-id = "<?php echo $value['id_client']?>" data-group = "<?php echo $_GET['group']?>">В группу</button>
		  <?php } else {?>
		  <button class = "btn btn-outline-grey btn-sm my-0 outofgroup" 
		  data-id = "<?php echo $value['id_client']?>" data-group = "<?php echo $_GET['group']?>">Удалить</button>
		  <?php }?>
		  </td>
		  </tr>
		  <?php }?>
		  </tbody></table>
<?php } else {?>
<p>Записавшихся на поток нет</p>
<?php }?>