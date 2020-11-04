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

$sql = 'SELECT cs.*, cn.course_name, cn.isactive, ci.id AS ciid, ci.name AS ciname 
		FROM  courses_names cn 
		INNER JOIN course_instances ci ON ci.id_course_name = cn.cn_id
		INNER JOIN course_schedule cs ON cn.cn_id = cs.courses_names_id 
		WHERE cs.isdeleted = 0
		ORDER BY cs.startdate DESC';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$schedules = $stmt->fetchAll();	

$sql = 'SELECT cn.* FROM  courses_names cn';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$courses_names = $stmt->fetchAll();	

$sql = 'SELECT e.*, ep.id AS epid FROM employees e 
		INNER JOIN emp_pos ep ON ep.id_emp = e.id 
		INNER JOIN positions p ON p.id = ep.id_position WHERE p.id = 1';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$teachers = $stmt->fetchAll();	


foreach($schedules as $key=>$value) {
	$date = new DateTime($value['startdate']);     
	$schedules[$key]['startdate'] = $date->format('d.m.Y');
	
	$date = new DateTime($value['enddate']);     
	$schedules[$key]['enddate'] = $date->format('d.m.Y');
	
	
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
<title>Расписание</title>
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
		  <h4>Создать расписание</h4>
		 <form id = "addscheduleform" method = "post" action = "addschedulenew.php">
		 
		 <div class="form-group">
		<select class="browser-default custom-select" name = "cn_id">
		<?php foreach($courses_names as $key=>$value) {?>
		<option value = "<?php echo $value['cn_id']?>"><?php echo $value['course_name']?></option>
		<?php }?>
		</select>
		</div>	
			<div class="form-group">
			<input type="text"  id = "startdate" class="form-control" name = "startdate" required placeholder = "Дата начала">
			</div>

			<div class="form-group">
				<input type="text"  id = "enddate" class="form-control" name = "enddate" required placeholder = "Дата окончания">
			</div>
			
			<div class = "form-group">
			<?php foreach($teachers as $key=>$value) {?>
			<div class="custom-control custom-checkbox custom-control-inline">
			<input type="checkbox" name = "emp[]" class="custom-control-input" id="t<?php echo $value['id']?>" value = "<?php echo $value['epid']?>">
			<label class="custom-control-label" for="t<?php echo $value['id']?>">
			<?php echo $value['firstname'].' '.$value['lastname']?>
			</label>
			</div>
			<?php }?>
			</div>
			<div class = "form-group">
			<textarea name = "description" class = "form-control" placeholder = "Другое, например, 
Сотрудники Национальной Академии Образования им. Ы.Алтынсарина "></textarea>
			</div>
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
		<table class = "table table-sm table-striped">
		<tbody>
		<?php foreach($schedules as $key=>$value) {?>
		<tr>
		<td><?php echo $value['course_name']?></td>
		<td><?php echo $value['startdate']?></td>
		<td><?php echo $value['enddate']?></td>
		<td><button class = "btn btn-outline-grey btn-sm my-0 edit" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#editmodal">Редактировать</button></td>
		
		<td><button class = "btn btn-outline-grey btn-sm my-0 schedule" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#schedulemodal">Занятия</button></td>
		</td>
		<td>
		<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "isactive" value = "1" class="custom-control-input isactive" 
			id="isactive<?php echo $value['id']?>" data-id = "<?php echo $value['id']?>"
			<?php if($value['isactive'] == '1') echo "checked"?>>
			<label class="custom-control-label" for="isactive<?php echo $value['id']?>">Активный</label>
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
        <form action = "editschedulenew.php" id = "editschedule" method = "post">
			
		</form>
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
	  $('#startdate').datepicker({
	  autoclose : true,
	  lang : "ru", 
	  todayHighlight : true,
	  format : "yyyy-mm-dd"
  });
  
  
  $('#enddate').datepicker({
	  autoclose : true,
	  lang : "ru", 
	  todayHighlight : true,
	  format : "yyyy-mm-dd"
  });
  
   $(document).on('click', '#deletecourse', function(){
	   $('#deletealert').fadeIn();
   })
   
   $(document).on('click', '#cancel', function(){
	   $('#deletealert').fadeOut();
   })
   
   $(document).on('click', '#deletecourseconfirm', function(){
	   var id = $(this).attr('data-id');
	   $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'deletecourse.php?id='+id, // the url where we want to POST
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
				url         : 'activateschedule.php?isactive='+isactive+'&id='+id, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			
		 })
  })
  
  $(document).on('click', '.edit', function(){
	  var key = $(this).attr('data-key');
	  $('#editschedule').load('scheduleeditformnew.php?id='+$(this).attr('data-id'), function(){
			  $('#editstartdate').datepicker({
	  autoclose : true,
	  lang : "ru", 
	  todayHighlight : true,
	  format : "yyyy-mm-dd"
  });
  
  
  $('#editenddate').datepicker({
	  autoclose : true,
	  lang : "ru", 
	  todayHighlight : true,
	  format : "yyyy-mm-dd"
  });
	  });
	  })
	  
	   $(document).on('click', '.adddaytime', function(){
		   formaction = 'add';
		   $(this).closest('tr').next('tr').css('display', '');
	   })
	   
	   $(document).on('click', '.cancel', function(){
		   $(this).closest('tr').css('display', 'none');
	   })
	   
	   var formaction;
	   var ctid;
	   var editbutton;
	   $(document).on('click', '.edittime', function(){
		   editbutton = $(this);
		   formaction = 'update';
		   ctid = $(this).attr('data-id');
		   $(this).closest('tr').next('tr').css('display', '');
		  
	   })
	   
	   $(document).on('click', '.removetime', function(){
		   var id = $(this).attr('data-id');
		   var thespan = $(this).closest('span');
		  $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'removecoursetime.php?id='+id, // the url where we want to POST
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			 thespan.remove();
		 })
	   })
	   
	   var thebutton;
	   $(document).on('click', '.addtime', function(){
		   thebutton = $(this);
		   if(formaction == 'add') {
		   var formData = {
			   'id' : $(this).attr('data-id'),
			   'day': $(this).attr('data-day'),
			   'starttime' : $('input[name=starttime]',$(this).closest('tr')).val(),
			   'endtime' : $('input[name=endtime]',$(this).closest('tr')).val(),
			   'action' : formaction
			   } 
			} else if(formaction == 'update') {
			   var formData = {
			   'id' : ctid,
			   'starttime' : $('input[name=starttime]',$(this).closest('tr')).val(),
			   'endtime' : $('input[name=endtime]',$(this).closest('tr')).val(),
			   'action' : formaction
				}
			}
		   console.log(formData);
		   $.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : 'addcoursetime.php', // the url where we want to POST
				data        : formData,
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			
			 if(formaction == 'add')
			 $('.times', thebutton.closest('tr').prev('tr')).append(data.html);
			else if(formaction == 'update')
				editbutton.closest('span').html(data.html);
			 $('.selecttime').val('');
			 thebutton.closest('tr').css('display','none');
		 })
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