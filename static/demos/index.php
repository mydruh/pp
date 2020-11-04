<?php 
include '../config/db_connect.php';

if(isset($_GET['lang']))
	$lang = $_GET['lang']; else $lang = 'kz';


try { // соединяемся с базой данных
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	   
$sql = 'SELECT c.*, cn.course_name,cn.course_description FROM courses c 
		INNER JOIN courses_names cn ON cn.course_id = c.course_id 
		INNER JOIN langs l ON cn.lang_id = l.lang_id
		WHERE l.lang_short = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$lang]); 
$stmt->setFetchMode(PDO::FETCH_ASSOC); 
$courses = $stmt->fetchAll();	



}
catch(PDOException $e)
   {
       echo "Connection failed: " . $e->getMessage();
   }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Elab.asia</title>
  <!-- Mobile Specific Meta  -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <!--- Font-->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&display=swap" rel="stylesheet">
  <!-- CSS -->
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- Jquery ui CSS -->
  <link rel="stylesheet" href="assets/css/jquery-ui.css">
  <!-- Fancybox CSS -->
  <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="assets/css/font-awosome.css">
  <!-- Flaticon CSS -->
  <link rel="stylesheet" href="assets/flat-font/flaticon.css">
  <!-- Slick Slider -->
  <link rel="stylesheet" href="assets/slick/slick-theme.css">
  <link rel="stylesheet" href="assets/slick/slick.css">
  <!-- Ticker css-->
  <link rel="stylesheet" href="assets/css/ticker.min.css">
  <!-- Nav Menu CSS -->
  <link rel="stylesheet" href="assets/css/sm-core-css.css">
  <link rel="stylesheet" href="assets/css/sm-mint.css">
  <link rel="stylesheet" href="assets/css/sm-style.css">
  <!-- Animate CSS -->
  <link rel="stylesheet" href="assets/css/animate.min.css">
  <!-- Main StyleSheet CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fab-icon.png">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>
<style>
html {
  scroll-behavior: smooth;
}
</style>

