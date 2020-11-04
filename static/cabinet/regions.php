<?php 
include '../config/db_connect.php';
if(isset($_GET['lang'])) $lang = $_GET['lang']; else $lang = 'kz';
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 2) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT * FROM regions';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$regions = $stmt->fetchAll();	







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
<title>Регионы</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="https://elab.asia/img/icon.png">
<link rel="stylesheet" href="../demos/assets/css/font-awosome.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/mdb.min.css">
<link href="datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="timepicker/css/jquery.timepicker.css" rel="stylesheet">

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/popper.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/mdb.min.js"></script>
<script src="datepicker/js/bootstrap-datepicker.js"></script>
<script src="timepicker/js/jquery.timepicker.js"></script>
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
          <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
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
                    <a class="nav-link" href="jsonform.php">Внесение email
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="regions.php">Регионы</a>
                  </li>
                </ul>
                
              </div>
            </div>
          </nav>
		 
				 
		  
		  <div class = "container mt-5">
		  <h4>Добавить Регион</h4>
		 <form id = "addempform" method = "post" action = "addregion.php">
		 
		 
			<div class="form-group">
			<input type="text"  class="form-control" name = "name_ru" required placeholder = "Название">
			</div>
			
			<div class="form-group">
			<input type="text"  class="form-control" name = "name_kz" placeholder = "Аты">
			</div>
			
			
			
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
		<table class = "table table-sm table-striped">
		<tbody>
		<?php if(!empty($regions)) foreach($regions as $key=>$value) {?>
		<tr>
		<td><?php echo $value['rname_ru'].' / '.$value['rname_kz']?></td>
			
		<td><button class = "btn btn-outline-grey btn-sm my-0 districts" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#districtsmodal">Районы</button></td>
		
		</tr>
		<?php }?>
		</tbody>
		</table>
		  </div>

<div class="modal fade" id="districtsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
       </div>
    </div>
  </div>
</div>

<div class="modal fade" id="schedulemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
       <button type="submit" class="btn btn-outline-grey" data-dismiss="modal">Закрыть</button>
        
      </div>
    </div>
  </div>
</div>
		  <script>
$(document).ready(function(){
 $(document).on('click', '.districts', function(){
	 $('.modal-body', '#districtsmodal').load('https://elab.asia/cabinet/dist.php?id='+$(this).attr('data-id'));
 })
 $(document).on('submit', '#adddistrict', function(e){
e.preventDefault();	 
 var formData = $(this).serializeArray();
	  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'adddistrict.php', // the url where we want to POST
				data 		: formData,
//				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			$('#districts').append(data);
		 })
 })
  })
		  </script>
		  </body>
		  </html>