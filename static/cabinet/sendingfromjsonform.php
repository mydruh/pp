<?php 
include '../config/db_connect.php';
try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$jsonfile = '../mailing/26062020/2606.json';




$template = 'https://elab.asia/mailing/26062020/indexsimple.html';

$jsonstring = file_get_contents($jsonfile);

$replyto = 'elab.khalida@gmail.com';
$subject = 'Срочно, вниманию педагогов!';
//$jsonstring = '[{"Name": "Загипа","Email": "Zagipa@list.ru","Страна": "kz"},{"Name": "Айдар","Email": "bukenov@gmail.com","Страна": "kz"}]';
$jsonstring = str_replace(array("\r", "\n"), '', $jsonstring);
$jsonarray = json_decode($jsonstring, true);

$jsonstring = json_encode($jsonarray);

//$jsjson = str_replace('[','', $jsonstring); 
//$jsjson = str_replace(']','', $jsjson);
//var_dump($jsjson);
$to = 'bukenov@gmail.com';
$name = 'Айдар Букенов';
$from = "ELAB.ASIA <no-reply@arnacom.com>";
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
 <h4>Всего  адресов</h4>
		
	
<button id = "send">Послать</button>
	
	
	
 </div> 
<!-- Button trigger modal -->

</body>
</html>
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

let jsjson = '<?php echo $jsonstring?>';

console.log(jsjson);


$(document).on('click','#send', function(e){
$.each(JSON.parse(jsjson), function(key, value) {
		
	var formData = {
		'email' : value.Email,
		'name' : value.Name,
		'contentfile' : '<?php echo $template?>',
		'replyto' : '<?php echo $replyto?>',
		'subject' : '<?php echo $subject?>',
		'from' : '<?php echo $from?>', 
		
	}
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'https://arnacom.com/elabasia/sendcourseinfo.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				
				console.log(key+' - '+data.success);
				
					
				
	})
			
})
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
