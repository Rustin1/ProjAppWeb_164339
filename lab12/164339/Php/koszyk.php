<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = '164339_strona';
$link = new mysqli($dbhost, $dbuser, $dbpass, $db);

// Funkcja łącząca się z bazą danych
function polaczZBaza() {
    global $dbhost, $dbuser, $dbpass, $db;
    $polaczenie = new mysqli($dbhost, $dbuser, $dbpass, $db);

    if ($polaczenie->connect_error) {
        die("Błąd połączenia z bazą danych: " . $polaczenie->connect_error);
    }

    return $polaczenie;
}

// Funkcja dodająca produkt do koszyka
function dodajProduktDoKoszyka($idProduktu, $ilosc) {
    // Sprawdzenie, czy sesja jest rozpoczęta
    if (!isset($_SESSION['koszyk'])) {
        $_SESSION['koszyk'] = array();
    }

    // Pobranie informacji o produkcie z bazy danych
    $polaczenie = polaczZBaza();
    $rezultat = $polaczenie->query("SELECT * FROM Produkty WHERE id = '$idProduktu'");

    if ($rezultat->num_rows > 0) {
        $produkt = $rezultat->fetch_assoc();

        // Utworzenie unikalnego identyfikatora dla produktu w koszyku
        $identyfikatorProduktu = md5($idProduktu);

        // Sprawdzenie, czy produkt już istnieje w koszyku
        if (isset($_SESSION['koszyk'][$identyfikatorProduktu])) {
            // Aktualizacja ilości produktu w koszyku
            $_SESSION['koszyk'][$identyfikatorProduktu]['ilosc'] += $ilosc;
        } else {
            // Dodanie nowego produktu do koszyka
            $_SESSION['koszyk'][$identyfikatorProduktu] = array(
                'id' => $idProduktu,
                'tytul' => $produkt['tytul'], // Dodanie tytułu
				'opis' => $produkt['opis'],
				'zdjecie' => $produkt['zdjecie'],
                'ilosc' => $ilosc,
                'cenaNetto' => $produkt['cena_netto'],
                'vat' => $produkt['vat'],
            );
        }
    }

    $rezultat->free_result();
    $polaczenie->close();
}



// Funkcja usuwająca produkt z koszyka
function usunProduktZKoszyka($identyfikatorProduktu) {
    // Sprawdzenie, czy sesja jest rozpoczęta
    if (!isset($_SESSION['koszyk'])) {
        $_SESSION['koszyk'] = array();
    }

    // Sprawdzenie, czy produkt istnieje w koszyku
    if (isset($_SESSION['koszyk'][$identyfikatorProduktu])) {
        // Usunięcie produktu z koszyka
        unset($_SESSION['koszyk'][$identyfikatorProduktu]);
    }
}


// Wczytanie danych o produktach z bazy do koszyka (do wykorzystania przy starcie sesji, na przykład w pliku startowym)
function wczytajProduktyZBazyDoKoszyka() {
    // Sprawdzenie, czy sesja jest rozpoczęta
    if (!isset($_SESSION['koszyk'])) {
        $_SESSION['koszyk'] = array();
    }

    // Pobranie danych o produktach z bazy
    $polaczenie = polaczZBaza();
    $rezultat = $polaczenie->query("SELECT * FROM Produkty");

    if ($rezultat->num_rows > 0) {
        while ($produkt = $rezultat->fetch_assoc()) {
            // Zadeklarowanie zmiennej $idProduktu
            $idProduktu = $produkt['id'];

            $identyfikatorProduktu = md5($idProduktu . $produkt['tytul']);
            
            // Sprawdzenie, czy produkt już istnieje w koszyku
            if (!isset($_SESSION['koszyk'][$identyfikatorProduktu])) {
                $_SESSION['koszyk'][$identyfikatorProduktu] = array(
                    'id' => $idProduktu,
					'tytul' => $produkt['tytul'],
					'opis' => $produkt['opis'],
					'zdjecie' => $produkt['zdjecie'],
                    'ilosc' => 0, 
                    'cenaNetto' => $produkt['cena_netto'],
                    'vat' => $produkt['podatek_vat'],
                );
            }
        }
    }

    $rezultat->free_result();
    $polaczenie->close();
}


// Funkcja obliczająca łączną wartość koszyka
function obliczSumarycznaWartoscKoszyka() {
    $suma = 0;

    foreach ($_SESSION['koszyk'] as $produkt) {
        $cenaNetto = $produkt['cenaNetto'];
        $vat = $produkt['vat'];
        $ilosc = $produkt['ilosc'];

        $cenaBrutto = $cenaNetto + ($cenaNetto * ($vat / 100));
        $suma += $cenaBrutto * $ilosc;
    }

    return $suma;
}

