<?php 
include '../config/db_connect.php';
if(isset($_GET['lang'])) $lang = $_GET['lang']; else $lang = 'kz';
session_start();
//if(isset($_SESSION['user_id']) AND $_SESSION['user_id'] == 1) {
date_default_timezone_set("UTC"); 

try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$sql = 'SELECT e.*, p.pname_ru, p.id AS pid FROM employees e 
		INNER JOIN emp_pos ep ON ep.id_emp = e.id 
		INNER JOIN positions p ON p.id = ep.id_position';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$employees = $stmt->fetchAll();	

$sql = 'SELECT * FROM positions p';
$stmt = $conn->prepare($sql);
$stmt->execute(); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$positions = $stmt->fetchAll();	


foreach($employees as $key=>$value) {

}


}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
//   } else {
//	header('Location:loginform.php');
//   }
?>
   <!DOCTYPE html>
<html>
<head>
<title>Сорудники</title>
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

<script type="text/javascript" src="../js/external_api.js"></script>
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
		  
		  <div id = "meet"></div>
		  
		  
		  <h4>Добавить сотрудника</h4>
		 <form id = "addempform" method = "post" action = "addemp.php">
		 
		 
			<div class="form-group">
			<input type="text"  class="form-control" name = "firstname" required placeholder = "Имя">
			</div>
			
			<div class="form-group">
			<input type="text"  class="form-control" name = "secondname" placeholder = "Отчество">
			</div>
			
			<div class="form-group">
			<input type="text"  class="form-control" name = "lastname" required placeholder = "Фамилия">
			</div>

			
			 <div class="form-group">
			<select class="browser-default custom-select" name = "id_position">
			<?php foreach($positions as $key=>$value) {?>
			<option value = "<?php echo $value['id']?>"><?php echo $value['pname_ru'].'/'.$value['pname_kz']?></option>
			<?php }?>
			</select>
			</div>	
			
			<div class = "form-group">
				<button type = "submit" class = "btn btn-sm btn-outline-grey">Сохранить</button> 
			</div>
		</form>
		<table class = "table table-sm table-striped">
		<tbody>
		<?php if(!empty($employees)) foreach($employees as $key=>$value) {?>
		<tr>
		<td><?php echo $value['firstname'].' '.$value['secondname'].' '.$value['lastname']?></td>
		<td><?php echo $value['pname_ru']?></td>
		
		<td><button class = "btn btn-outline-grey btn-sm my-0 edit" 
		data-id = "<?php echo $value['id']?>" data-toggle = "modal" data-target = "#editmodal">Редактировать</button></td>
		
		</tr>
		<?php }?>
		</tbody>
		</table>
		  </div>

<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
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
 $(document).ready(function(){
const domain = 'vc.arnacom.kz';
let meetwidth = document.getElementById('meet').offsetWidth
let iframeheight = meetwidth * 0.55;
var idframe; 


const options = {
    roomName: 'MyMeeting',
    height: iframeheight,
    parentNode: document.querySelector('#meet'),
	jwt: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjb250ZXh0Ijp7InVzZXIiOnsibmFtZSI6IkFpZGFyIEJ1a2Vub3YiLCJlbWFpbCI6Impkb2VAZXhhbXBsZS5jb20ifX0sImF1ZCI6IioiLCJpc3MiOiJqaXRzaWFybmFjb20iLCJyb29tIjoiTXlNZWV0aW5nIn0.kq1xMFVVx6izoiUz_cy6c5gwCa4MTO_7frFyFIPPHSI',
	userInfo: {
       
        displayName: 'Aidar Bukenov'
    }
};
const api = new JitsiMeetExternalAPI(domain, options);
})
		  </script>
		  </body>
		  </html>