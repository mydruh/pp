<?php 
$lang = 'ru';
?>
<!DOCTYPE html>
<html>
<head>
<title>Вход</title>
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

 <style>
 .active {
	 font-size: 1.25rem;
 }
.form-control::-webkit-input-placeholder { color: #C0C0C0; }  /* WebKit, Blink, Edge */
.form-control:-moz-placeholder { color: #C0C0C0; }  /* Mozilla Firefox 4 to 18 */
.form-control::-moz-placeholder { color: #C0C0C0; }  /* Mozilla Firefox 19+ */
.form-control:-ms-input-placeholder { color: #C0C0C0; }  /* Internet Explorer 10-11 */
.form-control::-ms-input-placeholder { color: #C0C0C0; }  /* Microsoft Edge */
 </style>

	
<body>
<div class = "row">
<div class = "col-md-4 offset-md-4">
<div class="card">
					<div class="card-body">   
						<div class="row">
							<div class="col-sm-6 text-center">
								<a href="#" class="active" id="login-form-link">Войти</a>
							</div>
							<div class="col-sm-6 text-center">
								<a href="#" id="register-form-link">Регистрация</a>
							</div>
						</div>
						<hr>
					<div class = "text-center">
						<p id = "response"></p>
					</div>
						<div class="row">
							<div class="col-lg-12">
							<p class = "confirmedemailphone"></p> 
							<form id = "regcheckform">
								<label class = "mb-0 text-muted">Email</label>
								<div class="form-group">
								
									<input type="email" name="emailphone" id="regemailphone" tabindex="1" class="form-control" placeholder="Email" value="" required>
								</div>
								<div class="form-group text-center">
									<button type="submit" class="btn btn-outline-grey" value="">Продолжить</button>
								</div>	
							</form>
								<form id="login-form" action="" method="POST" role="form" style="display: none;">
									<div class="form-group">
									<input type="email" name="emailphone"   id = "emailphone" class = "form-control" disabled>
									</div>
									<div class="form-group">
										<input type="password" name="password" class="form-control" placeholder="Пароль" required>
									</div>
									
									
									
									<div class="form-group text-center">
										
												<input type="submit" name="login-submit" id="login-submit" class="btn btn-outline-grey" value="Войти">
											
									</div>
								</form>
								<form class = "checkphone" style = "display:none">
									<div class="form-group">
										<input type="tel" name="phone"  class="form-control" id = "checkphone" placeholder="Номер мобильного телефона" required>
									</div>
									<input type = "hidden" name = "token" class = "token">
									<div class="form-group text-center" id = "confirmbutton">
										
												<button type="submit" class="btn btn-outline-grey" value="">Подтвердить номер</button>
											
									</div>
									
								</form>
								<form id = "sendcode" style = "display:none">
									<div class="form-group text-center">
										<input type="tel" name="code"  class="form-control" id = "code" placeholder="Введите код" required>
									</div>
									<input type = "hidden" name = "token" class = "token"> 
									<div class="form-group text-center">
										
												<button type="submit" class="btn btn-outline-grey" value="">Подтвердить</button>
											
									</div>
								</form>
									<div class="form-group" id = "forgot-password" style = "display:none"> 
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center"> 
													<a href="" tabindex="5" class="forgot-password">Забыли пароль?</a>
												</div>
											</div>
										</div>
									</div>
								
								
								<form id="register-form" action="" method="POST" role="form" style="display: none;">
								<div class="form-group">
								<input type="email" name="emailphone"  id="hiddenregemailphone" tabindex="1" class="form-control" placeholder="Email" value="" required disabled>
								</div>
								<div class="form-group"> 
										<input type="text" name="firstname" id="firstname" tabindex="3" class="form-control" placeholder="Имя" value="" required>
									</div>
									<div class="form-group">
										<input type="text" name="lastname" id="lastname" tabindex="4" class="form-control" placeholder="Фамилия" value="" required>
									</div>
									
									<p>Пароль должен содержать от 8 до 19 символов</p>
									<div class="form-group">
										<input type="password" name="password" id="regpassword" tabindex="2" class="form-control" placeholder="Пароль" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="regconfirm-password" tabindex="2" class="form-control" placeholder="Повторите пароль" required>
									</div>
									
									<input type="hidden" class="lang" name = "language" value="ru"> 
						
								<div class="form-group text-center">
										
												<button type="submit" name="register-submit" id="register-submit" tabindex="4" class="btn btn-outline-grey">Зарегистрироваться</button> 
										 
									</div> 

								</form>
								<form id = "regsendcode" style = "display:none">
									<div class="form-group text-center">
										<input type="tel" name="code"  class="form-control"  placeholder="Выслать код"
									<input type = "hidden" name = "token" class = "token"> 
									<div class="form-group text-center">
										
												<button type="submit" class="btn btn-outline-grey" value="">Подтвердить</button>
											
									</div>
								</form>
								
								<form id = "recover" style = "display:none">
									
										<input type="hidden" id = "recoverphone" name="recoverphone"  class="form-control">
									
									
									<div class="form-group text-center">
										
												<button type="submit" class="btn btn-outline-grey" value="">Подтвердить</button>
											
									</div>
								</form>
								
								<form id="recover-form" action="" method="POST" role="form" style="display: none;">
								<div class="form-group">
								<input type="number" name="code"  tabindex="1" class="form-control" placeholder="Введите код" value="" required>
								</div>
									<input type = "hidden" name = "token">
									<div class="form-group">
										<input type="password" name="password" tabindex="2" class="form-control" placeholder="Пароль" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" tabindex="2" class="form-control" placeholder="Подтвердить пароль" required>
									</div>
									
						
								<div class="form-group text-center">
										
												<button type="submit"  tabindex="4" class="btn btn-outline-grey">Подтвердить</button>
										 
									</div> 

								</form>
						 
						</div>
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		<script>
		function validateregEmail() {
        var email = document.getElementById('regemailphone');
        var mailFormat = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})|([0-9]{10})+$/;
        if (email.value == "") {
            alert( "  Please enter your Email or Phone Number  ");
			return false;
			}
        else if (!mailFormat.test(email.value)) {
            alert( "  Email Address / Phone number is not valid, Please provide a valid Email or phone number ");
            return false;
			}
        else if(!email.value.includes('@')) {
			var numbers = email.value.replace(/\D/g,'');
			if(numbers.substring(0,2) !== '77') {
				alert("Регистрация возможна только для абонентов казахстанских сотовых операторов");
				return false;
			}
			else {
				return true;
			}
		}
	}       
			
		
		function validateEmail() { 
        var email = document.getElementById('emailphone'); 
        var mailFormat = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})|([0-9]{10})+$/;
        if (email.value == "") {
            alert( "  Please enter your Email or Phone Number  ");
			return false;
			}
        else if (!mailFormat.test(email.value)) {
            alert( "  Email Address / Phone number is not valid, Please provide a valid Email or phone number ");
            return false;
			}
        else {
			return true;
			}
		}
		
		var action = 'login';
		jQuery(document).on('click','#login-form-link',function(e) {
		action = 'login';
		jQuery(".confirmedemailphone").html('');
		jQuery("#regemailphone").val('');
		jQuery("#login-form").delay(100).fadeOut(100);
		jQuery("#forgot-password").delay(100).fadeOut(100);
 		jQuery("#register-form").fadeOut(100);
		jQuery(".checkphone").css('display', 'none');
		$("#recover").fadeOut();
		jQuery("#regcheckform").delay(100).fadeIn(100);
		jQuery("#response").html('');
		jQuery('#register-form-link').removeClass('active'); 
		jQuery(this).addClass('active');   
		e.preventDefault();
	});
	jQuery(document).on('click','#register-form-link', function(e) {
		action = 'register';
		jQuery(".confirmedemailphone").html('');
		jQuery("#regemailphone").val('');
//		jQuery("#register-form").delay(100).fadeIn(100);
		jQuery("#regcheckform").delay(100).fadeIn(100);		
 		jQuery("#login-form").fadeOut(100); 
		jQuery("#checkphone").fadeOut(100);
		jQuery("#forgot-password").delay(100).fadeOut(100);
		jQuery("#sendcode").fadeOut(100);
		$("#recover").fadeOut();
		jQuery('#login-form-link').removeClass('active');
		jQuery(this).addClass('active');
		e.preventDefault(); 
	});
	
	jQuery(document).on('submit', '#regcheckform', function(e){
		e.preventDefault();
//	if(validateregEmail()) {
		
		var formData = jQuery(this).serializeArray(); 
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/checkregemailphone.php', // the url where we want to POST
            data        : formData, // our data object 
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback 
            .done(function(data) {
				if(data.success == true) {
					
					if(action == 'register') {
						jQuery("#register-form").delay(100).fadeIn(100); 
						$('input[type=text]', $('#register-form')).val('');
						$('input[type=password]', $('#register-form')).val('');
						jQuery("#regcheckform").delay(100).fadeOut(100);
						jQuery("#hiddenregemailphone").val($('#regemailphone').val()); 
					
					} else if(action == 'login') {
						jQuery("#response").html(data.message);
						$('#regemailphone').val('');
					}
				} else {
					
					if(action == 'register') {
					jQuery("#response").html(data.message);
					jQuery("#regemailphone").val(''); 
					
				} else if(action == 'login') {
					jQuery("#regcheckform").delay(100).fadeOut(100);
					jQuery("#login-form").delay(100).fadeIn(100);  
					$('.confirmedemailphone').html($('#regemailphone').val());
					jQuery("#emailphone").val($('#regemailphone').val());
					jQuery("#forgot-password").fadeIn(100);
					if(data.phoneconfirmed == 1) {
					
					
					} else {
						
//						jQuery("#login-form").css('display', 'none'); 
					}
				} 
				}
				
			})
//	}
	})
	
	$(document).on('click','#forgot-password', function(e){
		e.preventDefault();
		
		jQuery("#forgot-password").delay(100).fadeOut(100);
		$("#recoverphone").val($("#emailphone").val());
		$("#recover").fadeIn();
		$("#login-form").fadeOut();
		
	})

	var logintoken;
	jQuery(document).on('submit', '#register-form', function(e){ 
	e.preventDefault();
	
	var formData =  $(this).serializeArray();
	formData.push({ name: "emailphone", value: $('input[name=emailphone]', $(this)).val() });
	
	
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/testregister.php?lang=<?php echo $lang?>', // the url where we want to POST
            data        : formData, // our data object
				
			dataType	: 'json', 
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
				if(data.status == 1) {
					$('#register-form').css('display', 'none');
					$('#regsendcode').css('display', 'block');
					$('input[name=token]', '#regsendcode').val(data.token);
				} else alert(data.message);
				
			}) 
})

