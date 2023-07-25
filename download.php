<?php
  if(isset($_POST['download_submit'])) {
	  header('Content-Type: application/download; charset=utf-8');
	  header('Content-Disposition: attachment; filename="Result.pdf"');
	  header("Content-Length: " . filesize("C:/xampp/htdocs/www/neuropropisi/received_files/Result_output.pdf"));
	  $fp = fopen("C:/xampp/htdocs/www/neuropropisi/received_files/Result_output.pdf", "r");
	  fpassthru($fp);
	  fclose($fp);
  }
  ?>