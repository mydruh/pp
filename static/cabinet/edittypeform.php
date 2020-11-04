<?php 
$lang = "ru";
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT * FROM courses_types 
		WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_GET['id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$type = $stmt->fetch();	


}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
?>

<form id = "editcoursetype" method = "POST" action = "editcoursetype.php">
			<input type = "hidden" name = "id" value = "<?php echo $_GET['id']?>" required> 

	<div class = "form-group">
		<input type = "text" name = "name_ru" class = "form-control" placeholder = "Название раздела" value = "<?php echo $type['name_ru']?>" required> 
	</div>
	
	
	<div class = "form-group">
		<input type = "text" name = "name_kz" class = "form-control" placeholder = "Аты"  value = "<?php echo $type['name_kz']?>" required> 
	</div>
		
		
	<div class = "form-group">
		<button type = "submit" class = "btn btn-outline-grey">Сохранить</button>
	</div>
	</form>
	
	<div class = "form-group">
		<button class = "btn btn-outline-grey deletetype">Удалить</button>
	</div>
	<div class="alert alert-danger" id = "deletealert" role="alert" style = "display:none"><p>Удалить раздел?</p>
	<button type = "button"  id = "deleteconfirm" data-id = "<?php echo $_GET['id']?>" 
	class = "btn btn-sm btn-outline-red">Удалить</button>
	<button type = "button"  id = "canceldelete"  class = "btn btn-sm btn-outline-green">Отмена</button>
	</div>