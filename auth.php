<?php
        //Запускаем сессию
        session_start();
 
        //Добавляем файл подключения к БД
        require_once("dbconnect.php");
		
		//Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
$_SESSION["error_messages"] = '';
 
//Объявляем ячейку для добавления успешных сообщений
$_SESSION["success_messages"] = '';
?>

<?php
/*
    Проверяем была ли отправлена форма, то есть была ли нажата кнопка Войти. Если да, то идём дальше, если нет, то выведем пользователю сообщение об ошибке, о том что он зашёл на эту страницу напрямую.
*/
if(isset($_POST["btn_submit_auth"]) && !empty($_POST["btn_submit_auth"])){
 
 if(isset($_POST["email_user"])){
    
	//Обрезаем пробелы с начала и с конца строки
$email_user = trim($_POST["email_user"]);

 
    if(!empty($email_user)){
        $email_user = htmlspecialchars($email_user, ENT_QUOTES);
 
        
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Поле для ввода email не должно быть пустым.</p>";
         
        //Возвращаем пользователя на страницу авторизации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_auth.php");
 
        //Останавливаем скрипт
        exit();
    }
     
 
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода email</p>";
     
    //Возвращаем пользователя на страницу авторизации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_auth.php");
 
    //Останавливаем скрипт
    exit();
}
 

if(isset($_POST["password_user"])){
 
    //Обрезаем пробелы с начала и с конца строки
    $password_user = trim($_POST["password_user"]);
 
    if(!empty($password_user)){
        $password_user = htmlspecialchars($password_user, ENT_QUOTES); 
 
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш пароль</p>";
         
        //Возвращаем пользователя на страницу авторизации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_auth.php");
 
        //Останавливаем скрипт
        exit();
    }
     
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода пароля</p>";
     
    //Возвращаем пользователя на страницу авторизации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_auth.php");
 
    //Останавливаем скрипт
    exit();
}    
	
	
//Запрос в БД на выборке пользователя.
$result_query_select = $mysqli->query("SELECT * FROM `users` WHERE email_user = '".$email_user."' AND password_user = '".$password_user."'");
 
if(!$result_query_select){
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на выборке пользователя из БД</p>";
     
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_auth.php");
 
    //Останавливаем скрипт
    exit();
}else{
 
    //Проверяем, если в базе нет пользователя с такими данными, то выводим сообщение об ошибке
    if($result_query_select->num_rows == 1){
         
        // Если введенные данные совпадают с данными из базы, то сохраняем email и пароль в массив сессий.
        $_SESSION['email_user'] = $email_user;
        $_SESSION['password_user'] = $password_user;
 
        //Возвращаем пользователя на главную страницу
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: propisi1.php");
 
    }else{
         
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Неправильный email и/или пароль</p>";
         
        //Возвращаем пользователя на страницу авторизации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_auth.php");
 
        //Останавливаем скрипт
        exit();
    }
}	
    
 
}else{
    exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на главную страницу </a>.</p>");
}
?>