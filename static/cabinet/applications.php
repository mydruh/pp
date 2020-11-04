<?php 
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 
include '../config/db_connect.php';
$lang = 'ru';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT a.*, cn.course_name, c.firstname, c.lastname, c.phone, c.email,course.course_price FROM applications a 
		INNER JOIN clients c ON c.id = a.client_id
		INNER JOIN courses course ON course.course_id = a.course_id
		INNER JOIN courses_names cn ON cn.course_id = a.course_id
		INNER JOIN langs l ON l.lang_id = cn.lang_id
		WHERE a.isdeleted = 0 AND l.lang_short = a.lang ORDER BY id DESC';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$unpaid = $stmt->fetchAll();	

foreach($unpaid as $key=>$value) {
	$date = new DateTime($value['app_date']);     
	$unpaid[$key]['date'] = $date->format('d.m.Y');
}

	
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
} else {
	header('Location:loginform.php');
}
   ?>
   <!DOCTYPE html>
<html>
<head>
<title>Заявки</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="https://elab.asia/img/icon.png">
<link rel="stylesheet" href="../demos/assets/css/font-awosome.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/mdb.min.css">


<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/popper.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/mdb.min.js"></script>
</head>
<style>
.navbar {
	background-color:#1E6D5E;
}
.navbar a {
	color:#fff;
}
</style>
    <body>

        <!-- Main navigation -->
       
          <!--Navbar-->
          <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
              <a class="navbar-brand" href="#">
			  <img src="https://elab.asia/img/logo-2.png" alt="" class="img-fluid" style = "max-width:48px">
                <strong>ELAB.ASIA</strong>
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
			  <a href = "selectform.php?lang=kz" class = "selectlang text-right d-block d-sm-none">  
                Қазақша
              </a>
			   <a href = "selectform.php?lang=ru" class = "selectlang text-right d-block d-sm-none">  
                Русский
              </a>
              <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="index.php" target = "_blank">
					<?php if($lang == "kz") {?>Бастапқы бет
					<?php } else {?>
		Главная
		<?php }?>
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  
				  <li class="nav-item d-sm-none d-md-block">
                    <a class="nav-link" href="selectform.php?lang=kz">Қазақша</a>
                  </li>
				  <li class="nav-item d-sm-none d-md-block">
                    <a class="nav-link" href="selectform.php?lang=ru">Русский</a>
                  </li>
                </ul>
                
              </div>
            </div>
          </nav>
		 
			
		 
		  
		  <div class = "container mt-5">
		  
		  <h4>Не оплаченные заявки</h4>
		  <table class = "table table-sm table-striped"><tbody>
		  <?php $i = 0; foreach($unpaid as $key=>$value) {?>
		 <tr>
		 <td><?php $i++; echo $i?></td>
		 <td>
		  <?php echo $value['firstname'].' '.$value['lastname'];?>
		  </td>
		  <td>
		  <?php echo $value['email'];?>
		  </td>
		  <td>
		  <?php echo $value['phone'];?>
		  </td>
		  <td><?php echo $value['course_name'];?></td>
		  <td><?php echo $value['token'];?></td>
		  <td><?php echo $value['date'];?></td>
		  <td>
		  <?php if($value['course_price'] !== '0') {?>
		  <div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input ispaid" value = "<?php echo $value['id']?>" id="defaultUnchecked<?php echo $value['id']?>">
			<label class="custom-control-label" for="defaultUnchecked<?php echo $value['id']?>">Оплачено</label>
			</div>
		  <?php } else {?>Бесплатно<?php }?>
		  </td>
		  </tr>
		  <?php }?>
		  </tbody></table>
		  </div>
		  </body>
		  </html>
		  <script>
		  $(document).on('click', '.ispaid', function(){
			  var id = $(this).val();
			  if($(this).is(':checked')) var ispaid = 1; else var ispaid = 0;
			  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'app_paid.php?id='+id+'&ispaid='+ispaid, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				.done(function(data) {
			 if(data.success == true) {
				 alert('Изменено!');
			 }
		 })
		  })
		  </script>