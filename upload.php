<?php
session_start();
//Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
    $_SESSION["error_messages"] = '';
?>
<!DOCTYPE html>
<head>
	<head>
    <meta charset="UTF-8" http-equiv="Content-Type"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Прописи|Результат</title>
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
<?php
    $currentDirectory = getcwd();
    $uploadDirectory = "/upload_files/";

    $errors = []; // Store errors here
	// попробовать дальше выводить без скобок
	// поменять if (!empty($_POST)) и if (isset($_POST['submit'])) местами
    $fileExtensionsAllowed = ['jpeg','jpg','png']; // These will be the only file extensions allowed 

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
	//$symbolmarker = $sym_marker;
	$tmp = explode('.',$fileName);
	$tmpend = end($tmp);
	$fileExtension = strtolower($tmpend);
    //$fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 
?>
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

		<div class="inform_content">
		<h3 class="auth-title">Результаты</h3>
			<div class="info_content">
<?php
    if (!empty($_POST)) {
		if (isset($_POST['submit'])) {
			if (! in_array($fileExtension,$fileExtensionsAllowed)) {
				$errors[] = "Недопустимый формат файла или отсутствие файла!". "<br>";
			}
			if ($fileSize > 1000000) {
				$errors[] = "Превышен максимальный размер файла (1MB)!". "<br>";
			}
				
			if (!empty($_POST['sym_marker'])) {
				if (!is_numeric($_POST['sym_marker'])) {
					$errors[] = "Поле содержит не цифры!". "<br>";
				} else {
					$sym_marker = htmlspecialchars($_POST['sym_marker']);
				}
			} else {
				// Сохраняем в сессию сообщение об ошибке. 
				$_SESSION["error_messages"] .= "<p class='mesage_error'>Введите числовое значение!</p>";
					 
				//Возвращаем пользователя на страницу регистрации
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: upload.php");
			 
				//Останавливаем  скрипт
				exit();
			}
			
			if (empty($errors)) {
				$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
				
				if ($didUpload) {
					?>
					<p class="info_download">
					<?php echo "Файл " . basename($fileName) . " загружен". "<br>"; ?>
					</p>
					</div>
					<div class="file_content">
<?php
	//echo $sym_marker;

	//system('"D:/Microsoft Visual Studio/Python39_64/python.exe" nnalphabet1.py '. $sym_marker);
	//system('"D:/Microsoft Visual Studio/Python39_64/python.exe" test1.py '. $sym_marker);
	
	
	$pathToFile = "C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt";
	if (file_exists($pathToFile)) {
		$GetContentFile = file_get_contents($pathToFile); ?>
					<p class="info_download">
					<?php
					echo '<pre>';
					echo $GetContentFile;
					echo '</pre>';} ?>
					</p>
					</div>
					<div class="download_button">
					<p class="info_download">Скачать результаты с загруженным изображением в pdf?</p>
						<form name="form1" class="download_form" action="download.php" method="post">
							<input type="submit" name="download_submit" class="formauth_button" value="Скачать"><br><br>
						</form>
					</div>
					
					<?php
				} else {
					echo "Ошибка загрузки!". "<br>";
				}
			} else {
				foreach ($errors as $error) {
					echo $error . "Ошибка" . "<br>";
				}
			}
		
		}
	  
	}else{
		// Сохраняем в сессию сообщение об ошибке. 
		$_SESSION["error_messages"] .= "<p class='mesage_error'>Пустые поля!</p>";
			 
		//Возвращаем пользователя на страницу регистрации
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: upload.php");
		
		//Останавливаем  скрипт
		exit();
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