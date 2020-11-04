<?php 
$lang = "ru";
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT ct.* FROM courses_types ct
		ORDER BY type_order';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$types = $stmt->fetchAll();	


}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
?>
<!DOCTYPE html>
<html>
<head>
<title>Разделы</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="https://elab.asia/img/icon.png">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
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
                    <a class="nav-link" href="#">Заявки
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="coursesform.php">Курсы</a> 
                  </li>
				  <li class="nav-item active">
                    <a class="nav-link" href="courses_typesform.php">Разделы</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" href="applicationstest.php">Новые заявки
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                </ul>
                
              </div>
           
          </nav>
		 
          <!-- Full Page Intro -->
 <div class = "container my-5">
	<form id = "addcoursetype" method = "POST" action = "addcoursetype.php">
	
	<div class = "form-group">
		<input type = "text" name = "name_ru" class = "form-control" placeholder = "Название раздела" required> 
	</div>
	
	
	<div class = "form-group">
		<input type = "text" name = "name_kz" class = "form-control" placeholder = "Аты" required> 
	</div>
		
		
	<div class = "form-group">
		<button type = "submit" class = "btn btn-outline-grey">Добавить раздел</button>
	</div>
	</form>
	
	<table class = "table table-sm table-striped">
	<tbody id = "types_list">
	<?php if(!empty($types)) foreach($types as $key=>$value) {?>
	<tr>
	<td class = "ct"><?php echo $value['name_ru'].' / '.$value['name_kz']?></td>
	<td><button class = "btn btn-outline-grey btn-sm my-0 edit" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#editmodal">Редактировать</button></td>
		
		<td><button class = "btn btn-outline-grey btn-sm my-0 up" 
		data-id = "<?php echo $value['id']?>">Вверх</button></td>
		</td>
		<td><button class = "btn btn-outline-grey btn-sm my-0 down" 
		data-id = "<?php echo $value['id']?>">Вниз</button></td>
	</tr>
	<?php }?>
	</tbody>
	</table>
</div>  

<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
<script>
$(document).ready(function(){
	
	
	function disablefirstlast(){
		$(".down", "#types_list").attr('disabled', false);
		var lastdown = $(".down:last", "#types_list");
		lastdown.attr('disabled', true);
		
		$(".up", "#types_list").attr('disabled', false);
		var firstup = $(".up:first", "#types_list"); 
		firstup.attr('disabled', true);
		
		}
	
	disablefirstlast();
	
$(document).on('click','.up', function(e){
	
	var tr = $(this).closest('tr');
	tr.insertBefore(tr.prev('tr'));
	
	var idarray = [];
	$('.up').each(function(){
		idarray.push($(this).attr('data-id'));
	})
	
	var formData = {
		'ids[]' : idarray
	}
	
	$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'typesarrange.php', // the url where we want to POST
				data        : formData,
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			
				if(data.success == true) {
					var i = 0;
					$('.number').each(function(){
						i = i + 1;
						$(this).html(i);
					})
					
				}
				disablefirstlast();
		})
})

$(document).on('click','.down', function(e){
	var tr = $(this).closest('tr');
	tr.insertAfter(tr.next('tr'));
	
	var idarray = [];
	$('.up').each(function(){
		idarray.push($(this).attr('data-id'));
	})
	var formData = {
		'ids[]' : idarray
	}
	
	$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'typesarrange.php', // the url where we want to POST
				data        : formData,
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			
				
				if(data.success == true) {
					var i = 0;
					$('.number').each(function(){
						i = i + 1;
						$(this).html(i);
					})
					
				}
			disablefirstlast();
		})
})

$(document).on('click','.edit', function(e){
		$('.modal-body', '#editmodal').load('edittypeform.php?id='+$(this).attr('data-id'));
	})	
	
	
	$(document).on('submit','#editcoursetype', function(e){
	e.preventDefault();
	
var formData = $(this).serializeArray();
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'editcoursetype.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				if(data.success == true) {
					location.reload();
				}
		})
})

 $(document).on('click', '.deletetype', function(){
	   $('#deletealert').fadeIn();
   })
   
   $(document).on('click', '#canceldelete', function(){
	   $('#deletealert').fadeOut();
   })
   
   $(document).on('click', '#deleteconfirm', function(){
	   var id = $(this).attr('data-id');
	   $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'deletetype.php?id='+id, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			 if(data.success == true)
			location.reload();
		 })
   })	

})

</script>