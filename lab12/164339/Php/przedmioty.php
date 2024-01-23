<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = '164339_strona';
$link = new mysqli($dbhost, $dbuser, $dbpass, $db);

function DodajProdukt($tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie) {
    global $link;

    $query = "INSERT INTO produkty (tytul, opis, cena_netto, podatek_vat, ilosc_dostepnych_sztuk, status_dostepnosci, kategoria, gabaryt_produktu, zdjecie) 
              VALUES ('$tytul', '$opis', '$cena_netto', '$vat', '$ilosc', '$status', '$kategoria', '$gabaryt', '$zdjecie')";

    if ($link->query($query) === TRUE) {
        echo "Dodano nowy produkt.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

function handleFileUpload($file) {
    $target_dir = "zdjecia/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;

    if (file_exists($target_file)) {
        echo "Plik już istnieje.";
        $uploadOk = 0;
    }

    if ($file["size"] > 500000) {
        echo "Plik jest za duży.";
        $uploadOk = 0;
    }

    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    $fileFormat = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($fileFormat, $allowedFormats)) {
        echo "Ten format nie jest obsługiwany.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Plik nie został zuploadowany.";
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            echo "plik " . basename($file["name"]) . " został zuploadowany.";
            return basename($file["name"]);
        } else {
            echo "Wystąpił problem w trakcie uploadu pliku.";
        }
    }

    return null;
}

