<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	
	ini_set( 'error_reporting', E_ALL );
	ini_set( 'display_errors', true );
	/* po tym komentarzu będzie kod do dynamicznego ładowania stron */
	$strona = 'html/main.html';
	if($_GET['idp'] == '') $strona = 'html/Strona_Głowna.html';
	if($_GET['idp'] == 'Akordy') $strona = 'html/Akordy.html';
	if($_GET['idp'] == 'Instrumenty') $strona = 'html/Instrumenty.html';
	if($_GET['idp'] == 'Podstawy_Muzyki') $strona = 'html/Podstawy_Muzyki.html';
	if($_GET['idp'] == 'Tabulatury') $strona = 'html/Tabulatury.html';
	if($_GET['idp'] == 'Kontakt') $strona = 'html/Kontakt.html';
	
	
	include($strona);
	$nr_indeksu = '164339';
	$nrGrupy = '1';
	
	echo('Autor: Jakub Baranowski '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />');
?>

<html>
	<head>
		<title>Moje hobby to muzyka</title>
		<link rel="icon" type="image/png" href="img/icon.png">
		<meta name="keywords" content="muzyka">
		<meta name="author" content="Jakub Baranowski">
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="pl" />
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="js/kodzik.js" type="text/javascript"></script>
	</head>
	<body>
	<?php
		echo("<script>loadsite()</script>");
	?>
	</body>
</html>

