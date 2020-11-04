<?php
include '../config/db_connect.php';
$userpassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['emailphone'], FILTER_SANITIZE_STRING);
    /*** now we can encrypt the password ***/
    $userpassword = sha1( $userpassword );

try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $stmt = $conn->prepare('INSERT INTO users (firstname, lastname, email, password ) 
				VALUES ("'.$firstname.'", "'.$lastname.'",  "'.$email.'", "'.$userpassword.'")');
	$stmt->execute();
	
	}
    catch(PDOException $e)
       {
       $data['message'] =  "Connection failed: " . $e->getMessage(); 
       } 
	   $data['status'] = 1;
	   echo json_encode($data);
?>