//Funkcja zapisująca zamówienie
function zamow($link) {
	
    if (!empty($_SESSION['koszyk'])) {
        $totalAmount = obliczSumarycznaWartoscKoszyka();

        // Przykład zapisu do bazy danych (możesz dostosować do własnych potrzeb)
        $query = "INSERT INTO zamowienia (kwota, data_zamowienia) VALUES ('$totalAmount', NOW())";
        $result = $link->query($query);

        if ($result) {
            echo "Zamówienie złożone. Dziękujemy!";
            // Po zapisie zamówienia do bazy danych, możesz wyczyścić koszyk
            $_SESSION['koszyk'] = array();
        } else {
            echo "Błąd podczas składania zamówienia: " . $link->error;
        }
    } else {
        echo "Koszyk jest pusty. Nie można złożyć zamówienia.";
    }
}

// Przykładowe użycie
wczytajProduktyZBazyDoKoszyka();

// Obsługa formularza dodawania do koszyka
if (isset($_POST['submit_add_to_cart'])) {
    $idProduktu = $_POST['id'];
    $ilosc = $_POST['ilosc'];
    dodajProduktDoKoszyka($idProduktu, $ilosc);
}

// Obsługa formularza usuwania z koszyka
if (isset($_POST['submit_remove_from_cart'])) {
    $identyfikatorProduktu = $_POST['identyfikatorProduktu'];
    usunProduktZKoszyka($identyfikatorProduktu);
}


// Obsługa formularza aktualizacji ilości w koszyku
if (isset($_POST['submit_update_quantity'])) {
    $identyfikatoryAktProduktu = $_POST['identyfikatorAktProduktu'];
    $noweIlosci = $_POST['nowaIlosc'];

    foreach ($identyfikatoryAktProduktu as $key => $identyfikatorProduktu) {
        $_SESSION['koszyk'][$identyfikatorProduktu]['ilosc'] = $noweIlosci[$key];
    }
}
	


if (isset($_POST['submit_order'])) {
    zamow($link);
}
// Wyświetlanie koszyka
echo '<h2>Koszyk:</h2>';
if (!empty($_SESSION['koszyk'])) {
    echo '<form method="post" action="">';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Cena Netto</th><th>VAT</th><th>Ilość</th><th>Wartość</th><th>Zdjęcia</th></tr>';

    foreach ($_SESSION['koszyk'] as $identyfikatorProduktu => $produkt) {
        echo '<tr>';
        echo '<td>' . $produkt['id'] . '</td>';
        echo '<td>' . $produkt['tytul'] . '</td>';
		echo '<td>' . $produkt['opis'] . '</td>';
        echo '<td>' . $produkt['cenaNetto'] . '</td>';
        echo '<td>' . $produkt['vat'] . '</td>';
        echo '<td>';
        echo '<input type="hidden" name="identyfikatorAktProduktu[]" value="' . $identyfikatorProduktu . '">';
        echo '<input type="number" name="nowaIlosc[]" value="' . $produkt['ilosc'] . '" min="0">';
        echo '</td>';
        echo '<td>' . (($produkt['cenaNetto'] * (1 + $produkt['vat'] / 100)) * $produkt['ilosc']) . '</td>';
		echo '<td>';
        echo '<img src="zdjecia/' . $produkt['zdjecie'] . '" alt="Zdjęcie produktu" width="250" height="150">';
        echo '</td>';
        echo '<td>';
        echo '<input type="hidden" name="identyfikatorProduktu[]" value="' . $identyfikatorProduktu . '">';
        echo '</td>';
		
        echo '</tr>';
    }

    echo '<tr>';
    echo '<td colspan="5" align="right">Suma:</td>';
    echo '<td>' . obliczSumarycznaWartoscKoszyka() . '</td>';
    echo '<td>';
    echo '<input type="submit" name="submit_update_quantity" value="Aktualizuj koszyk">';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</form>';

    echo '<form method="post" action="">';
	 echo '<input type="submit" name="submit_clear_cart" value="Wyczyść koszyk">';
    echo '<input type="submit" name="submit_order" value="Zamów">';
    echo '</form>';
} else {
    echo 'Koszyk jest pusty.';
}



// Obsługa formularza wyczyszczenia koszyka
if (isset($_POST['submit_clear_cart'])) {
    $_SESSION['koszyk'] = array();
}

// Zamknięcie połączenia z bazą danych
$link->close();
?>