<?php 
if(isset($_POST['login']) AND isset($_POST['password'])) {
	session_start();
	if($_POST['login'] == 'mbk.khalida@gmail.com' AND $_POST['password'] == 'khalida111') {
		$_SESSION['user_id'] = 1;
		header('Location:applicationsnew.php');
	} else if($_POST['login'] == 'ug@gmail.com' AND $_POST['password'] == 'ug111') {
		$_SESSION['user_id'] = 2;
		header('Location:jsonform.php');
	} else header('Location:loginform.php');
}
?>