<?php
header('Content-Type: text/html; charset=cp1251');
?>

<!-- <!DOCTYPE html>
	<head>
		<meta charset="utf-8"/>
		<title>Чарсет-хуярсет</title>
	</head> -->


<?php
echo "<h1>This is PhP!</h1>";

echo "<h2> Completed </h2>";


//$handle = fopen("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt", "r");

//echo $handle;

//fclose($handle);

//работает, но надо расшифровать
$pathToFile = "C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt";
echo '<pre>';
readfile($pathToFile);
echo '</pre>';

//тоже
//$pathToFile = "C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt";
//if (file_exists($pathToFile)) {
//    $GetContentFile = file_get_contents($pathToFile);
//    echo $GetContentFile;}
//тоже
//$myfile = fopen("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt", "r");
//echo '<pre>';
//echo fread($myfile,filesize("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt"));
//fclose($myfile);
//echo '</pre>';

//работает
//foreach (glob("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt") as $filename) {   
//    $file = $filename;
//    $contents = file($file); 
//    $string = implode("<br>", $contents); 
//    echo $string;
//    echo "<br>";
//или
//	echo "<br><br>";
//}

//работает
//foreach (glob("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt") as $filename) {   
//    echo nl2br(file_get_contents($filename));
//    echo "<br>";
//}
//работает
//foreach (glob("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt") as $filename) { 
//  $str = file_get_contents($filename);
//  echo preg_replace('!\r?\n!', '<br>', $str);
//}
//работает, но выводит формат данных и зашифрованные символы
//$arr = file('C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt');
//echo '<pre>';
//var_dump($arr);
//echo '</pre>';
//тоже
//$data = file_get_contents('C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt');
//echo '<pre>';
//var_dump($data);
//echo '</pre>';

//ну хз
//echo(implode("<br>", $lines));



?>