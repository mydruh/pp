<?php 
include '../config/db_connect.php';
if(isset($_GET['lang'])) $lang = $_GET['lang']; else $lang = 'kz';
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
if($lang == 'kz')	$lang_id = 2;
 if($lang == 'ru')	$lang_id = 1;  
$sql = 'SELECT cn.*,c.course_number,c.course_price, ci.id AS ciid, ci.name
		FROM course_instances ci
		INNER JOIN courses_names cn ON ci.id_course_name = cn.cn_id
		INNER JOIN courses c ON c.course_id = cn.course_id
		WHERE ci.isdeleted = 0 AND cn.isdeleted = 0';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$instances = $stmt->fetchAll();	


foreach($instances as $key=>$value) {
	$sql = 'SELECT count(ai.id) FROM applications_instances ai
			INNER JOIN applications a ON a.id = ai.id_application
			WHERE ai.id_instance = '.$value['ciid'].' AND a.ispaid = 0';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$unpaid[$key] = $stmt->fetchColumn();

	$sql = 'SELECT count(ai.id) FROM applications_instances ai
			INNER JOIN applications a ON a.id = ai.id_application
			WHERE ai.id_instance = '.$value['ciid'].' AND a.ispaid = 1';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$paid[$key] = $stmt->fetchColumn();

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
.badge {
	font-size: 12px;
}
</style>
    <body>

        <!-- Main navigation -->
       
          <!--Navbar-->
         <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
           
              <a class="navbar-brand" href="#">
			  <img src="https://elab.asia/img/logo-2.png" alt="" class="img-fluid" style = "max-width:48px">
                <strong>ELAB.ASIA</strong>
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7" aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="applicationsnew.php">Заявки
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="coursesform.php">Курсы</a> 
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" href="courses_typesform.php">Разделы</a>
                  </li>
				  <li class="nav-item active">
                    <a class="nav-link" href="#">Новые заявки
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                </ul>
                
              </div>
           
          </nav>
		 
				 
		  
		  <div class = "container mt-5">
		  
		  <!-- Material auto-sizing form -->
<form id = "checkpayment">
  <!-- Grid row -->
  <div class="form-row align-items-center">
    <!-- Grid column -->
    <div class="col-auto">
      <!-- Material input -->
      <div class="md-form">
        <input type="text" class="form-control mb-2" name = "token" id="inlineFormInputMD" placeholder="Номер квитанции" required>
        <label class="sr-only" for="inlineFormInputMD">Введите номер квитанции</label>
      </div>
    </div>
    <!-- Grid column -->

    
    <!-- Grid column -->
    <div class="col-auto">
      <button type="submit" class="btn btn-primary mb-0">Проверить</button>
    </div>
    <!-- Grid column -->
  </div>
  <!-- Grid row -->
</form>
<!-- Material auto-sizing form -->

<div id = "checkresult"></div>
		  
		 
		  <table class = "table table-sm table-striped">
		  <tbody id = "courseskz">
		  <?php foreach($instances as $key=>$value){?>
		  <tr>
			<td><?php echo $value['course_number']?></td>
		 	  <td><?php echo $value['course_name'].' ('.$value['name'].')'?></td>
				
			   <td><button class = "btn btn-sm btn-outline-grey text-nowrap my-0 paidbutton" 
			   <?php if($paid[$key] == 0) echo "disabled"?> data-paid = "1" 
			   data-instance = "<?php echo $value['ciid']?>">
			   Оплаченные <span class="badge <?php if($paid[$key] == 0) {?>badge-info<?php } else {?>badge-danger<?php }?> ml-2"><?php echo $paid[$key]?></span>
			   </button>
			   </td>
			   <td><button class = "btn btn-sm btn-outline-grey  text-nowrap my-0 paidbutton"  
			   <?php if($unpaid[$key] == 0) echo "disabled"?> data-paid = "0"
			   data-instance = "<?php echo $value['ciid']?>">
			   Не оплаченные 
			   <span class="badge <?php if($unpaid[$key] == 0) {?>badge-info<?php } else {?>badge-danger<?php }?> ml-2"><?php echo $unpaid[$key]?></span>
			   </button>
			   </td>
				
		  </tr>
		  <?php }?>
		  </tbody>
		  </table>
		  <div id = "list" class = "mb-5"></div>
		  </div>
		  <script>
		   var thebutton;
		   var buttonpaid;
		   var instance;
		  $(document).on('click', '.paidbutton', function(){
			  thebutton = $(this);
			 
			  
			  instance = $(this).attr('data-instance');
			  $('#list').load('applicantstest.php?ciid='+$(this).attr('data-instance')+'&ispaid='+$(this).attr('data-paid'));
		  $([document.documentElement, document.body]).animate({
			scrollTop: $("#list").offset().top
			}, 2000);
		  })
		  
		  $(document).on('click', '.freelist', function(){
			  thebutton = $(this);
			 
			  
			  instance = $(this).attr('data-instance');
			  $('#list').load('applicantstest.php?ciid='+$(this).attr('data-instance'));
		      $([document.documentElement, document.body]).animate({
			  scrollTop: $("#list").offset().top
			  }, 2000);
		  })
		  
		  var ispaid;
		  $(document).on('click', '.ispaid', function(){
			
			  var id = $(this).val();
			  if($(this).is(':checked'))  ispaid = 1; else  ispaid = 0;
			  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'app_paid.php?id='+id+'&ispaid='+ispaid, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				.done(function(data) {
			 if(data.success == true) {
				let instances = JSON.parse(data.instances);
				
				$.each(instances, function(index,value){
				 if(data.paid == 1) {
					
					 var oldnumber = parseInt(($('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').html()));
					var newnumber = oldnumber + 1;
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').html(newnumber);
					 var oldnumber = parseInt(($('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').html()));
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').html(oldnumber-1);
					
					$('.paidbutton[data-instance='+value+'][data-paid=1]').attr('disabled', false);
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').removeClass('badge-info');
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').addClass('badge-danger');
					
					if(parseInt($('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').html()) == 0) {
						
						$('.paidbutton[data-instance='+value+'][data-paid=0]').attr('disabled', true);
						$('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').removeClass('badge-danger');
						$('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').addClass('badge-info');
					}
				 }
				 if(data.paid == 0) {
					 var oldnumber = parseInt(($('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').html()));
					var newnumber = oldnumber + 1;
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').html(newnumber);
					 var oldnumber = parseInt(($('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').html()));
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').html(oldnumber-1);
					
					$('.paidbutton[data-instance='+value+'][data-paid=0]').attr('disabled', false);
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').removeClass('badge-info');
					$('.badge', '.paidbutton[data-instance='+value+'][data-paid=0]').addClass('badge-danger');
					
					if(parseInt($('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').html()) == 0) {
						
						$('.paidbutton[data-instance='+value+'][data-paid=1]').attr('disabled', true);
						$('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').removeClass('badge-danger');
						$('.badge', '.paidbutton[data-instance='+value+'][data-paid=1]').addClass('badge-info');
					}
				 }
				}) 
			 }
		 })
		  })
		  
		  $(document).on('submit', '#checkpayment', function(e){
			  e.preventDefault();
			  var formData = $(this).serializeArray(); 
		$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'checkpayment.php', // the url where we want to POST
			data        : formData,
			encode      : true 
        })
		.done(function(data) {
			$('#checkresult').html(data);
			$('input', '#checkpayment').val('');
			});
		})
		  
		  </script>
		  </body>
		  
		  </html>