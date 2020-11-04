<?php 
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT count(id) FROM mailing_list ml WHERE isdeleted = 0';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$listcount = $stmt->fetchColumn();	
	   
$sql = 'SELECT * FROM campaigns ORDER BY id DESC';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$campaigns = $stmt->fetchAll();	

foreach($campaigns as $key=>$value) {
	
	$sql = 'SELECT count(id) FROM campaigns_list
	WHERE id_campaign = ?';
	$stmt = $conn->prepare($sql);
	$stmt->execute([$value['id']]); 
	$campaigns[$key]['sent'] = $stmt->fetchColumn();	
	
	
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
<title>elab.iasia</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="https://elab.asia/img/icon.png">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/mdb.min.css">


<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/popper.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/mdb.min.js"></script>
<script type="text/javascript" src="../js/autosize.js"></script>
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
                  <li class="nav-item active">
                    <a class="nav-link" href="#top">Бастапқы бет
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#selectrow">Курстар</a>
                  </li>
				  
                </ul>
                
              </div>
           
          </nav>
		 
          <!-- Full Page Intro -->
 <div class = "container mt-5">
 <h4>Всего <?php echo $listcount?> адресов</h4>
	<form id = "addcampaign" method = "POST" action = "addcampaign.php">
	<div class = "form-group">
		<input type = "text" name = "campaign_name" class = "form-control" placeholder = "Название кампании"> 
	</div>
	
	<div class = "form-group">
		<button type = "submit" class = "btn btn-outline-grey">Создать кампанию</button>
	</div>
	</form>
	
	<table class = "table table-sm table-striped"><tbody>
	<?php if(!empty($campaigns)) foreach($campaigns as $key=>$value){?>
	<tr>
	<td>
	  <?php echo $value['capmaign_name'].' (Отправлено '.$value['sent'].' из '.$listcount.')';?>
	</td>
	<td>
	  <button class = "btn btn-sm btn-outline-grey my-0 seeletter" 
	  data-toggle = "modal" data-target = "#textmodal"
	  data-id = "<?php echo $value['id']?>">Посмотреть письмо</button>
	</td>
	<td>
	  <button class = "btn btn-sm btn-outline-grey my-0 addtext" 
	  data-toggle = "modal" data-target = "#lettermodal"
	  data-id = "<?php echo $value['id']?>">Текст письма</button>
	</td>
	<td>
	  <button class = "btn btn-sm btn-outline-grey my-0 sendall"  data-id = "<?php echo $value['id']?>" 
	  <?php if($value['subject'] == '' OR $value['letter'] == '') echo "disabled"?>>Отправить всем</button>
	</td>
	</tr>
	<?php }?>
	</tbody></table>

	
	
	
 </div> 
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="textmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
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

<div class="modal fade" id="lettermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id = "addtextform" method = "post" action = "updatecampign.php">
		<input type = "hidden" name = "campaign">
			<div class = "form-group">
				<input type = "text" class = "form-control" name = "subject" required placeholder = "Тема">
			</div>
			<div class = "form-group">
				<textarea class = "form-control" name = "body" required placeholder = "Текст письма"></textarea>
			</div>
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
      </div>
      <div class="modal-footer">
       <button type="submit" class="btn btn-outline-grey" data-dismiss="modal">Закрыть</button>
        
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
autosize(document.querySelectorAll('textarea'));
var campaign;
$(document).on('click','.campaigns', function(e){
$('#mailing_list').load('mailinglist.php?id='+$(this).val());
campaign = $(this).val();
})

$(document).on('click','.addtext', function(e){
	$('input[name=campaign]', '#addtextform').val($(this).attr('data-id'));
	$('input[name=subject]', '#addtextform').val('<?php echo $value["subject"]?>');
	$('textarea[name=body]', '#addtextform').val('<?php echo $value["letter"]?>');
})

$(document).on('click','.sendemail', function(e){
	e.preventDefault();
	var thisemail  = $(this).attr('data-email');
	var thisid  = $(this).attr('data-id');
	var thisp  = $(this).closest('p');
var formData = {
	'email[]' : $(this).attr('data-email')
};
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'https://arnacom.com/elabasia/testemail.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				
				if(data.success = true) {
					
					$.ajax({
						type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'confirmsent.php?id_camaign='+campaign+'&id_mailing_list='+thisid, // the url where we want to POST
						data        : formData,
						dataType	: 'json',
						encode      : true 
					})
					 .done(function(data1) {
				
						if(data1.success = true) {
							thisp.remove();
							$('#sentemails').append('<p>'+thisemail+'</p>');
						}
					 })
				}
	})
})

$(document).on('click','#sendall', function(e){
	e.preventDefault();
	$('.sendemail').each(function(){
	var thisemail  = $(this).attr('data-email');
	var thisid  = $(this).attr('data-id');
	var thisp  = $(this).closest('p');
var formData = {
	'email[]' : $(this).attr('data-email')
};
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'https://arnacom.com/elabasia/testemail.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				
				if(data.success = true) {
					
					$.ajax({
						type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
						url         : 'confirmsent.php?id_camaign='+campaign+'&id_mailing_list='+thisid, // the url where we want to POST
						data        : formData,
						dataType	: 'json',
						encode      : true 
					})
					 .done(function(data1) {
				
						if(data1.success = true) {
							thisp.remove();
							$('#sentemails').append('<p>'+thisemail+'</p>');
						}
					 })
				}
	})
	})
})
})

</script>
</body>
</html>
