<?php 
$data['message'] = 'error';
if(isset($_POST['email']) AND isset($_POST['phone']) AND isset($_POST['firstname']) AND 
isset($_POST['lastname']) AND isset($_POST['course']))
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
	$stmt->execute([$_POST["firstname"],$_POST["lastname"],trim($_POST["email"]),
	trim($_POST["phone"])]); 
	$client_id = $conn->lastInsertId();
}

$sql = 'SELECT c.course_price, cn.course_name FROM courses c
		INNER JOIN courses_names cn ON cn.course_id = c.course_id 
		INNER JOIN langs l ON cn.lang_id = l.lang_id
		WHERE l.lang_short = ? AND c.course_id = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$_POST['lang'], $_POST['course']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$course = $stmt->fetch();

$sql = 'SELECT * FROM applications WHERE client_id = ? AND course_id = ? AND lang = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$client_id, $_POST['course'],$_POST["lang"]]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$isregeistered = $stmt->fetch();

if(empty($isregeistered)) {
	   
$sql = 'INSERT INTO `applications`(`client_id`, `app_date`, `course_id`, 
`lang`, `amount`) 
VALUES (?,NOW(),?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->execute([$client_id, $_POST['course'],$_POST["lang"],$course['course_price']]); 
$appid = $conn->lastInsertId();

$token = $appid.'-'.$_POST['course'].'-'.$client_id.'/'.$_POST['lang'];
$data['token'] = $token;
$sql = 'UPDATE `applications` SET `token` = ? 
		WHERE id =?';
$stmt = $conn->prepare($sql);
$stmt->execute([$token, $appid]);
} else {
	$data['token'] = $isregeistered['token'];
	$data['repeat'] = true;
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