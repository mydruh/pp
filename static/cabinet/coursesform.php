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


$sql = 'SELECT c.* FROM courses c WHERE isdeleted = 0 
		ORDER BY course_number';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$courses = $stmt->fetchAll();	

	

foreach($courses as $key=>$value) {
$sql = 'SELECT cn.course_name, cn.cn_id, cn.isactive FROM courses_names cn 
		WHERE cn.course_id = ? AND cn.lang_id = 1';
$stmt = $conn->prepare($sql);
$stmt->execute([$value['course_id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$r =  $stmt->fetch();	
$courses[$key]["name_ru"]['name'] = $r['course_name'];
if($r['isactive'] == '0') $courses[$key]["name_ru"]["isactive"] = 0; else $courses[$key]["name_ru"]["isactive"] = 1;

$sql = 'SELECT cn.course_name, cn.cn_id,cn.isactive FROM courses_names cn 
		WHERE cn.course_id = ? AND cn.lang_id = 2';
$stmt = $conn->prepare($sql);
$stmt->execute([$value['course_id']]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$r =  $stmt->fetch();	
$courses[$key]["name_kz"]['name'] = $r['course_name'];
if($r['isactive'] == '0') $courses[$key]["name_kz"]["isactive"] = 0; else $courses[$key]["name_kz"]["isactive"] = 1;
}
}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
?>
<!DOCTYPE html>
<html>
<head>
<title>Курсы</title>
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
                    <a class="nav-link" href="applicationsnew.php">Заявки
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
					<li class="nav-item">
                    <a class="nav-link" href="flashnew.php">Носитель
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="#">Курсы</a>
                  </li>
				  <li class="nav-item">
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
	<form id = "addcourse" method = "POST" action = "addcourse.php">
	<div class = "form-group">
		<input type = "number" name = "hours" class = "form-control" placeholder = "Количество часов" required> 
	</div>
	
	<div class = "form-group">
		<input type = "number" name = "price" class = "form-control" placeholder = "Цена" required> 
	</div>
	
	
	<div class = "form-group">
		<input type = "text" name = "name_ru" class = "form-control" placeholder = "Название курса" required> 
	</div>
	
	<div class = "form-group">
		<textarea name = "desc_ru" class = "form-control" placeholder = "Описание"></textarea>
	</div>
	<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "active_ru" value = "1" class="custom-control-input" id="active_ru">
			<label class="custom-control-label" for="active_ru">Активный</label>
	</div>
	
	<div class = "form-group">
		<input type = "text" name = "name_kz" class = "form-control" placeholder = "Аты" required> 
	</div>
		
	<div class = "form-group">
		<textarea name = "desc_kz" class = "form-control" placeholder = "Сипаттау"></textarea>
	</div>
	
	
	
	<div class="custom-control custom-checkbox form-group">
			<input type="checkbox" name = "active_kz" value = "1" class="custom-control-input" id="active_kz">
			<label class="custom-control-label" for="active_kz">Активный</label>
	</div>
	
	<?php if(!empty($types)) foreach($types as $key=>$value) {?>
	<div class="custom-control custom-checkbox form-group">
		<input type="checkbox" name = "id_type[]" value = "<?php echo $value['id']?>" class="custom-control-input" id="id_type<?php echo $value['id']?>">
		<label class="custom-control-label" for="id_type<?php echo $value['id']?>"><?php echo $value['name_ru']?></label>
	</div>
	<?php }?>
	
	<div class = "form-group">
		<button type = "submit" class = "btn btn-outline-grey">Добавить курс</button>
	</div>
	</form>
	
	<table class = "table table-sm table-striped">
	<tbody id = "courses_list">
	<?php foreach($courses as $key=>$value) {?>
	<tr>
	<td class = "number"><?php echo $value['course_number']?></td>
	<td>
	<?php echo '<span';
	if($value['name_ru']['isactive'] == 0) echo ' class = "text-danger"';
	echo '>'.$value['name_ru']['name'].'</span> / <span';
	if($value['name_kz']['isactive'] == 0) echo ' class = "text-danger"';
	echo '>'.$value['name_kz']['name'].'</span>';?>
	</td>
	<td><button class = "btn btn-outline-grey btn-sm my-0 instances" 
		data-id = "<?php echo $value['course_id']?>" data-toggle = "modal" data-target = "#editmodal">Потоки</button></td>
	
	<td><button class = "btn btn-outline-grey btn-sm my-0 edit" 
		data-id = "<?php echo $value['course_id']?>" data-toggle = "modal" data-target = "#editmodal">Редактировать</button></td>
		
		<td><button class = "btn btn-outline-grey btn-sm my-0 up" 
		data-id = "<?php echo $value['course_id']?>">Вверх</button></td>
		</td>
		<td><button class = "btn btn-outline-grey btn-sm my-0 down" 
		data-id = "<?php echo $value['course_id']?>">Вниз</button></td>
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

 
<script>
$(document).ready(function(){
	
	
	function disablefirstlast(){
		$(".down", "#courses_list").attr('disabled', false);
		var lastdown = $(".down:last", "#courses_list");
		lastdown.attr('disabled', true);
		
		$(".up", "#courses_list").attr('disabled', false);
		var firstup = $(".up:first", "#courses_list"); 
		firstup.attr('disabled', true);
		
		}
	
	disablefirstlast();
	
	$(document).on('click','#addinstance input[name=id_company]', function(e){
		$('.teachers', '#addinstance').fadeOut();
		$('.teachers[data-company='+$(this).val()+']', '#addinstance').fadeIn();
	})
	
	$(document).on('click','#editinstance input[name=id_company]', function(e){
		$('.teachers', '#editinstance').fadeOut();
		$('.teachers[data-company='+$(this).val()+']', '#editinstance').fadeIn();
	})
	
	$(document).on('click','.edit', function(e){
		$('.modal-body', '#editmodal').load('editcourseform.php?id='+$(this).attr('data-id'));
	})
	
	$(document).on('click','.instances', function(e){
		$('.modal-body', '#editmodal').load('instances.php?id='+$(this).attr('data-id'), function(){
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
		});
	})

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
				url         : 'coursearrange.php', // the url where we want to POST
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
				url         : 'coursearrange.php', // the url where we want to POST
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

$(document).on('click','.isopened', function(e){
	if($(this).is(':checked')) 
		var isopened = 1; else var isopened = 0;
		var id = $(this).attr('data-id');
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'openinstance.php?isopened='+isopened+'&id='+id, // the url where we want to POST
			dataType	: 'json',
            encode      : true 
        })
	
})

$(document).on('submit','#addcourse', function(e){
	e.preventDefault();
	
var formData = $(this).serializeArray();
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'addcourse.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				if(data.success == true)
				location.reload();
				$('textarea', '#addcourse').html('');
				
	})
})

$(document).on('submit','#addinstance', function(e){
	e.preventDefault();
	
var formData = $(this).serializeArray();
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'addinstance.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				if(data.success == true) {
				var cn_id = $('input[name=cn_id]:checked').val();
				$('.instancesclass[data-cn='+cn_id+']').prepend(data.html);
				}
				
	})
})