<body>
  <!---Preloder-->
  <div id="preloader-1"></div>
  <!-- /Preloder-->
  <!--Scroll Top-->
  <div class="scrollup"><i class="fas fa-long-arrow-alt-up scrollup-icon"></i></div>
  <!--Scroll Top-->
  <!-- Header Area-->
  <header class="header-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="main-nav" role="navigation">
            <!-- Mobile menu toggle button (hamburger/x icon) -->
            <input id="main-menu-state" type="checkbox" />
            <label class="main-menu-btn" for="main-menu-state">
              <span class="main-menu-btn-icon"></span>
            </label>
            <h2 class="nav-brand"><a href="index.html"><img class="top-logo" src="assets/img/logo-3.png"  style = "max-width:120px; height:auto;" alt=""></a></h2>
            <!-- Sample menu definition -->
            <ul id="main-menu" class="sm sm-mint">
              <li><a href="#top"><?php if( $lang == 'ru' ){?>Главная<?php } else {?>Басты бет<?php }?></a>
                
              </li>
              <li><a href="#prep"><?php if( $lang == 'ru' ){?>Преподаватели<?php } else {?>Оқытушылар <?php }?></a>
                
              </li>
              <li><a href="#courses"><?php if( $lang == 'ru' ){?>Курсы<?php } else {?>Курстар <?php }?></a></li>
              <li><a href="#contacts"><?php if( $lang == 'ru' ){?>Контакты<?php } else {?>Байланыстар  <?php }?></a>
                
              </li>
              
              <li>
                <a class="btn-1 smoothscroll" href="#"><?php if( $lang == 'ru' ){?>Выбрать курс<?php } else {?>Курсты таңдау<?php }?></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!--/Header Area-->

  <!-- Hero Section-->
  <section class="hero-1" id = "top">
    <div class="hero-slide1">
      <div class="slide">
        <div class="hero-slide-wrapper">
          <img src="assets/img/hero/woman-desk-macbook-pro-pen-68761.jpg"  alt="" class="h-bag">
          <img src="assets/img/hero/hero-effect.png" alt="" class="hero-effect" data-animation="fadeInUp"
            data-delay="0.5s">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="hero-slide-content">
                  <h1 data-animation="fadeInUp" data-delay="0.5s">
				  <?php if( $lang == 'ru' ){?>Курсы повышения<?php } else {?>Біліктілікті<?php }?></h1>
                  <h1 data-animation="fadeInUp" data-delay="0.8s"><?php if( $lang == 'ru' ){?>
				  квалификации<?php } else {?>арттыру курстары<?php }?></h1>
                  <p data-animation="fadeInUp" data-delay="1.2s"><?php if( $lang == 'ru' ){?>
				  Получайте новые знания и навыки. Присоединяйтесь к преподавателям,
				  овладевших соременными технологиями обучения.<?php } else {?>
				  Оқытудың заманауи технологияларын меңгерген оқытушыларға қосылып, 
				  жаңа білім мен дағдыларын меңгеріңіз.<?php }?>  
				  </p>
                  <a href="#ticket" class="btn-1 smoothscroll" data-animation="fadeInUp" data-delay="1.5s">
				  <?php if( $lang == 'ru' ){?>Записаться на курсы
				  сейчас<?php } else {?>Курстарға жазылу<?php }?> </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="slide">
        <div class="hero-slide-wrapper">
          <img src="assets/img/hero/top-view-photo-of-people-near-wooden-table-3183150.jpg" alt="" class="h-bag">
          <img src="assets/img/hero/hero-effect.png" alt="" class="hero-effect" data-animation="fadeInUp"
            data-delay="0.5s">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="hero-slide-content">
                  <h1 data-animation="fadeInUp" data-delay="0.5s"><?php if( $lang == 'ru' ){?>
				  Диплом<?php } else {?>Белгіленген<?php }?></h1>
                  <h1 data-animation="fadeInUp" data-delay="0.8s"><?php if( $lang == 'ru' ){?>
				  установленного образца<?php } else {?>үлгідегі диплом<?php }?></h1>
                  <p data-animation="fadeInUp" data-delay="1.2s"><?php if( $lang == 'ru' ){?>
				  Курсы aкадемии ELAB.ASIA одобрены НАЦИОНАЛЬНОЙ АКАДЕМИЕЙ ОБРАЗОВАНИЯ 
				  им. Ы.Алтынсарина.<?php } else {?>ELAB.ASIA Академиясының курстары 
				  Ы. Алтынсарин атындағы Ұлттық Білім беру Академиясымен мақұлданған.<?php }?>
				</p>
                  <a href="#ticket" class="btn-1 smoothscroll" data-animation="fadeInUp" data-delay="1.5s">
				  <?php if( $lang == 'ru' ){?>Записаться на курсы сейчас<?php } else {?>Курстарға жазылу<?php }?>
				  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- /Hero Section-->

  <!-- About Section-->
  <section class="about-section">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="amout-img">
            <img src="assets/img/about/prep1.jpeg" alt="">

            <div class="bpw-btn">
              <div class="pulse-box">
                <div class="pulse-css">
                  <a href="#" data-toggle="modal" data-target="#myModal2">
                    <i class="fas fa-play" aria-hidden="true"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="about-content pt-2">
            <h1><?php if( $lang == 'ru' ){?>Добро пожаловать  
              в мир новых знаний<?php } else {?>Білім әлеміне қош келдіңіздер<?php }?></h1>
            <p><?php if( $lang == 'ru' ){?>в нашем постоянно изменяющемся мире всегда есть место личностному росту. 
			Прохождение наших курсов позволит Вам более эффективно работать, открывать для себя 
			новые возможности трудоустройства. Наши курсы одобрены НАЦИОНАЛЬНОЙ АКАДЕМИЕЙ ОБРАЗОВАНИЯ им. Ы.Алтынсарина. После прохождения курса, 
			слушатель получает сертификат установленного образца. 
			Будьте вместе с нами. #бізбіргеміз<?php } else {?>
			Біздің, үнемі өзгеріп тұратын әлемде – адамның жеке тұлғалық өсуіне, өзін-өзі жетілдіруіне көптеген мүмкіндіктер бар. Солардың бірі Elab.Asia Онлайн Академиясының курстары.  
			Біздің курстардан өту өте тиімді және Сіз үшін үлкен мүмкіндік. Себебі, Сіз тиімді жұмыс жасау мүмкіндіктеріне, жұмысқа орналасудың жаңа мүмкіндіктеріне ие бола аласыз. 
			Біздің курстарымыз Ы. Алтынсарин атындағы Ұлттық Білім беру Академиясымен мақұлданған. 
			Курс соңында мұғалімге белгіленген үлгідегі сертификат беріледі. 
			Бізбен бірге болыңыз. #бізбіргеміз<?php }?></p>
            <a href="" class="btn-2"><?php if( $lang == 'ru' ){?>Записаться на курсы
			<?php } else {?>Курсқа жазылу<?php }?></a>
          </div>
        </div>
      </div>
    </div>
    

  <!-- The Modal -->
  <div class="modal" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="button ml-auto" id="pause-button" data-dismiss="modal"><i
              class="fas fa-times v-close"></i></button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div id="headerPopup">
            <!-- Make sure ?enablejsapi=1 is on URL -->
            <iframe src="<?php if( $lang == 'ru' ){?>https://www.youtube.com/embed/WYU7-RER4xo?rel=0<?php } else {?>https://www.youtube.com/embed/2Nmhy8Wr9AE<?php }?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--End The Modal -->
  </section>

  <!-- /About Section-->

  <!-- Team Section-->
  <section class="our-team" id = "prep">
    <div class="ot-top">
      <h1><?php if( $lang == 'ru' ){?>Наши сотрудники<?php } else {?>Біздің қызметкерлер<?php }?></h1>
      <p><?php if( $lang == 'ru' ){?>Представляем наших преподавателей и сотрудников!<?php } else {?>Біздің оқытушылар мен қызметкерлерді таныстру!<?php }?></p>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="single-team-member">
            <div class="stm-img wow fadeInUp" data-wow-delay=".3s">
             <img src="assets/img/team/prep1.jpeg" alt="">
              
            </div>
            <a href="#">
              <div class="stm-text wow fadeInDown" data-wow-delay=".5s">
                <h4>Загипа Алтынбекова</h4>
                <p><?php if( $lang == 'ru' ){?>Преподаватель<?php } else {?>Оқытушы<?php }?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="single-team-member">
            <div class="stm-img wow fadeInUp" data-wow-delay=".5s">
              <img src="assets/img/team/Valera1.jpg" alt="">
              
            </div>
            <a href="#">
              <div class="stm-text wow fadeInDown" data-wow-delay=".8s">
                <h4>Валерий Апрелев</h4>
                <p><?php if( $lang == 'ru' ){?>Преподаватель<?php } else {?>Оқытушы<?php }?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="single-team-member">
            <div class="stm-img wow fadeInUp" data-wow-delay="1s">
              <img src="assets/img/team/Dilmurat1.jpg" alt="">
              
            </div>
            <a href="#">
              <div class="stm-text wow fadeInDown" data-wow-delay="1.2s">
                <h4>Дильмурат Ибрагимов</h4>
                 <p><?php if( $lang == 'ru' ){?>Преподаватель<?php } else {?>Оқытушы<?php }?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="single-team-member">
            <div class="stm-img wow fadeInUp" data-wow-delay=".3s">
             <img src="assets/img/team/Nurgul1.jpg" alt="">
              
            </div>
            <a href="#">
              <div class="stm-text wow fadeInDown" data-wow-delay=".5s">
                <h4>Нургуль Оразбаева</h4>
                 <p><?php if( $lang == 'ru' ){?>Преподаватель<?php } else {?>Оқытушы<?php }?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="single-team-member">
            <div class="stm-img wow fadeInUp" data-wow-delay=".6s">
              <img src="assets/img/team/Islam.S1.jpg" alt="">
              
            </div>
            <a href="#">
              <div class="stm-text wow fadeInDown" data-wow-delay=".8s">
                <h4>Ислам Сакыджанов</h4>
                 <p><?php if( $lang == 'ru' ){?>Преподаватель<?php } else {?>Оқытушы<?php }?></p>
              </div>
            </a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="single-team-member">
            <div class="stm-img wow fadeInUp" data-wow-delay="1s">
             <img src="assets/img/team/Sultan1.jpg" alt="">
              
            </div>
            <a href="#">
              <div class="stm-text wow fadeInDown" data-wow-delay="1.2s">
                <h4>Султан Ахметкалиев</h4>
                 <p><?php if( $lang == 'ru' ){?>Преподаватель<?php } else {?>Оқытушы<?php }?></p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Team Section-->
  <!--Schedule Section-->
  <section class="schedule" id = "courses">

    <div class="schedule-animation">
      <img src="assets/img/slide/slide-element4.png" alt="">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="event-schedule-top">
            <h1><?php if( $lang == 'ru' ){?>Курсы <?php } else {?>Курстар <?php }?></h1>
            <p><?php if( $lang == 'ru' ){?>Добро пожаловать на наши курсы повышения учителей!
			<?php } else {?>Мұғалімдердің біліктілігін арттыру курстарына қош келдіңіздер!<?php }?></h1></p>
          </div>
        </div>
        <div class="col-md-12">
          <div class="event-schedule">
            
            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-terms" role="tabpanel" aria-labelledby="nav-terms-tab">
               
				<?php foreach($courses as $key=>$value) {?>

			   <div class="event-details">
                  
                  <div class="ed-content">
                    <h5><?php echo $value['course_number'].'. '.$value['course_name']?></h5>
                    <p><?php echo $value['course_description']?></p>
                    <span><i class="fas fa-tenge"></i> <?php if($value['course_price'] == '0') {?>Бесплатно<?php } else echo $value['course_price'].' тенге'?></span>
                    <span><i class="far fa-clock"></i> <?php echo $value['number of_hours']?> часов</span>
                   <span><a href="#" style = "color: #ff007a !important;" 
				   data-toggle = "modal" data-target = "#regmodal" class = "register" 
				   data-id = "<?php echo $value['course_id']?>" 
				   data-name = "<?php echo $value['course_name']?>"><?php if( $lang == 'ru' ){?>ЗАПИСАТЬСЯ
				   <?php } else {?>ЖАЗЫЛУ<?php }?></a></span>
				  </div>
                </div>
				<?php }?>
                
              </div>
			</div>
          </div>
        </div>
      </div>
    </div>

<div class="modal fade" id="regmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

 
  <div class="modal-dialog modal-lg" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel"><?php if($lang == "kz") {?>
		Курсқа жазылу
		<?php } else {?>
		Запись на курс
		<?php }?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style = "font-size: 20px;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <section class="contact-us no-mar">
            <div class="contact-information" id = "theform">
        <form id = "signforcourse">
      
	 <h5 class = "text-center coursename my-4"></h5>
	 <input type = "hidden" name = "course" id = "selectedcourse">
	  <div class="form-group cfdb1">
          <input type="text" id="firstname" class="form-control cp1" 
		  name = "firstname" required placeholder = "<?php if($lang == "kz") {?>Аты
		  <?php } else {?>Имя<?php }?>">
          
        </div>
		
		<div class="form-group cfdb1">
          <input type="text" id="lastname" class="form-control cp1" 
		  name = "lastname" required placeholder = "<?php if($lang == "kz") {?>Тегі<?php } 
		  else {?>Фамилия<?php }?>">
          
        </div>
        <div class="form-group cfdb1">
         
          <input type="email" id="email" class="form-control cp1" 
		  name = "email" required placeholder = "Email">
         </div>

        <div class="form-group cfdb1">
         
          <input type="text" id="phone" name = "phone" 
		  class="form-control cp1" required placeholder = "Телефон">
          </div>

      <input type = "hidden" name = "lang" value = "<?php echo $lang?>">
      <div class="form-group">
        <button type = "submit" class="btn-1">
		<?php if($lang == "kz") {?>
		Жазылу
		<?php } else {?>
		Записаться
		<?php }?>
		</button>
      </div>
	  </form>
	  <div id = "letter" style = "display:none;font-size:16px;">
	  
		<div id = "lettercontent">	
	  <p><?php if($lang == "kz") {?>Құрметті<?php } else {?>Уважаемый<?php }?> <span id = "name"></span>!</p>
	   <p><?php if($lang == "ru") {?>Вы успешно зарегистрировались на курс<?php } else {?>Сіз <?php }?> "<span class = "coursename"></span>" 
	   <?php if($lang == "kz") {?>курсына сәтті  жазылдыңыз<?php }?>!</p>
		<p>	   
	   <?php if($lang == "ru") {?>Для оплаты посредством приложения Каспи банка, поставьте в комментариях номер заявки
	   <?php } else {?>
	   Каспий банкінің қосымшасы арқылы төлем жасау үшін, түсіндірмелерде өтінім нөмірін қойыңыз
	   <?php }?></p>
      <p class = "text-center"><span id = "token" style = "color:red"></span></p>
	  <p><?php if($lang == "ru") {?>Ждем Вас на наших курсах! Elab.asia<?php } else {?>
	  Біздің Elab.Asia курстарында сіздерді күтеміз. <?php }?>
	  </p>
	  <p class = "mt-4 text-center"><?php if($lang == "ru") {?>Данные для оплаты:
	  <?php } else {?>Төлем үшін деректер:<?php }?>
	  </p>
	   <p class = "mt-4 text-center"><span id = "sum"></span> тенге</p>
	  <p class = "text-center">Kaspi  Gold</p>
		<p class = "text-center"><?php if($lang == "ru") {?>Номер карточки: 5169 4971 0725 4496
		<?php } else {?>Карта номері:  5169 4971 0725 4496<?php }?></p> 
		<p class = "text-center"><?php if($lang == "ru") {?>ФИО<?php } else {?>Аты-жөні<?php }?>
		: DILMURAT IBRAGIMOV</p>

		<p class = "text-center">ИИН: 021218501230</p>
		<p class = "text-center"><?php if($lang == "ru") {?>Или по номеру телефона
		<?php } else {?>Немесе телефон нөмірі<?php }?>: 87079784169</p>
		<p class = "text-center">Дильмурат Ибрагимов</p>
	</div>
	 <h5 class = "my-4"><?php if($lang == "ru") {?>Выслать данные мне на почту
	 <?php } else {?>Деректер менің поштама жіберу<?php }?></h5>
	 <form id = "sendme">
	 <div class="form-group  cfdb1">
          <input type="email" class="form-control cp1" name = "email" placeholder = "Email" required>
         
        </div>
		<input type = "hidden" name = "text">
	 <div class="form-group">
        <button type = "submit" class="btn-1">
		<?php if($lang == "ru") {?>Выслать<?php } else {?>Жіберу<?php }?>
		</button>
      </div>
	 </form>
	  </div>
	  </div>
	  </section>
      </div>
      </div>
  </div>
