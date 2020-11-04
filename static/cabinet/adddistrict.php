<?php 
include '../config/db_connect.php';

session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 2) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


$sql = 'INSERT INTO `districts`(`dname_ru`, `dname_kz`, `id_region`) VALUES (?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['name_ru']),trim($_POST['name_kz']), $_POST['id']]); 
$id = $conn->lastInsertId();


}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
 
   } else {
	header('Location:loginform.php');
   }
?>
<tr>
<td><?php echo trim($_POST['name_ru']).' / '.trim($_POST['name_kz'])?></td>
</tr>