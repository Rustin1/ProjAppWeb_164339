<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = '164339_strona';
$link = new mysqli($dbhost, $dbuser, $dbpass, $db);

function DodajKategorie($matka, $nazwa) {
    global $link;

    $query = "INSERT INTO kategorie (matka, nazwa) VALUES ('$matka', '$nazwa')";

    if ($link->query($query) === TRUE) {
        echo "Dodano nową kategorię.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

function UsunKategorie($kategoria_id) {
    global $link;

    $query = "DELETE FROM kategorie WHERE id = '$kategoria_id'";

    if ($link->query($query) === TRUE) {
        echo "Usunięto kategorię.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

function EdytujKategorie($kategoria_id, $nowa_nazwa) {
    global $link;

    $query = "UPDATE kategorie SET nazwa = '$nowa_nazwa' WHERE id = '$kategoria_id'";

    if ($link->query($query) === TRUE) {
        echo "Zaktualizowano kategorię.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

function PokazKategorie($matka) {
    global $link;

    $query = "SELECT * FROM kategorie";
    $result = $link->query($query);

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Matka</th><th>Nazwa</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['matka'] . '</td>';
            echo '<td>' . $row['nazwa'] . '</td>';
            echo '</tr>';
        }        
        echo '</table>';
    } else {
        echo 'Brak kategorii.';
    }
}


function DodajNowaKategorie($link) {
    echo '
    <h2>Dodaj Nową Kategorię:</h2>
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <label for="matka">Kategoria nadrzędna (matka):</label>
        <input type="text" id="matka" name="matka"><br>

        <label for="nazwa">Nazwa Kategorii:</label>
        <input type="text" id="nazwa" name="nazwa" required><br>

        <input type="submit" name="dodaj_nowa_kategorie" value="Dodaj Nową Kategorię">
    </form>
    ';

    if (isset($_POST['dodaj_nowa_kategorie'])) {
        if (isset($_POST['matka'], $_POST['nazwa'])) {
            $matka = $_POST['matka'];
            $nazwa = $_POST['nazwa'];

            $matka = $link->real_escape_string($matka);
            $nazwa = $link->real_escape_string($nazwa);

            $query = "INSERT INTO kategorie (matka, nazwa) VALUES ('$matka', '$nazwa')";

            if ($link->query($query) === TRUE) {
                echo "Dodano nową kategorię pomyślnie.";
                header("Location: {$_SERVER['REQUEST_URI']}");
                exit();
            } else {
                echo "Błąd zapytania SQL: " . $link->error;
            }
        } else {
            echo "Błąd: Wymagane pole nazwa jest puste.";
        }
    }
}

function UsunKategorieForm($link) {
    echo '
    <h2>Usuń Kategorię:</h2>
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <label for="kategoria_id_usun">ID Kategorii do usunięcia:</label>
        <input type="text" id="kategoria_id_usun" name="kategoria_id_usun" required><br>

        <input type="submit" name="usun_kategorie" value="Usuń Kategorię">
    </form>
    ';
}

function EdytujKategorieForm($link) {
    echo '
    <h2>Edytuj Kategorię:</h2>
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <label for="kategoria_id">ID Kategorii:</label>
        <input type="text" id="kategoria_id" name="kategoria_id" required><br>

        <label for="nowa_nazwa">Nowa Nazwa Kategorii:</label>
        <input type="text" id="nowa_nazwa" name="nowa_nazwa" required><br>

        <input type="submit" name="edytuj_kategorie" value="Edytuj Kategorię">
    </form>
    ';
}

function UsunKategorieAction($link) {
    if (isset($_POST['usun_kategorie'])) {
        if (isset($_POST['kategoria_id_usun'])) {
            $kategoria_id_usun = $_POST['kategoria_id_usun'];
            $kategoria_id_usun = $link->real_escape_string($kategoria_id_usun);

            $query = "DELETE FROM kategorie WHERE id='$kategoria_id_usun' LIMIT 1";

            if ($link->query($query) === TRUE) {
                echo "Kategoria została pomyślnie usunięta!";
            } else {
                echo "Błąd zapytania SQL: " . $link->error;
            }
        } else {
            echo "Błąd: Pole ID kategorii do usunięcia jest puste.";
        }
    }
}

function EdytujKategorieAction($link) {
    if (isset($_POST['edytuj_kategorie'])) {
        if (isset($_POST['kategoria_id'], $_POST['nowa_nazwa'])) {
            $kategoria_id = $_POST['kategoria_id'];
            $nowa_nazwa = $_POST['nowa_nazwa'];

            $kategoria_id = $link->real_escape_string($kategoria_id);
            $nowa_nazwa = $link->real_escape_string($nowa_nazwa);

            $query = "UPDATE kategorie SET nazwa='$nowa_nazwa' WHERE id='$kategoria_id'";

            if ($link->query($query) === TRUE) {
                echo "Zaktualizowano kategorię pomyślnie!";
            } else {
                echo "Błąd zapytania SQL: " . $link->error;
            }
        } else {
            echo "Błąd: Wymagane pole ID kategorii lub nowa nazwa są puste.";
        }
    }
}

if (isset($_POST['dodaj_nowa_kategorie'])) {
    DodajNowaKategorie($link);
}

if (isset($_POST['usun_kategorie'])) {
    UsunKategorieAction($link);
}

if (isset($_POST['edytuj_kategorie'])) {
    EdytujKategorieAction($link);
}

DodajNowaKategorie($link);
UsunKategorieForm($link);
EdytujKategorieForm($link);
PokazKategorie(0, $link);

$link->close();
?>