<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8" http-equiv="Content-Type"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Прописи|Отправка данных</title>
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
	 
				//Уничтожаем чтобы не появилось заново при обновлении страницы
				unset($_SESSION["error_messages"]);
			}
	 
			if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
				echo $_SESSION["success_messages"];
				 
				//Уничтожаем чтобы не появилось заново при обновлении страницы
				unset($_SESSION["success_messages"]);
			}
		?>
		</div>
		<?php
    //Проверяем, если пользователь не авторизован, то выводим форму авторизации, 
    //иначе выводим сообщение о том, что он уже авторизован
    if(!isset($_SESSION["email_user"]) && !isset($_SESSION["password_user"])){
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
<?php
    }else{
        //Если пользователь авторизован, то выводим ссылку Выход
?> 
        <div id="id01" class="modal">
			<div id="form_logout">
			<span onclick="document.getElementById('id01').style.display='none'" 
			class="close" title="Close Modal">&times;</span>
			<div id="formlogout_container">
			<h3 class="formlogout-title">Вы уже авторизованы!</h3>
            <a class="formlogout-link" href="logout.php">Выход</a>
			</div>
			</div>
		</div>
<?php
    }
?>	

		<div class="formregister">
		<h3 class="auth-title">Загрузка данных</h3>
		<?php
    //Проверяем, если пользователь авторизован, то можно отправлять, 
    //иначе выводим сообщение о том, что нельзя
    if(isset($_SESSION["email_user"]) && isset($_SESSION["password_user"])){
?>
			<form name="form" action="upload.php" method="post" enctype="multipart/form-data" class="formregistr">
				<div class="formregistr_container">
				<p class="label_upload">Загрузить изображение (не более 1б):</p>
				<input type="file" name="the_file" class="upload_button" id="fileToUpload" accept="image/*" ><br>
				<p class="label_upload">Введите число, соответствующее букве по этому правилу:</p>
				<p class="alf_upload">А = 1, Б = 2, В = 3, Г = 4, Д = 5, Д = 6 и т.д.</p>
				<p class="label_upload">Введите число:</p>
				<input type="text" name="sym_marker" id="numberToUpload" class="formregistr_input" placeholder="Введите число от 1 до 6" required="required">
				<br>
				<div class="button_container">
				<input type="submit" name="submit" value="Загрузить" class="formauth_button"><br>
				<button type="reset" name="btn_reset_register" class="formauth_button" value="reset">Сбросить</button>
				</div>
				</div>
			</form>
				
				<?php
    }else{
        //Если пользователь не авторизован, то выводим ссылку на регистрацию
?> 
				
				<div class="registr_container">
				<p class="label_upload">Пожалуйста, авторизуйтесь или пройдите на <a href="form_register.php" class="formauth_link" >форму регистрации</a>!</p>
				</div>
				<?php
    }
?>	
				
		</div>
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
							<li><a href="#">Справочник</a></li>
							<li><a href="propisi1.php">Распознавание</a></li>
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