<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['confirmed'])) {
    $_SESSION['confirmed'] = false;
}

include("php/cfg.php");

$cfgpass = $pass;
$cfglogin = $login;

// Establish database connection
$conn = GetConn();

function FormularzLogowania()
{
    $wynik = '
    <div class="logowanie">
        <h1 class="heading">Panel CMS:</h1>
        <div class="logowanie">
            <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                <table class="logowanie">
                    <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                    <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
                    <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    ';
    return $wynik;
}

function ListaPodstron(){
        $conn = GetConn();
        $query="SELECT * FROM page_list LIMIT 100";
        $result = mysqli_query($conn,$query);
        echo '<form method="post" encrype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'"><table>';
        while($row = mysqli_fetch_array($result)){
            echo '<tr><td>'.$row['id'].'</td><td>'.$row['name'].
                '</td><td><button type="submit" name="usun" class="logowanie" value="'.$row['id'].'"/>usuń</button>'.
                '</td><td><button type="submit" name="edytuj" class="logowanie" value="'.$row['id'].'">edytuj</button></td></tr>';
        }
        echo '</table></form>';
    }

function EdytujPodstrone($id){
        $query='SELECT * FROM page_list WHERE id = '.$id;
        $row;
        if($id == 0){
            $row = [
                "id" => 0,
                "name" => "",
                "page_content" => "",
                "is_active" => 0
            ];
        }
        else{
            $conn = GetConn();
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_array($result);
        }
        $dodaj = "";
        if($row['is_active'] == 1){
            $dodaj = " checked";
        }
        $content = $row['page_content'];
        return '
        <div class="logowanie">
         <div class="logowanie">
          <form method="post" encrype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
           <table class="logowanie">
           <input type="hidden" name="id" value="'.$row['id'].'" />
            <tr><td class="log4_t">[tytuł]</td><td><input type="text" name="tytul" class="logowanie" required value="'.$row['name'].'"/></td></tr>
            <tr><td class="log4_t">[zawartość]</td><td><textarea name="content" class="logowanie" required>'.$row['page_content'].'</textarea></td></tr>
            <tr><td class="log4_t">[status]</td><td><input type="checkbox" name="is_active" class="logowanie"'.$dodaj.'/></td></tr>
            <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="Wyślij"/></td></tr>
           </table>
          </form>
         </div>
        </div>
        ';
    }
	{
	  echo '<form method="post" action="' . htmlspecialchars($_SERVER['REQUEST_URI']) . '">';
    echo '<input type="submit" name="dodajNowaPodstrone" value="Dodaj nową podstronę">';
    echo '</form>';
}

function DodajNowaPodstrone()
{
    global $conn; // Use the global connection

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodajNowaPodstrone'])) {
        if (isset($_POST['tytul'], $_POST['tresc'], $_POST['aktywna'])) {
            $tytul = $_POST['tytul'];
            $tresc = $_POST['tresc'];
            $aktywna = isset($_POST['aktywna']) ? 1 : 0;

            // Use prepared statement to prevent SQL Injection
            $query = "INSERT INTO page_list (name, page_content, is_active) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("ssi", $tytul, $tresc, $aktywna);
                $stmt->execute();

                if ($stmt->errno) {
                    die('Error in INSERT query: ' . $stmt->error);
                }

                // Check if the insertion was successful
                if ($stmt->affected_rows > 0) {
                    echo 'Pomyślnie dodano nową podstronę.';
                } else {
                    echo 'Nie udało się dodać nowej podstrony.';
                }

                $stmt->close();
            } else {
                die('Error in preparing INSERT query: ' . $conn->error);
            }
        }
    }

    // Display the form for adding a new subpage
    echo '<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">';
    echo 'Tytuł: <input type="text" name="tytul"><br>';
    echo 'Treść: <textarea name="tresc"></textarea><br>';
    echo 'Aktywna: <input type="checkbox" name="aktywna"><br>';
    echo '<input type="submit" name="dodajNowaPodstrone" value="Dodaj">';
    echo '</form>';
}


function UsunPodstrone($id)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $db = '164339_strona';

    $link = new mysqli($dbhost,$dbuser,$dbpass,$db);
    $query="DELETE FROM page_list WHERE id='$id'";
    mysqli_query($link, $query);
}
function CheckPost($val){
        if(isset($_POST[$val])){
            return true;
        }
        return false;
    }



if (isset($_POST['login_email'])) {
    if (isset($_POST['login_pass'])) {
        if ($_POST['login_email'] == $cfglogin && $_POST['login_pass'] == $cfgpass) {
            $_SESSION['confirmed'] = true;
        }
    }
}

if (isset($_POST['wylogowywanie'])) {
    $_SESSION['confirmed'] = false;
}

if ($_SESSION['confirmed']) {
    ListaPodstron();
    echo "<form method='post' action='" . $_SERVER['REQUEST_URI'] . "'><input type='submit' name='wylogowywanie' value='wyloguj'></form>";
} else {
    echo FormularzLogowania();
}

if (isset($_POST['usun'])) {
    $id_to_delete = $_POST['usun'];
    UsunPodstrone($id_to_delete);
}

if(isset($_POST['edytuj'])){
            echo EdytujPodstrone($_POST['edytuj']);
        }

elseif(CheckPost('id') and CheckPost('tytul') and CheckPost('content')){
            $conn = GetConn();
            $bool = 0;
            if(isset($_POST['is_active'])){
                $bool = 1;
            }
            $query = "";
            if($_POST['id'] == 0){
                $query = 'INSERT INTO page_list(name, page_content, is_active) VALUES("'.addslashes($_POST['tytul']).'","'.addslashes($_POST['content']).'",'.$bool.');';
            }
            else{
                $query='UPDATE page_list SET name="'.addslashes($_POST['tytul']).'",page_content="'.addslashes($_POST['content']).'",is_active='.$bool.' WHERE id='.$_POST['id'].' LIMIT 1';
            }
            $result = mysqli_query($conn, $query);
            if($result) {
                echo "Record updated successfully";
            }
            else {
                echo "Error";
            }
            ListaPodstron();
        }  
// Add a condition to invoke the DodajNowaPodstrone function
if (isset($_POST['dodajNowaPodstrone'])) {
    DodajNowaPodstrone();
}

// Close the database connection
$conn->close();
?>