function UsunProdukt($produkt_id) {
    global $link;

    $query = "DELETE FROM produkty WHERE id = '$produkt_id'";

    if ($link->query($query) === TRUE) {
        echo "Usunięto produkt.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

function EdytujProdukt($produkt_id, $tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie) {
    global $link;

    $query = "UPDATE produkty SET 
              tytul='$tytul', opis='$opis', cena_netto='$cena_netto', podatek_vat='$vat', ilosc_dostepnych_sztuk='$ilosc', 
              status_dostepnosci='$status', kategoria='$kategoria', gabaryt_produktu='$gabaryt', zdjecie='$zdjecie' WHERE id='$produkt_id'";

    if ($link->query($query) === TRUE) {
        echo "Zaktualizowano produkt.";
    } else {
        echo "Błąd zapytania SQL: " . $link->error;
    }
}

function PokazProdukty() {
    global $link;

    $query = "SELECT * FROM produkty";
    $result = $link->query($query);

    if ($result) {
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Cena Netto</th><th>VAT</th><th>Ilość</th><th>Status</th><th>Kategoria</th><th>Gabaryt</th><th>Zdjęcie</th><th>Akcje</th></tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.$row['id'].'</td>';
            echo '<td>'.$row['tytul'].'</td>';
            echo '<td>'.$row['opis'].'</td>';
            echo '<td>'.$row['cena_netto'].'</td>';
            echo '<td>'.$row['podatek_vat'].'</td>';
            echo '<td>'.$row['ilosc_dostepnych_sztuk'].'</td>';
            echo '<td>'.$row['status_dostepnosci'].'</td>';
            echo '<td>'.$row['kategoria'].'</td>';
            echo '<td>'.$row['gabaryt_produktu'].'</td>';
            echo '<td>';
            echo '<img src="zdjecia/' . $row['zdjecie'] . '" alt="Zdjęcie produktu" width="250" height="150">';
            echo '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<input type="submit" name="delete" value="Usuń">';
            echo '</form>';

            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id" value="'.$row['id'].'">';
            echo '<input type="hidden" name="tytul" value="'.$row['tytul'].'">';
            echo '<input type="hidden" name="opis" value="'.$row['opis'].'">';
            echo '<input type="hidden" name="cena_netto" value="'.$row['cena_netto'].'">';
            echo '<input type="hidden" name="vat" value="'.$row['podatek_vat'].'">';
            echo '<input type="hidden" name="ilosc" value="'.$row['ilosc_dostepnych_sztuk'].'">';
            echo '<input type="hidden" name="status" value="'.$row['status_dostepnosci'].'">';
            echo '<input type="hidden" name="kategoria" value="'.$row['kategoria'].'">';
            echo '<input type="hidden" name="gabaryt" value="'.$row['gabaryt_produktu'].'">';
            echo '<input type="hidden" name="zdjecie" value="'.$row['zdjecie'].'">';
            echo '<input type="submit" name="edit" value="Edytuj">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '<tr>';
        echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="submit" name="submit_add1" value="Dodaj Produkt">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    } else {
        echo 'Brak produktów.';
    }
}

// Handling form submission for deleting
if (isset($_POST['delete'])) {
    echo '<h2>Usuń Produkt:</h2>';
    echo '
    <form method="post" action="">
        <input type="hidden" name="id" value="'.$_POST['id'].'">
        Czy na pewno chcesz usunąć ten produkt?<br>
        <input type="submit" name="submit_delete" value="Tak">
        <input type="submit" name="cancel" value="Anuluj">
    </form>
    ';
}

// Handling form submission for editing
if (isset($_POST['edit'])) {
    echo '<h2>Edytuj Produkt:</h2>';
    echo '
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="'.$_POST['id'].'">

        <label for="tytul">Tytuł:</label>
        <input type="text" id="tytul" name="tytul" value="'.$_POST['tytul'].'" required><br>

        <label for="opis">Opis:</label>
        <textarea id="opis" name="opis" required>'.$_POST['opis'].'</textarea><br>

        <label for="cena_netto">Cena Netto:</label>
        <input type="text" id="cena_netto" name="cena_netto" value="'.$_POST['cena_netto'].'" required><br>

        <label for="vat">VAT:</label>
        <input type="text" id="vat" name="vat" value="'.$_POST['vat'].'" required><br>

        <label for="ilosc">Ilość:</label>
        <input type="text" id="ilosc" name="ilosc" value="'.$_POST['ilosc'].'" required><br>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="'.$_POST['status'].'" required><br>

        <label for="kategoria">Kategoria:</label>
        <input type="text" id="kategoria" name="kategoria" value="'.$_POST['kategoria'].'" required><br>

        <label for="gabaryt">Gabaryt:</label>
        <input type="text" id="gabaryt" name="gabaryt" value="'.$_POST['gabaryt'].'" required><br>

        <label for="zdjecie">Zdjęcie:</label>
        <input type="file" id="zdjecie" name="zdjecie" accept="image/*"><br>

        <input type="submit" name="submit_edit" value="Zapisz Edycję">
    </form>
    ';
}
// Handling form submission for adding
if (isset($_POST['submit_add1'])) {
    echo '<h2>Dodaj Produkt:</h2>';
    echo '
    <form method="post" action="" enctype="multipart/form-data">
        <label for="tytul">Tytuł:</label>
        <input type="text" id="tytul" name="tytul"><br>

        <label for="opis">Opis:</label>
        <textarea id="opis" name="opis"></textarea><br>

        <label for="cena_netto">Cena Netto:</label>
        <input type="text" id="cena_netto" name="cena_netto"><br>

        <label for="vat">VAT:</label>
        <input type="text" id="vat" name="vat"><br>

        <label for="ilosc">Ilość:</label>
        <input type="text" id="ilosc" name="ilosc"><br>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status"><br>

        <label for="kategoria">Kategoria:</label>
        <input type="text" id="kategoria" name="kategoria"><br>

        <label for="gabaryt">Gabaryt:</label>
        <input type="text" id="gabaryt" name="gabaryt"><br>

        <label for="zdjecie">Zdjęcie:</label>
        <input type="file" id="zdjecie" name="zdjecie" accept="image/*"><br>

        <input type="submit" name="submit_add" value="Dodaj produkt">
    </form>
    ';
}


// Handling form submission for deleting
if (isset($_POST['submit_delete'])) {
    $produkt_id = $_POST['id'];
    UsunProdukt($produkt_id);
}

// Handling form submission for editing
if (isset($_POST['submit_edit'])) {
    $produkt_id = $_POST['id'];
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $cena_netto = $_POST['cena_netto'];
    $vat = $_POST['vat'];
    $ilosc = $_POST['ilosc'];
    $status = $_POST['status'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];
    $zdjecie = $_FILES['zdjecie']['name'];

    if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === UPLOAD_ERR_OK) {
        $zdjecie = $_FILES['zdjecie']['name'];

        $target_dir = "zdjecia/";
        $target_file = $target_dir . basename($_FILES["zdjecie"]["name"]);
        move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $target_file);
    } else {
        $zdjecie = "";
    }

    EdytujProdukt($produkt_id, $tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
}

// Handling form submission for adding a new product
if (isset($_POST['submit_add'])) {
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $cena_netto = $_POST['cena_netto'];
    $vat = $_POST['vat'];
    $ilosc = $_POST['ilosc'];
    $status = $_POST['status'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];
    $zdjecie = handleFileUpload($_FILES['zdjecie']);

    DodajProdukt($tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
} 

// Display products
PokazProdukty();

// Close the database connection
$link->close();
?>
