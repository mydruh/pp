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

$sql = 'SELECT * FROM groups WHERE isdeleted = 0 ORDER BY id DESC';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$groups = $stmt->fetchAll();

foreach($groups as $key=>$value) {
if($value['isclass'] == '1') {
	$sql = 'SELECT id_cn FROM groups_courses_names WHERE id_group = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$value['id']]); 
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$gcn = $stmt->fetchAll();
	$cgnalues[$key] = '{';
	foreach($gcn as $k=>$v) {
		if($k == 0)
		$cgnalues[$key] .= $value['id_cn'];
		else $cgnalues[$key] .=','.$value['id_cn'];
	} $cgnalues[$key] .='}';
} else {
	$sql = 'SELECT id_cn FROM groups_courses_names WHERE id_group = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$value['id']]); 
	$stmt->setFetchMode(PDO::FETCH_ASSOC); 
	$gcn[$key] = $stmt->fetch();
	
}
}	

$sql = 'SELECT * FROM courses_names WHERE isdeleted = 0 AND isactive = 1 ORDER BY lang_id, course_name';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$cn = $stmt->fetchAll();	

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
<title>Группы</title>
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
		  <h4>Создать группу</h4>
		 <form id = "addgroup" method = "post" action = "addgroup.php">
		 	
			<div class="form-group">
			<input type="text"  class="form-control" name = "name" required placeholder = "Название">
			</div>

			<div class="form-group">
				<input type="number"  class="form-control" name = "min" required placeholder = "Минимальное количество">
			</div>
			
			<div class="form-group">
				<input type="number"  class="form-control" name = "max" required placeholder = "Максимальное количество">
			</div>
			
<!--			
			<div class="custom-control custom-radio form-group">
			<input type="radio" name = "isclass" value = "1" class="custom-control-input" id="isclass" required>
			<label class="custom-control-label" for="isclass">Постоянная группа (класс)</label>
			</div>
			
			<div class="custom-control custom-radio form-group">
			<input type="radio" name = "isclass" value = "0" class="custom-control-input" id="isnotclass" required>
			<label class="custom-control-label" for="isnotclass">Для одного курса</label>
			</div>
			
			<div id = "cn_class" style = "display:none">
				<?php if(!empty($cn)) foreach($cn as $key=>$value) {?>
					<div class="custom-control custom-checkbox form-group">
					<input type="checkbox" name = "cn[]" value = "<?php echo $value['cn_id']?>" class="custom-control-input" id="cn<?php echo $key?>">
					<label class="custom-control-label" for="cn<?php echo $key?>"><?php echo $value['course_name']?></label>
					</div>
				<?php }?>
			</div>
			
			<div id = "cn_group" style = "display:none">
				<?php if(!empty($cn)) foreach($cn as $key=>$value) {?>
					<div class="custom-control custom-radio form-group">
					<input type="radio" name = "cn" value = "<?php echo $value['cn_id']?>" class="custom-control-input" id="cng<?php echo $key?>">
					<label class="custom-control-label" for="cng<?php echo $key?>"><?php echo $value['course_name']?></label>
					</div>
				<?php }?>
			</div>