</div>

  </section>
  <!--/Schedule Section-->
  <!--Pricing Section-->
 

  <!--/Pricing Section-->
  <!--- Partner Section-->
  
  <!--- /Partner Section-->
  <!-- Blog Section-->
  
  <!-- /Blog Section-->
  <!-- Footer Section-->
  <footer class="footer-area" id = "contacts">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="subscribe">
            <h1><?php if($lang == "ru") {?>Подпишитесь на наши новости
			<?php } else {?>Біздің жаңалықтарға жазылыңыз
			<?php }?></h1>
            <form id = "subscription">
              <input type="email" class="form-control" name = "email" placeholder=" Email"
                onfocus="this.placeholder=''" onblur="this.placeholder='Email'">
              <button type="submit" class="btn btn-primary sub-btn"> 
			  <?php if($lang == "ru") {?>Подписаться <?php } else {?>Жазылу <?php }?></button>
            </form>
			<div class="alert alert-success my-3 ml-4" id = "subscribe-alert" role="alert" style = "display:none">
				<?php if($lang == "ru") {?>Спасибо за подписку!<?php } else {?>
				Жазылғаныңызға рахмет!<?php }?>
			</div>
          </div>
          <div class="footer-nav">
            <ul>
              <li><a href="#top"><?php if($lang == "ru") {?>Главная<?php } else {?>Басты бет<?php }?></a></li>
              <li><a href="#prep"><?php if($lang == "ru") {?>Преподаватели<?php } else {?>Оқытушылар<?php }?></a></li>
              <li><a href="#courses"><?php if($lang == "ru") {?>Курсы<?php } else {?>Курстар<?php }?></a></li>
              <li><a href="#contacts"><?php if($lang == "ru") {?>Контакты<?php } else {?> Байланыстар<?php }?></a></li>
            </ul>
          </div>
          <div class="footer-bottom">
            <div class="logo">
              <a href=""><img src="assets/img/logo-3.png" style = "max-width:120px; height:auto;" alt=""></a>
            </div>
            <div class="fb-text">
              <p> Copyright © 2020 Elab.asia
                  </p>
            </div>
            <div class="fb-s-icon">
              <ul>
                
                <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                <li><a href=""><i class="fab fa-youtube"></i></a></li>
                <li><a href=""><i class="fab fa-instagram"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- /Footer Section-->
  <!-- Scripts -->

  <!-- jQuery Plugin -->
  <script src="assets/js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- Jquery ui JS-->
  <script src="assets/js/jquery-ui.js"></script>
  <!--  Nav  -->
  <script src="assets/js/jquery.smartmenus.js"></script>
  <!-- Slick Slider -->
  <script src="assets/slick/slick.min.js"></script>
  <!-- Main Counterup Plugin-->
  <script src="assets/js/jquery.counterup.min.js"></script>
  <!-- Main Counterdown Plugin-->
  <script src="assets/js/countdown.js"></script>
  <!-- Waypoint Js-->
  <script src="assets/js/waypoints.min.js"></script>
  <!-- Fancybox Js-->
  <script src="assets/js/jquery.fancybox.min.js"></script>
  <!-- Ticker Js Plugin-->
  <script src="assets/js/ticker.min.js"></script>
  <!-- WOW JS Plugin-->
  <script src="assets/js/wow.min.js"></script>
  <!-- Main Script -->
  <script src="assets/js/theme.js"></script>
  <script>
  
  $(document).on('click', '.register', function(){
	  $('.coursename').html($(this).attr('data-name'));
	  $('#selectedcourse').val($(this).attr('data-id'));
	 
  })
  
  $("#myModal2").on('hidden.bs.modal', function(){
	  $("#myModal2 iframe").attr("src", $("#myModal2 iframe").attr("src"));
  })
 
  
  $(document).on('submit','#subscription', function(e){
e.preventDefault();
var formData = $(this).serializeArray(); 

$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : '../subscribe.php', // the url where we want to POST
				data        : formData,
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
			 if(data.success == true) {
				 $('#subscribe-alert').fadeIn();
				 $('input', '#subscription').val();
			 }
		 })
  })
  
  $('input[type=text]', '#signforcourse').val('');
