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

$sql = 'SELECT * FROM regions WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute($_GET['id']); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$region = $stmt->fetch();	


$sql = 'SELECT * FROM districs WHERE id_region = ?';
$stmt = $conn->prepare($sql);
$stmt->execute($_GET['id']); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$districs = $stmt->fetchAll();




}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
   } else {
	header('Location:loginform.php');
   }
?>

 
		 
		  <h4>Добавить район</h4>
		  <h4><?php echo $region['rname_ru'].' / '.$region['rname_kz']?></h4>
		 <form id = "adddistrict">
		 
		 
			<div class="form-group">
			<input type="text"  class="form-control" name = "name_ru" required placeholder = "Название">
			</div>
			
			<div class="form-group">
			<input type="text"  class="form-control" name = "name_kz" placeholder = "Аты">
			</div>
			
			
			
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
		<table class = "table table-sm table-striped"> 
		<tbody id = "districs">
		<?php if(!empty($regions)) foreach($districs as $key=>$value) {?>
		<tr>
		<td><?php echo $value['name_ru'].' / '.$value['name_kz']?></td>
					
		</tr> 
		<?php }?>
		</tbody>
		</table>
		 

