<?php 
 $data['message'] = 'Ошибка!';
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT ml.email, ml.id FROM mailing_list ml LIMIT 50';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$ml = $stmt->fetchAll();	
$countsent = 0;
foreach($ml as $key=>$value) {
	$sql = 'SELECT id FROM campaigns_list
	WHERE id_mailing_list = ? AND id_campaign = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$value['id'], $_GET['id']]); 
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$mldata = $stmt->fetch();	
	if(empty($mldata)) {
		$ml[$key]['sent'] = 0; 
		
		} 	
	else { $ml[$key]['sent'] = 1;
	$countsent = $countsent + 1;;
	}
}


}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
  
	
?>

<h4>Отправлено: <?php echo $countsent?> адресов</h4>
<!--
<?php $count = 0;?>
<div id = "sentemails">
<?php foreach($ml as $key=>$value) if($value['sent'] == '1'){ ?>
<?php $count = $count+1;?>
<p><?php echo $count;?> <?php echo $value['email']?></p>
<?php }?>
</div>
-->
<h4>Не отправлено:</h4>
<?php $count = 0;?>
<?php foreach($ml as $key=>$value) if($value['sent'] == '0'){ ?>
<?php $count = $count+1;?>
<p><?php echo $count;?> <?php echo $value['email']?> <a class = "sendemail" href = "#" name = "email[]" 
data-email = "<?php echo $value['email']?>" data-id = "<?php echo $value['id']?>">Отправить</a></p>
<?php }?>
<div class = "form-group">
<button class = "btn btn-default" id = "sendall">Отправить всем</button>
</div>