-->			
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
		<table class = "table table-sm table-striped">
		<tbody>
		<?php foreach($groups as $key=>$value) {?>
		<tr>
		<td><?php echo $value['name']?></td>
<!--
		<td><?php if ($value['isclass'] == 1) { ?>Класс<?php } else {?>Группа<?php }?></td>
-->
		<td><?php echo $value['min_students']?></td>
		<td><?php echo $value['max_students']?></td>
		<td><button class = "btn btn-outline-grey btn-sm my-0 edit" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#editmodal"><i class="far fa-edit fa-2x"></i></button>
		<button class = "btn btn-outline-grey btn-sm my-0 instances" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#editmodal">Потоки</button>
		<button class = "btn btn-outline-grey btn-sm my-0 students" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#studentsmodal">Слушатели</button>
		<button class = "btn btn-outline-grey btn-sm my-0 addstudent" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#studentsmodal"
		data-isclass = "<?php echo $value['isclass']?>" data-cgn = "<?php if($value['isclass'] == '0') 
		echo $gcn[$key]['id_cn']; else echo $cgnalues[$key]?>">Добавить</button></td>
		
		<td>
		<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "isactive" value = "1" class="custom-control-input isactive" 
			id="isactive<?php echo $value['id']?>" data-id = "<?php echo $value['id']?>"
			<?php if($value['isactive'] == '1') echo "checked"?>>
			<label class="custom-control-label" for="isactive<?php echo $value['id']?>">Активная</label>
		</div>
		</td>
		
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

<div class="modal fade" id="studentsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
	 
  
   $(document).on('click', '#deletegroup', function(){
	   $('#deletealert').fadeIn();
   })
   
   $(document).on('click', '#addgroup input[name=isclass]', function(){
	   if($(this).val() == '1') {
		   $('#cn_class').fadeIn();
		   $('#cn_group').fadeOut();
	   }
	   else {
		   $('#cn_group').fadeIn();
		   $('#cn_class').fadeOut();
	   }
   })
   
   $(document).on('click', '#editgroup input[name=isclass]', function(){
	   if($(this).val() == '1') {
		   $('#editcn_class').fadeIn();
		   $('#editcn_group').fadeOut();
	   }
	   else {
		   $('#editcn_group').fadeIn();
		   $('#editcn_class').fadeOut();
	   }
   })
   
   $(document).on('click', '#cancel', function(){
	   $('#deletealert').fadeOut();
   })
   
    $(document).on('click', '.applications', function(){
	   $('#applications').load('instanceapplications.php?id='+$(this).attr('data-id')+'&group='+$(this).attr('data-group'));
   })
   
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
				
				 
				 
			 }
		 })
		  })
		  
		  $(document).on('click', '.togroup', function(){
			var togroupbutton = $(this);
			  var id = $(this).attr('data-id');
			  var group = $(this).attr('data-group');
			  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'addtogroup.php?id='+id+'&group='+group, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				.done(function(data) {
			 if(data.success == true) {
				
				togroupbutton.addClass('outofgroup');
				togroupbutton.removeClass('tofgroup');
				togroupbutton.html('Удалить');
				 
				 
			 }
		 })
		  })
		  
		  $(document).on('click', '.outofgroup', function(){
			var togroupbutton = $(this);
			  var id = $(this).attr('data-id');
			  var group = $(this).attr('data-group');
			  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'outofgroup.php?id='+id+'&group='+group, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				.done(function(data) {
			 if(data.success == true) {
				
				togroupbutton.addClass('tofgroup');
				togroupbutton.removeClass('outofgroup');
				togroupbutton.html('Добавить');
				 
				 
			 }
		 })
		  })
		  
		  $(document).on('click', '.removefromgroup', function(){
			var togroupbutton = $(this);
			  var id = $(this).attr('data-id');
			  var group = $(this).attr('data-group');
			  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'removefromgroup.php?id='+id+'&group='+group, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				.done(function(data) {
			 if(data.success == true) {
				togroupbutton.closest('tr').remove()
				 
				 
			 }
		 })
		  })
   
   $(document).on('click', '#deletegroupconfirm', function(){
	   var id = $(this).attr('data-id');
	   $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'deletegroup.php?id='+id, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			 if(data.success == true)
			location.reload();
		 })
   })
  
  $(document).on('click', '.isactive', function(){
	  if($(this).is(':checked')) var isactive = 1; else isactive = 0;
	  var id = $(this).attr('data-id');
	  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'activategroup.php?isactive='+isactive+'&id='+id, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			
		 })
  })
  
  $(document).on('click', '.ingroup', function(){
	  if($(this).is(':checked')) var ingroup = 1; else ingroup = 0;
	  var id = $(this).val();
	  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'addgroupinstance.php?ingroup='+ingroup+'&id='+id+'&id_group='+$(this).attr('data-group'), // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			
		 })
  })
  
  $(document).on('click', '.edit', function(){
	  var key = $(this).attr('data-key');
	  $('.modal-body','#editmodal').load('editgroupform.php?id='+$(this).attr('data-id'), function(){
		  });
	  })
	  
	$(document).on('click', '.instances', function(){
	  var key = $(this).attr('data-key');
	  $('.modal-body','#editmodal').load('groups_instances.php?id='+$(this).attr('data-id'), function(){
		  });
	  })
	  
$(document).on('click', '.students', function(){
	  var id = $(this).attr('data-id');
	  $('.modal-body','#studentsmodal').load('groupstudentsform.php?id='+id, function(){
		  });
	  })

$(document).on('click', '.addstudent', function(){
	  var id = $(this).attr('data-id');
	  $('.modal-body','#studentsmodal').load('addstudentsform.php?id='+id, function(){
		  });
	  })	  
	   
	   $(document).on('click', '.cancel', function(){
		   $(this).closest('tr').css('display', 'none');
	   })
	   
	   
	  
	   $(document).on('click', '.schedule', function(){
	  var key = $(this).attr('data-key');
	  $('.modal-body','#schedulemodal').html('');
	  $('.modal-body','#schedulemodal').load('scheduletime.php?id='+$(this).attr('data-id'), function(){
		
            $('.selecttime').timepicker({
				maxTime:'20:00',
				minTime:'8:00',
				timeFormat: 'G:i',
				show2400:true,

			});
				
	  });
	  })
		  </script>
		  </body>
		  </html>