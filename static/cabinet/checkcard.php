<?php 
$data['success'] = false;
if(isset($_POST['cardnumber'])) {
	
	
	$jsonfile = 'carddata.json';
    $jsonstring = file_get_contents($jsonfile);
	$jsonstring = str_replace(array("\r", "\n"), '', $jsonstring);
	$cardusers = json_decode($jsonstring, true);
//	var_dump($cardusers);
	foreach($cardusers as $key=>$value) {
		if(trim($_POST['cardnumber']) == trim($value['cardnumber'])) {
			$data['success'] = true;
			$data['text_ru'] = '
			<div style = "color: white">
			<h3 style = "color: white">Дорогой(ая) '.$value["name"].'!</h3> 

<h3 style = "color: white">Поздравляем, Вы стали обладателем дисконтной карты elabCard!</h3>

<p style = "color: white">Теперь у Вас есть возможность:</p>
<p style = "color: white">1. Обучаться на наших курсах с постоянной 20% скидкой в течении этого  года.</p>
<p style = "color: white">2. Получить от нас один 5 минутный анимационный ролик, на любую выбранную Вами 
тему урока по Вашему школьному предмету.</p>
<p style = "color: white">3. Данная карта действует 6 месяцев с момента активации.</p>
</div>';
$data['text_kz'] = '<div style = "color: white">
			<h3 style = "color: white">Құрметті '.$value["name"].'!</h3> 

<h3 style = "color: white">Құттықтаймыз! Сіз elabcard дисконттық картасының иегері болдыңыз!</h3>

<p style = "color: white">Енді сізде:</p>
<p style = "color: white">1. Осы оқу жылында біздің курстарымызды тұрақты 20% жеңілдікпен оқуға</p>
<p style = "color: white">2. Өзіңіздің жүргізетін пәніңіз бойынша 5 минуттық анимациялық бейне таңдауыңызға мүмкіндігіңіз бар.</p>
<p style = "color: white">3. elab card дисконттық картасы іске қосылған сәттен бастап 6 ай мерзімге жарамды.</p>
</div>'; 
		} 
	}
	
	
}
echo json_encode($data);
?>