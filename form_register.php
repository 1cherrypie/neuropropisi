<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8" http-equiv="Content-Type"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Прописи|Регистрация</title>
	<link type="text/css" rel="stylesheet" href="css_style1.css">
</head>
<body id="top">
	<header class="header" id="header">
		<div class="some-container">
			<nav class="top-menu">
				<div class="first-menu">
				<a class="logo first-m" href="propisi1.php">Прописи</a>
				<form class="pole-search first-m" action="" method="get">
					<input class="search-pole" type="search" placeholder="Искать суть бытия" maxlength="28">
					<button type="submit" class="cndbober">Найти</button>
				</form>
				<div class="login first-m">
					<button 
					onclick="document.getElementById('id01').style.display='block'" 
					class="button_login">ВОЙТИ | РЕГИСТРАЦИЯ
					</button>
				</div>
				</div>
				<ul class="menu-main">
					<li><a href="#">Справочник</a></li>
					<li><a href="propisi1.php">Распознавание</a></li>
					<li><a href="#">Контакты</a></li>
					<li><a href="#">Личный кабинет</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="content">	
		<div class="block_for_messages">
		<?php
		
		if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
            echo $_SESSION["error_messages"];
 
            //Уничтожаем чтобы не выводились заново при обновлении страницы
            unset($_SESSION["error_messages"]);
        }
 
        //Если в сессии существуют успешные сообщения, то выводим их
        if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
            echo $_SESSION["success_messages"];
             
            //Уничтожаем чтобы не выводились заново при обновлении страницы
            unset($_SESSION["success_messages"]);
        }
		
		?>
		</div>
		<?php
		
			//Проверяем, если пользователь не авторизован, то выводим форму регистрации, 
		//иначе выводим сообщение о том, что он уже зарегистрирован
		if(!isset($_SESSION["email_user"]) && !isset($_SESSION["password_user"])){
		
		?>	
		<div id="formregister">
            <h3 class="auth-title">Регистрация</h3>
            <form action="register1.php" method="post" name="form_register" class="formregistr">
                <div class="formregistr_container">
				
					<p class="label_registr">Фамилия:</p>
					<input type="text" class="formregistr_input" placeholder="Введите фамилию" name="lastname_user" required="required"><br>
					
					<p class="label_registr">Имя:</p>
					<input type="text" class="formregistr_input" placeholder="Введите имя" name="firstname_user" required="required"><br>
					
					<p class="label_registr">Пол:</p>
					<div class="form_radio">
					<label for="radio4">
					<input id="radio4" type="radio" class="radio-d" value="м" name="pol_user" required="required">
					<span>Мужской<span></label><br>
					<label for="radio5">
					<input id="radio5" type="radio" class="radio-d" value="ж" name="pol_user" required="required">
					<span>Женский<span></label><br>
					</div>
					
					<p class="label_registr">Email:</p>
					<input type="email" class="formregistr_input" placeholder="Введите email" name="email_user" required="required">
					<span id="valid_email_message" class="mesage_error"></span><br>
					
					<p class="label_registr">Логин:</p>
					<input type="text" class="formregistr_input" placeholder="Введите логин" name="login_user" required="required">
					<br>
					
					<p class="label_registr">Пароль:</p>
					<input type="password" class="formregistr_input" placeholder="Введите пароль" name="password_user" required="required">
					<span id="valid_password_message" class="mesage_error"></span><br>
					
					<p class="label_registr">Дата рождения:</p>
					<input type="date" class="formregistr_input" placeholder="Введите дату рождения" name="bday_user" required="required"><br>
					<br>
					<div class="button_container">
					<button type="submit" name="btn_submit_register" class="formauth_button" value="registration">Регистрация</button>
					<button type="reset" name="btn_reset_register" class="formauth_button" value="reset">Сбросить</button>
					</div>
				</div>
			</form>
		</div>
		<?php
		}else{
		?>
        <div id="link_logout">
            <h3 class="logout-title">Вы уже зарегистрированы и авторизованы!</h3>
        </div>
		<?php
		}
		?>	
		<div id="id01" class="modal">		
			<div id="form_auth"> 
				<form action="auth.php" method="post" name="form_auth" class="formauth animate">
					
					<span onclick="document.getElementById('id01').style.display='none'" 
				class="close" title="Close Modal">&times;</span>
					
					<div class="formauth_container">
					<h3 class="auth-title">Авторизация</h3>
					
					<p class="label_registr">Email:</p>
					<input type="email" placeholder="Введите email" name="email_user" class="formauth_input" required="required">
					<span id="valid_email_message" class="mesage_error"></span><br>
					
					<p class="label_registr">Пароль:</p>
					<input type="password" placeholder="Введите пароль" name="password_user" class="formauth_input" required="required">
					<span id="valid_pasword_message" class="mesage_error"></span><br>
					
					<div class="button_container">
					<button type="submit" name="btn_submit_auth" class="formauth_button" value="authorization">Войти</button>
					<button type="reset" name="btn_reset_auth" class="formauth_button" value="reset">Сбросить</button>
					<br>
					</div>
					<p>Если Вы не зарегистрированы, пройдите на <a href="form_register.php" class="formauth_link" >форму регистрации</a>.</p>
					</div>
				</form>
			</div>
		</div>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
	</div>			
	<footer class="footer">
		<div class="some-container">
			<div class="footer-menu">
				<div class="footer-block">
					<div class="bottom-menu-header">
						<a href="propisi1.php" class="footer_a"><h3>Прописи</h3></a>
					</div>	
					<div class="bottom-menu-desc">
						<p>Информационный портал Кристины(с) 2023 Кристина, Все права защищены.</p>
						<p>Информация, размещенная на сайте, является объектом защиты авторских прав.</p>
						<p>Использовать материалы с сайта нельзя, но можно, я разрешаю :)</p>
					</div>
				</div>
				<div class="footer-block">
						<ul class="bottom-menu">
							<li><a href="propisi1.php">Справочник</a></li>
							<li><a href="#">Распознавание</a></li>
							<li><a href="#">Контакты</a></li>
						</ul>
				</div>
				<div class="footer-block">
						<ul class="bottom-menu">
							<li><a href="#">Правила и документация</a></li>
							<li><a href="#">О сайте</a></li>
							<li><a href="#">Архив</a></li>
						</ul>
				</div>
				<div class="footer-block">
						<ul class="bottom-menu">
							<li><a href="#">Личный кабинет</a></li>
							<li><a href="#">Обратная связь</a></li>
						</ul>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>