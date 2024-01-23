<?php

function PokazKontakt()
{
    // Wyświetla formularz kontaktowy
    echo '<form method="post" action="">
            Temat: <input type="text" name="temat"><br>
            Treść: <textarea name="tresc"></textarea><br>
            Email: <input type="email" name="email"><br>
            <input type="submit" name="action" value="WyslijMailaKontakt">
          </form>';
}

function PrzypomnijHaslo()
{
    // Wyświetla formularz przypomnienia hasła
    echo '<form method="post" action="">
            Podaj swój email: <input type="email" name="email"><br>
            <input type="submit" name="action" value="PrzypomnijHaslo">
          </form>';
}

function WyslijMailaKontakt($odbiorca)
{
    // Wysyła email z formularza kontaktowego
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        PokazKontakt(); // Ponowne wyświetlenie formularza kontaktowego
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['recipent'] = $odbiorca; // Jesteś odbiorcą, jeśli tworzysz formularz kontaktowy

        $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding:\n";
        $header .= "X-Sender: <" . $mail['sender'] . ">\n";
        $header .= "X-Mailer: PRapWWW mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <" . $mail['subject'] . ">\n";

        mail($mail['recipent'], $mail['subject'], $mail['body'], $header);

        echo '[wiadomosc_wyslana]';
    }
}

// Przykładowe użycie:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sprawdza, czy formularz został przesłany
    if (isset($_POST['action'])) {
        // Sprawdza, która akcja jest żądana
        if ($_POST['action'] === 'WyslijMailaKontakt') {
            WyslijMailaKontakt('twoj@email.com');
        } elseif ($_POST['action'] === 'show_contact_form') {
            PokazKontakt();
        } elseif ($_POST['action'] === 'PrzypomnijHaslo') {
            PrzypomnijHaslo();
        }
    }
}
?>

<form method="post" action="">
    <input type="hidden" name="action" value="show_contact_form">
    <input type="submit" value="Pokaż formularz kontaktowy">
</form>

<form method="post" action="">
    <input type="hidden" name="action" value="PrzypomnijHaslo">
    <input type="submit" value="Przypomnij hasło">
</form>
