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

$sql = 'SELECT * FROM clients c 
INNER JOIN groups_clients gc ON gc.id_client = c.id 
WHERE gc.id_group = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$students = $stmt->fetchAll();	


}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   } else {
	header('Location:loginform.php');
   }
?>
		<h4><?php echo $group['name']?></h4>
		<table class = "table table-sm table-striped">
		<tbody>
		<?php $i = 0; foreach($students as $key=>$value) {?>
		<tr>
		<td><?php $i++; echo $i?></td>
		<td><?php echo $value['firstname'].' '.$value['lastname']?></td>
		<td><?php echo $value['email']?></td>
		<td><?php echo $value['phone']?></td>
		<td><button class = "btn btn-outline-grey btn-sm my-0 removefromgroup" 
		data-id = "<?php echo $value['id']?>" data-group = "<?php echo $_GET['id']?>">Удалить</button>
		</td>
		</tr>
		<?php }?>
