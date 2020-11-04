<?php 
include '../comments/lang.php';
$lang = $_GET['lang'];

if(isset($_POST['emailphone'])) {
	if (strpos($_POST['emailphone'], '@') !== false) 
		$email = filter_var($_POST['emailphone'], FILTER_SANITIZE_STRING);
	else {
		$phone = filter_var($_POST['emailphone'], FILTER_SANITIZE_STRING);
		$phone = preg_replace('/\D/', '', $phone); 
		}
}

include '../config/db_connect.php';


try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if(isset($email)) {
			$sql = 'SELECT * FROM users WHERE email = ? AND (isactive = 1 OR password <> "")';
			$q = $conn->prepare($sql);
			$q->execute([$email]);
		}
			
		else {
			$sql = 'SELECT * FROM users WHERE mobilephone = ? AND (isactive = 1 OR password <> "")';
			$q = $conn->prepare($sql);
			$q->execute([$phone]);
		}
		$q->setFetchMode(PDO::FETCH_ASSOC);
        $user = $q->fetch();
		
		
		
		if(!isset($user['id'])) { 
			
			$data['success'] = true;
			$data['message'] = 'Пользователь не зарегистрирован';
		} else if($user['phoneconfirmed'] == 0){
			$data['success'] = false;
			$data['message'] = 'Пользователь зарегистрирован';
			$data['phoneconfirmed'] = 0;
		} else {
			$data['success'] = false;
			$data['message'] = 'Пользователь зарегистрирован';
			$data['phoneconfirmed'] = 1;  
		}
		
	}
    catch(PDOException $e)
       { 
       $message =  "Connection failed: " . $e->getMessage();  
       }
	  $data['emailphone'] = $_POST['emailphone'];
		echo json_encode($data);
?>