<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   


$sql = 'SELECT a.*, a.id AS appid, c.* FROM applications a 
		INNER JOIN clients c ON c.id = a.client_id 
		WHERE a.token = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['token'])]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$applicant = $stmt->fetch();


	

if(!empty($applicant)) {
$date = new DateTime($applicant['app_date']);     
	$applicant['date'] = $date->format('d.m.Y');
	
	$sql = 'SELECT cn.*,c.course_number,c.course_price, ci.name FROM courses_names cn
		INNER JOIN courses c ON c.course_id = cn.course_id
		INNER JOIN course_instances ci ON ci.id_course_name = cn.cn_id
		INNER JOIN applications_instances ai ON ai.id_instance = ci.id
		WHERE ai.id_application = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$applicant['appid']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn= $stmt->fetchAll();	

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
<?php if(!empty($applicant)) {?>
<table class = "table table-sm table-bordered table-dark"><tbody>
		  
		 <tr>
		
		 <td>
		  <?php echo $applicant['firstname'].' '.$applicant['lastname'];?>
		  </td>
		  <td>
		  <?php echo $applicant['email'];?>
		  </td>
		  <td>
		  <?php echo $applicant['phone'];?>
		  </td>
		 
		  <td><?php echo $applicant['token'];?></td>
		  <td><?php echo $applicant['date'];?></td>
		  <td>
		  <?php if($applicant['course_price'] !== '0') {?>
		  <div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input ispaid" value = "<?php echo $applicant['appid']?>" 
			id="defaultUnchecked<?php echo $applicant['appid']?>" <?php if($applicant['ispaid'] == '1') echo " checked"?>>
			<label class="custom-control-label" for="defaultUnchecked<?php echo $applicant['appid']?>">Оплачено</label>
			</div>
		  <?php } else {?>Бесплатно<?php }?>
		  </td>
		  
		  </tr> 
		  <?php foreach($cn as $key=>$value) {?>
		  <tr> 
		 
		  <td colspan= "3">
		 <?php echo $value['course_name']?>
		  </td>
		  <td colspan= "2">
		 <?php echo $value['name']?>
		  </td>
		  <td>
		 <?php echo $value['course_price'].' тенге'?>
		  </td>
		  
		  </tr>
		  <?php }?>
		  </tbody></table>
<?php } else {?>
<p>Заявки с номером <?php echo $_POST['token']?> не найдено</p>
<?php }?>