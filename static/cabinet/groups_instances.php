<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT name
		FROM groups
		WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$group = $stmt->fetch();	

$sql = 'SELECT cn.*,c.course_number,c.course_price, ci.id AS ciid, ci.name
		FROM course_instances ci
		INNER JOIN courses_names cn ON ci.id_course_name = cn.cn_id
		INNER JOIN courses c ON c.course_id = cn.course_id
		WHERE ci.isdeleted = 0 AND cn.isdeleted = 0 AND ci.isarchived = 0 ORDER BY cn.course_name';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$instances = $stmt->fetchAll();	


$sql = 'SELECT id_instance
		FROM groups_instances 
		WHERE id_group = ? AND isdeleted = 0';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$gi = $stmt->fetchAll();	

$givalues = [];
foreach($gi as $key=>$value) {
	$givalues[$key] = $value['id_instance'];
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
<h4>Потоки для группы "<?php echo $group['name']?>"</h4> 
<table class = "table table-sm table-striped">
		  <tbody>
		  <?php foreach($instances as $key=>$value) {?>
		  <tr>
			<td>
			<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input ingroup" value = "<?php echo $value['ciid']?>" data-group = "<?php echo $_GET['id']?>"
			id="ci<?php echo $value['ciid']?>" <?php if(!empty($givalues)) if(in_array($value['ciid'], $givalues)) echo " checked"?>>
			<label class="custom-control-label" for="ci<?php echo $value['ciid']?>"><?php echo $value['course_name'].' ('.$value['name'].')'?></label>
			</div></td>	
		  </tr>
		  <?php }?>
		  </tbody>
		  </table>