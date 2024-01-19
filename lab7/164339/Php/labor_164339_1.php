<?php
 $nr_indeksu = '164339';
 $nrGrupy = '1';
 echo 'Jakub Baranowski '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
 echo 'Zastosowanie metody include() <br />';

 $a = 2;
 $b = 3;
if ($a > $b){
	echo "a is bigger than b<br>";
}
elseif ($a == $b){
	echo "a is the same as b<br>";
}
else{
	echo"a is smaller than b<br>";
}


echo "Zastosowanie metody if<br>";

echo "A $color $producent <br>";

include 'vars.php';

echo "A $color $producent <br>";

echo 'Zastosowanie metody GET <br>';
echo 'Witaj w ' . htmlspecialchars($_GET["miejsce"]) . '!<br>';

echo 'Zastosowanie metody POST <br>';
echo 'Cześć ' . htmlspecialchars($_POST["imię"]) . '!<br>';

echo 'Zastosowanie metody SESSION <br>';
session_start();

$_SESSION['test'] = 42;
$test = 43;
echo $_SESSION['test'];



?>