$(document).on('submit','#editinstance', function(e){
	e.preventDefault();
	var theform = $(this);
var formData = $(this).serializeArray();
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'editinstance.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				if(data.success == true)
					var tr = theform.closest('tr').prev('tr');
				
					$('td:first-child', tr).html(data.name);
					
					theform.closest('tr').remove();
					editbutton.attr('disabled', false);
	})
})

var editbutton;
var editinstancehtml = '<tr><td colspan = "4"><form id = "editinstance"><input type = "hidden" name = "id"><div class="form-group"><input type="text"  class="form-control" name = "name" required placeholder = "Название"></div><div class = "form-group"><button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button></div></form><div class = "form-group"><button class = "btn btn-sm btn-outline-grey cancel">Отмена</button></div></td></tr>';
$(document).on('click','.editinstance', function(e){
editbutton = $(this);
$('.editinstance').attr('disabled', true);
var tr = $(this).closest('tr');
	
	$.get('editinstanceform.php?id='+editbutton.attr('data-id'), function(data){ 
    tr.after(data); 
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
  
  var id_company = $('input[name=id_company]:checked', '#editinstance').val();
  $('.teachers[data-company='+id_company+']', '#editinstance').css('display', 'block');
  });
//	$('input[name=id]', '#editinstance').val(editbutton.attr('data-id'));
//	$('input[name=name]', '#editinstance').val(editbutton.closest('td').prev('td').html());
	

	editbutton.attr('disabled', true);
})

$(document).on('click','.cancel', function(e){
	$(this).closest('tr').remove();
	editbutton.attr('disabled', false);
	
})
$(document).on('click','.canceleditinstance', function(e){
	$(this).closest('tr').remove();
	editbutton.attr('disabled', false);
	$('.editinstance').attr('disabled', false);
})

var deletealert = '<tr><td colspan = "4"><div class="alert alert-danger" id = "deletealert" role="alert"><p>Удалить поток?</p><button type = "button"  id = "deleteinstanceconfirm" data-id = "" class = "btn btn-sm btn-outline-red">Удалить</button><button type = "button"  id = "canceldelete"  class = "btn btn-sm btn-outline-green">Отмена</button></div></td></tr>';

$(document).on('click','.deleteinstance', function(e){
	$(this).closest('tr').after(deletealert);
	$('#deleteinstanceconfirm').attr('data-id', $(this).attr('data-id'));
})

$(document).on('click','#canceldelete', function(e){
	$(this).closest('tr').remove();
})

$(document).on('click','#deleteinstanceconfirm', function(e){
	var deletebutton = $(this);
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'deleteinstance.php?id='+$(this).attr('data-id'), // the url where we want to POST
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				if(data.success == true) {
					deletebutton.closest('tr').prev('tr').remove();
					deletebutton.closest('tr').remove();
				}
		})
})

$(document).on('submit','#editcourse', function(e){
	e.preventDefault();
	
var formData = $(this).serializeArray();
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'editcourse.php', // the url where we want to POST
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

 $(document).on('click', '.deletecourse', function(){
	   $('#deletecoursealert').fadeIn();
   })
   
   $(document).on('click', '#canceldeletecourse', function(){
	   $('#deletecoursealert').fadeOut();
   })
   
   $(document).on('click', '#bysubscription', function(){
	   if($(this).is(':checked')) {
	   $('#dates').fadeOut();
	   $('#startdate').removeAttr('required');
	   $('#enddate').removeAttr('required');
	   } else  {
		   $('#dates').fadeIn();
		   $('#startdate').addAttr('required');
			$('#enddate').addAttr('required');
	   }
   })
   
   $(document).on('click', '#editbysubscription', function(){
	   if($(this).is(':checked'))
	   $('#editdates').fadeOut();
   else  $('#editdates').fadeIn();
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

})

</script>
</body>
</html>
