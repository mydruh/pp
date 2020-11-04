<?php 
session_start();
if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 2) {
	} else {
	header('Location:loginform.php');
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
                    <a class="nav-link" href="#">Внесение email
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="regions.php">Регионы</a>
                  </li>
				  
                </ul>
                
              </div>
           
          </nav>
		 
          <!-- Full Page Intro -->
 <div class = "container mt-5">
	<form id = "addjson" method = "POST">
	<div class = "form-group">
	<textarea name = "json" class = "form-control"></textarea>
	</div>
	
	<div class = "form-group">
		<button type = "submit" class = "btn btn-outline-grey">Добавить</button>
	</div>
	</form>
	

 </div>         
<script>
$(document).ready(function(){


$(document).on('submit','#addjson', function(e){
	e.preventDefault();
	
var formData = $(this).serializeArray();
$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'jsontodatabase.php', // the url where we want to POST
			data        : formData,
			encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				alert(data);
				$('textarea', '#addjson').val('');
			})
})
})

</script>
</body>
</html>