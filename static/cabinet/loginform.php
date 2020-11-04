<?php 

?>
   <!DOCTYPE html>
<html>
<head>
<title>Login</title>
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
<body>
 <div class = "container mt-5">
 <form action = "login.php" method = "POST">
 <div class = "form-group">
 <input type = "text" class = "form-control" name = "login" placeholder = "Login" required>
 </div>
 <div class = "form-group">
 <input type = "password" class = "form-control" name = "password" placeholder = "password" required>
 </div>
  <div class = "form-group">
 <button type = "submit" class = "btn btn-outline-grey">Enter</button>
 </div>
 </form>
 </div>
 </body>
 </html>