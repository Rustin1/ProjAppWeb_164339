<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	
	ini_set( 'error_reporting', E_ALL );
	ini_set( 'display_errors', true );
	/* po tym komentarzu będzie kod do dynamicznego ładowania stron */
	$strona = 'html/Strona_Główna.html';
    include('php/cfg.php');
    include('php/showpage.php');
    // if(isset($_GET['idp'])){
        // if($_GET['idp'] == 'Strona_Główna') $strona = 'html/Strona_Główna.html';
        // if($_GET['idp'] == 'Podstawy') $strona = 'html/Podstawy.html';
        // if($_GET['idp'] == 'Instrumenty') $strona = 'Instrumenty';
        // if($_GET['idp'] == 'Tabulatury') $strona = 'Tabulatury';
        // if($_GET['idp'] == 'Akordy') $strona = 'Akordy';
        // if($_GET['idp'] == 'Kontakt') $strona = 'Kontakt';
    // }
	
   $conn = GetConn();
    
    
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
        <meta name="version" content="1.5">
		<link rel="stylesheet" type="text/css" href="Css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="js/kolorujto.js" type="text/javascript"></script>
        <script src="js/timedate.js" type="text/javascript"></script>
	</head>
	<body  onload="startclock()">
	<h1  style="color:black;"> Moje hobby to muzyka</h1>
	<div id="animacjaTestowa1" class="test-block">Kliknij, a się powiększe</div>
	
		<script>
		
		$("#animacjaTestowa1").on("click", function(){
			$(this).animate({
				width:"500px",
				opacity: 0.4,
				fontSize: "3em",
				borderwidth: "10px"
				}, 1500);
				});
				
		</script>
		
	<div id="animacjaTestowa2" class="test-block">Najedź kursorem, a się powiększe</div>
	
		<script>
		
		$("#animacjaTestowa2").on({
			"mouseover" : function(){
				$(this).animate({
					width: 300,
				}, 800);
		},
				"mouseout" : function(){
				$(this).animate({
					width: 200,
				}, 800);
		}
});				
		</script>
	<div id="animacjaTestowa3" class="test-block">Klikaj abym urósł</div>
	<script>
	$("#animacjaTestowa3").on("click", function(){
		if(!$(this).is(":animated")){
			$(this).animate({
			width: "+=" + 50,
			height: "+=" + 10,
			opacity: "+=" + 0.1,
			duration : 3000
		});
	}
});
	</script>
	<div id ="zegarek"></div>
	<div id="data"></div>
	
	<table>
		<tr>
            <th><a href="?id=1"> Strona Główna </a></th>
			<th><a href="?id=2"> Kontakt </a></th>
			<th><a href="?id=3">Podstawy </a></th>
			<th><a href="?id=4">Instrumenty </a></th>
			<th><a href="?id=5">Tabulatury </a></th>
			<th><a href="?id=6">Akordy </a></th>
			<th><a href="?id=7">Video </a></th>
		</tr>
	</table>
	
    <FORM METHOD="POST" NAME="background">
		<INPUT TYPE="button" VALUE="żółty" ONCLICK="changeBackground('#FFF000')">
		<INPUT TYPE="button" VALUE="czarny" ONCLICK="changeBackground('000000')">
		<INPUT TYPE="button" VALUE="biały" ONCLICK="changeBackground('#FFFFFF')">
		<INPUT TYPE="button" VALUE="zielony" ONCLICK="changeBackground('#00FF00')">
		<INPUT TYPE="button" VALUE="niebieski" ONCLICK="changeBackground('#0000FF')">
		<INPUT TYPE="button" VALUE="pomarańczowy" ONCLICK="changeBackground('#FF8000')">
		<INPUT TYPE="button" VALUE="szary" ONCLICK="changeBackground('#c0c0c0')">
		<INPUT TYPE="button" VALUE="czerwony" ONCLICK="changeBackground('#FF0000')">
	</FORM>
	
	<?php
	
      if(isset($_GET['id'])){
        echo PokazPodstrone($_GET['id'],$conn);
    }
    else{
        echo PokazPodstrone(1,$conn);
    }  
    ?>
	
	</body>
</html>