$('input[type=email]', '#signforcourse').val('');

$(document).on('submit','#signforcourse', function(e){
e.preventDefault();

var formData = $(this).serializeArray(); 

$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : '../cabinet/addaplicationnew.php', // the url where we want to POST
				data        : formData,
				dataType	: 'json',
				encode      : true 
				})
				
		 .done(function(data) {
				
				$('input[type=text]', '#signforcourse').val('');
				$('input[type=email]', '#signforcourse').val('');
				$('#name').html(data.client);
				
				$('#token').html(data.token);
				$('#sum').html(data.sum);
				
				$('input[name=email]', '#sendme').val(data.email);
				$('input[name=text]', '#sendme').val($('#lettercontent').html());
				$('#signforcourse').fadeOut();
				$('#letter').fadeIn();
					

		 })
		
	})
	
	$('#regmodal').on('hide.bs.modal', function(){
		$('#signforcourse').css('display', 'block');
		$('#letter').css('display', 'none');
		$('input', '#sendme').val('');
	})
	
	$(document).on('submit','#sendme', function(e){
		e.preventDefault();
		var formData = $(this).serializeArray(); 
		$.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'https://arnacom.com/elabasia/sendcoursedata.php', // the url where we want to POST
			data        : formData,
			dataType	: 'json',
            encode      : true 
        })
		.done(function(data) {
			$('input[name=email]', '#sendme').val('');
			alert(data.response);
		})
	})
  </script>
</body>

</html>