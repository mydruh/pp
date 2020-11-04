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

$sql = 'SELECT * FROM  groups 
		WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$group = $stmt->fetch();	

$sql = 'SELECT cn.*, ci.name, ci.id AS ciid 
		FROM courses_names cn 
		INNER JOIN course_instances ci 
		ON ci.id_course_name = cn.cn_id
		INNER JOIN groups_instances gi 
		ON gi.id_instance = ci.id
		WHERE gi.id_group = ? AND ci.isdeleted = 0';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$instances = $stmt->fetchAll();



}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage(); 
   }
   } else {
	header('Location:loginform.php');
   }
?>
<h4>Добавить в группу "<?php echo $group['name']?>"</h4>

<table class = "table table-sm table-striped">
<tbody>
<?php if(!empty($instances)) foreach($instances as $key=>$value) {?>
<tr>
<td><?php echo $value['name'].' / '.$value['course_name']?></td>
<td><button class = "btn btn-sm btn-outline-grey my-0 applications" data-id = "<?php echo $value['ciid']?>"  data-group = "<?php echo $_GET['id']?>">
Загрузить записавшихся
</button></td>
</tr><?php }?>
</tbody>
</table>
<div id = "applications"></div>