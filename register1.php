<?php
session_start();
//Добавляем файл подключения к БД
    require_once("dbconnect.php");
 
    //Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
    $_SESSION["error_messages"] = '';
 
    //Объявляем ячейку для добавления успешных сообщений
    $_SESSION["success_messages"] = '';
?>

<?php	

/* Проверяем если в глобальном массиве $_POST существуют данные отправленные из формы и заключаем переданные данные в обычные переменные.*/

if(isset($_POST["lastname_user"])){
 
    //Обрезаем пробелы с начала и с конца строки
    $lastname_user = trim($_POST["lastname_user"]);
 
    if(!empty($lastname_user)){
        // Для безопасности, преобразуем специальные символы в HTML-сущности
        $lastname_user = htmlspecialchars($lastname_user, ENT_QUOTES);
    }else{
 
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Вашу фамилию</p>";
         
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
 
        //Останавливаем  скрипт
        exit();
    }
 
     
}else{
 
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с фамилией</p>";
     
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем  скрипт
    exit();
}
 
if(isset($_POST["firstname_user"])){
     
    //Обрезаем пробелы с начала и с конца строки
    $firstname_user = trim($_POST["firstname_user"]);
 
    //Проверяем переменную на пустоту
    if(!empty($firstname_user)){
        // Для безопасности, преобразуем специальные символы в HTML-сущности
        $firstname_user = htmlspecialchars($firstname_user, ENT_QUOTES);
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваше имя</p>";
 
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
 
        //Останавливаем скрипт
        exit();
    }
 
     
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с именем</p>";
 
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем скрипт
    exit();
}

if(isset($_POST["pol_user"])){
     
	 //Обрезаем пробелы с начала и с конца строки
    $pol_user = trim($_POST["pol_user"]);
	 
    //Проверяем переменную на пустоту
    if(!empty($pol_user)){
        // Для безопасности, преобразуем специальные символы в HTML-сущности
        $pol_user = htmlspecialchars($pol_user, ENT_QUOTES);
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваш пол</p>";
 
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
 
        //Останавливаем скрипт
        exit();
    }
 
     
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с Вашим полом</p>";
 
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем скрипт
    exit();
}

 if(isset($_POST["email_user"])){
 
    //Обрезаем пробелы с начала и с конца строки
    $email_user = trim($_POST["email_user"]);
 
    if(!empty($email_user)){
 
        $email_user = htmlspecialchars($email_user, ENT_QUOTES); 
		
		
		//Проверяем нет ли уже такого адреса в БД.
$result_query = $mysqli->query("SELECT email_user FROM users WHERE email_user='".$email_user."'");
 
//Если кол-во полученных строк равно единице, значит пользователь с таким почтовым адресом уже зарегистрирован
if($result_query->num_rows == 1){
 
    //Если полученный результат не равен false
    if(($row = $result_query->fetch_assoc()) != false){
         
            // Сохраняем в сессию сообщение об ошибке. 
            $_SESSION["error_messages"] .= "<p class='mesage_error' >Пользователь с таким почтовым именем уже зарегистрирован</p>";
             
            //Возвращаем пользователя на страницу регистрации
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: form_register.php");
         
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка в запросе к БД</p>";
         
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
    }
 
    /* закрытие выборки */
    $result_query->close();
 
    //Останавливаем  скрипт
    exit();
}
 
/* закрытие выборки */
$result_query->close();
		
		
		
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваш email</p>";
         
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
 
        //Останавливаем  скрипт
        exit();
    }
 
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле для ввода email</p>";
     
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем  скрипт
    exit();
}
 
if(isset($_POST["login_user"])){
 
    //Обрезаем пробелы с начала и с конца строки
    $login_user = trim($_POST["login_user"]);
 
    if(!empty($login_user)){
 
        $login_user = htmlspecialchars($login_user, ENT_QUOTES);
 
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваш логин</p>";
         
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
 
        //Останавливаем  скрипт
        exit();
    }
 
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле для ввода логина</p>";
     
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем  скрипт
    exit();
}

if(isset($_POST["password_user"])){
 
    //Обрезаем пробелы с начала и с конца строки
    $password_user = trim($_POST["password_user"]);
 
    if(!empty($password_user)){
        $password_user = htmlspecialchars($password_user, ENT_QUOTES);
		
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Ваш пароль</p>";
         
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
 
        //Останавливаем  скрипт
        exit();
    }
 
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле для ввода пароля</p>";
     
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем  скрипт
    exit();
}

if(isset($_POST["bday_user"])){
     
    //Обрезаем пробелы с начала и с конца строки
    $bday_user = trim($_POST["bday_user"]);
 
    //Проверяем переменную на пустоту
    if(!empty($bday_user)){
        // Для безопасности, преобразуем специальные символы в HTML-сущности
        $bday_user = htmlspecialchars($bday_user, ENT_QUOTES);
    }else{
        // Сохраняем в сессию сообщение об ошибке. 
        $_SESSION["error_messages"] .= "<p class='mesage_error'>Укажите Вашу дату рождения</p>";
 
        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: form_register.php");
 
        //Останавливаем скрипт
        exit();
    }
 
     
}else{
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error'>Отсутствует поле с датой рождения</p>";
 
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем скрипт
    exit();
}
 ?>

 <?php
 
//Запрос на добавления пользователя в БД
$result_query_insert = $mysqli->query("INSERT INTO `users` (lastname_user, firstname_user, pol_user, email_user, login_user, password_user, bday_user) VALUES ('".$lastname_user."', '".$firstname_user."', '".$pol_user."', '".$email_user."', '".$login_user."', '".$password_user."', '".$bday_user."')");
 
if(!$result_query_insert){
    // Сохраняем в сессию сообщение об ошибке. 
    $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на добавления пользователя в БД</p>";
     
    //Возвращаем пользователя на страницу регистрации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_register.php");
 
    //Останавливаем  скрипт
    exit();
}else{
 
    $_SESSION["success_messages"] = "<p class='success_message'>Регистрация прошла успешно! <br>Теперь Вы можете авторизоваться используя Ваш логин и пароль.</p>";
 
    //Отправляем пользователя на страницу авторизации
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: form_auth.php");
}
 
/* Завершение запроса */
$result_query_insert->close();
 
//Закрываем подключение к БД
$mysqli->close();
		
     
?>
