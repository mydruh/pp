<?php 
$confirmphone = 0;
if(isset($_POST['confirmphone'])) $confirmphone = $_POST['confirmphone'];
if(isset($_POST['emailphone']) AND $_POST['emailphone'] !=='') {
	if (strpos($_POST['emailphone'], '@') !== false) {
		$email = filter_var($_POST['emailphone'], FILTER_SANITIZE_STRING);
	}
	else {
		$phone = filter_var($_POST['emailphone'], FILTER_SANITIZE_STRING);
		$phone = preg_replace('/\D/', '', $phone);
		}
}
if(isset($_POST['password'])) $userpassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString; 
}


include '../config/db_connect.php';


try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if(isset($email)) {
			$sql = 'SELECT * FROM users WHERE email = ? AND password = ? AND isactive = 1';
			$q = $conn->prepare($sql);
			$q->execute([$email, sha1( $userpassword )]);
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$user = $q->fetch();
			$data['sha'] = sha1( $userpassword );
		}
			
		else {
			$sql = 'SELECT * FROM users WHERE mobilephone = ? AND password = ? AND isactive = 1';
			$q = $conn->prepare($sql);
			$q->execute([$phone, sha1( $userpassword )]);
			$q->setFetchMode(PDO::FETCH_ASSOC);
			$user = $q->fetch();
		}
		
		
		
		
		
		
	}
    catch(PDOException $e)
       { 
       $message =  "Connection failed: " . $e->getMessage(); 
       }
	  if(!isset($user['id'])) { 
			$data['message'] = 'Что-то неверно'; 
			$data['status'] = 0;
			
		} else {
			$sql = 'SELECT id_role FROM users_roles WHERE id_user = ?';
			$q = $conn->prepare($sql);
			$q->execute([$user['id']]);
			$q->setFetchMode(PDO::FETCH_ASSOC); 
			$role = $q->fetch();
			
			session_start();
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['role_id'] = $role['id_role'];
			if($_SESSION['role_id'] == 2) 
			
			$data['status'] = 1;
		}
		echo json_encode($data);
?>