<?php

function PokazKontakt()
{
    // HTML form for displaying the contact form
    echo '<form method="post" action="">
            Temat: <input type="text" name="temat"><br>
            Treść: <textarea name="tresc"></textarea><br>
            Email: <input type="email" name="email"><br>
            <input type="submit" name="action" value="WyslijMailaKontakt">
          </form>';
}

function PrzypomnijHaslo()
{
    // HTML form for displaying the password reminder form
    echo '<form method="post" action="">
            Podaj swój email: <input type="email" name="email"><br>
            <input type="submit" name="action" value="PrzypomnijHaslo">
          </form>';
}

function WyslijMailaKontakt($odbiorca)
{
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        PokazKontakt(); // Re-display the contact form
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['recipent'] = $odbiorca; // You are the recipient if creating a contact form

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

// Example usage:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['action'])) {
        // Check which action is requested
        if ($_POST['action'] === 'WyslijMailaKontakt') {
            WyslijMailaKontakt('your@email.com');
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
