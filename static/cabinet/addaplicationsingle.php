<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$data['message'] = 'error';
if(isset($_POST['email']) AND isset($_POST['phone']) AND isset($_POST['firstname']) AND 
isset($_POST['lastname']))
{

include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT id FROM clients 
		WHERE email = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['email'])]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$client = $stmt->fetch();

if(isset($client['id'])) $client_id = $client['id'];
else {
	$sql = 'INSERT INTO `clients`(`firstname`, `lastname`, `email`, `phone`) 
	VALUES (?,?,?,?)';
	$stmt = $conn->prepare($sql);
	$stmt->execute([trim($_POST["firstname"]),trim($_POST["lastname"]),trim($_POST["email"]),
	trim($_POST["phone"])]); 
	$client_id = $conn->lastInsertId();
}
if(isset($_POST['iin'])) {
	$sql = 'UPDATE `clients` SET `iin` = ? 
		WHERE id =?';
$stmt = $conn->prepare($sql);
$stmt->execute([trim($_POST['iin']), $client_id]);

}

$sql = 'SELECT id,token FROM applications
		WHERE client_id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$client_id]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$applications = $stmt->fetchAll();
if(!empty($applications)) {
	$appstring = $applications[0]['id'];
	foreach($applications as $key=>$value) if($key !==0){
		$appstring .= ','.$value['id'];
	}
}

$sql = 'SELECT c.course_price, cn.course_name FROM courses c
		INNER JOIN courses_names cn ON cn.course_id = c.course_id
		INNER JOIN course_instances i ON i.id_course_name = cn.cn_id
		WHERE i.id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['instance']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$course = $stmt->fetch();



if(isset($appstring)) {
$sql = 'SELECT * FROM applications_instances WHERE id_application IN ('.$appstring.') AND id_instance = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['instance']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$isregeistered = $stmt->fetch();

}

if(isset($appstring)) {
	if(empty($isregeistered)) {
	   
$sql = 'INSERT INTO `applications`(`client_id`, `app_date`,  
`lang`) 
VALUES (?,NOW(),?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$client_id, $_POST["lang"]]); 
$appid = $conn->lastInsertId();

$token = $appid.'-'.$_POST['instance'].'-'.$client_id.'/'.$_POST['lang'];
$data['token'] = $token;
$sql = 'UPDATE `applications` SET `token` = ? 
		WHERE id =?';
$stmt = $conn->prepare($sql);
$stmt->execute([$token, $appid]);
$sql = 'INSERT INTO `applications_instances`(`id_instance`, `id_application`) 
VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['instance'], $appid]); 
 
 	
} else {
	$sql = 'SELECT a.token FROM applications a 
			INNER JOIN applications_instances ai ON ai.id_application = a.id
		WHERE ai.id_instance = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$_POST['instance']]); 
		$stmt->setFetchMode(PDO::FETCH_ASSOC); 
		$thetoken = $stmt->fetch();
	
	$data['token'] = $thetoken['token'];
	$data['repeat'] = true;
} 

} else {
	$sql = 'INSERT INTO `applications`(`client_id`, `app_date`, `lang`) 
VALUES (?,NOW(),?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$client_id, $_POST["lang"]]); 
$appid = $conn->lastInsertId();

$token = $appid.'-'.$_POST['instance'].'-'.$client_id.'/'.$_POST['lang'];
$data['token'] = $token;
$sql = 'UPDATE `applications` SET `token` = ? 
		WHERE id =?';
$stmt = $conn->prepare($sql);
$stmt->execute([$token, $appid]);
$sql = 'INSERT INTO `applications_instances`(`id_instance`, `id_application`) 
VALUES (?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['instance'], $appid]); 

}



$data['lang'] = $_POST["lang"];
$data['name'] = $course['course_name'];
$data['message'] = 'ok';
$data['client'] = $_POST["firstname"].' '.$_POST["lastname"];
$data['sum'] = $course['course_price'];
$data['email'] = trim($_POST['email']);
 
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
}
echo json_encode($data);  

   ?>