function login(){
		
var formData = {
		'emailphone' : $('#emailphone').val(),
		'password'	: $('input[name=password]', $('#login-form')).val()
	}; 		
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/login.php', // the url where we want to POST
            data        : formData, // our data object 
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) { 
			
				if(data.status == '0') { 
					jQuery('#response').html(data.message); 
					
				}
				else if(data.status == '1') {
					
					window.location.href = "coursesform.php";
					}
			})
}

jQuery(document).on('submit', '#login-form', function(e){ 
	e.preventDefault();
	if(validateEmail()) login();  
	
 	})
	
		jQuery(document).on('submit', '#recover', function(e){  
		
	e.preventDefault();
			
			var formData = jQuery(this).serializeArray();  
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/sendrecover.php?lang=<?php echo $lang?>', // the url where we want to POST
            data        : formData, // our data object 
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
			if(data.status == 3) {
				$('#recover').fadeOut();
				$('#recover-form').fadeIn();
				$('input[name=token]', '#recover-form').val(data.token);
				
			}
 	})
	})
	
			jQuery(document).on('submit', '#recover-form', function(e){   
	e.preventDefault();
			
			var formData = jQuery(this).serializeArray(); 
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/recoverpassword.php?lang=<?php echo $lang?>', // the url where we want to POST
            data        : formData, // our data object 
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
			if(data.success == true)  {
				window.parent.postMessage('loggedin'+data, '*');
				
			}
 	})
	})
	
	jQuery(document).on('submit', '.checkphone', function(e){  
	e.preventDefault();
			
			var formData = jQuery(this).serializeArray();  
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/checkphone.php?lang=<?php echo $lang?>', // the url where we want to POST
            data        : formData, // our data object 
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
			if(data.success == true) if(data.sendresult == true) {
				$('#sendcode').css('display', 'block');
				$('#confirmbutton').css('display', 'none');
				
				
			}
			if(data.success == false) {
				jQuery('#response').html(data.message); 
				jQuery('#checkphone').val('');
			} 
 	})
	})
	
		jQuery(document).on('submit', '#sendcode', function(e){   
	e.preventDefault();
			
			var formData = jQuery(this).serializeArray(); 
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/confirmphone.php?lang=<?php echo $lang?>', // the url where we want to POST
            data        : formData, // our data object 
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
			if(data.success == true)  {
				window.parent.postMessage('loggedin'+data, '*');
				
			}
 	})
	})
		jQuery(document).on('submit', '#regsendcode', function(e){  
	e.preventDefault();
			
			var formData = jQuery(this).serializeArray(); 
	
	$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '../registration/confirmreg.php?lang=<?php echo $lang?>', // the url where we want to POST
            data        : formData, // our data object 
			dataType	: 'json',
            encode      : true 
        })
            // using the done promise callback
            .done(function(data) {
			if(data.success == true)  {
				window.parent.postMessage('loggedin'+data, '*');
				
			}
 	})
	})	

		</script>
</body>
</html>