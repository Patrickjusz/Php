<?php

function connectDB()
{
    include("config.php");
    /* funkcja zwraca obiekt do polaczenia sie z baza danych */
    @$db = new mysqli($db_adres, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno()) {
        die("Problem z baza danych!");
    }
    return $db;
}

function dodajPrezentacje($tytul, $mail)
{
    $tytul = addslashes($tytul);
    $mail = addslashes($mail);
    $db = connectDB();
    $query = "INSERT INTO `prezentacja` (`id_prezentacji`, `tytul`, `mail`) VALUES (NULL, '$tytul', '$mail');";


    if ($result = $db->query($query)) {
        //Dodano poprawnie post
        // header("Location: index.php?id=" . $id . '&comm=1');
        $idPrezentacji = $db->insert_id;
        echo($idPrezentacji);

        //wysylanie maila, odkomentowac zaleznie od serwera---
        //$messageMail = 'http://localhost/viewer.php?id='.$idPrezentacji;
        //mail($mail, 'Link do prezentacji prezi...', $messageMail);
        //----------------------------------------------------
    } else {
        //Nie udalo sie dodac postu
        //header("Location: index.php?id=" . $id . '&comm=0');
        echo('ok');
    }
    //$result->close();
    $db->close();
}

function dodajSlajd($tytul, $tresc, $kolor1, $kolor2, $kolor3, $kolor4, $przejscie, $id_prezentacji, $nr_slajdu)
{

    $tytul = addslashes($tytul);
    $tresc = addslashes($tresc);
    $kolor1 = addslashes($kolor1);
    $kolor2 = addslashes($kolor2);
    $kolor3 = addslashes($kolor3);
    $kolor4 = addslashes($kolor4);
    $przejscie = addslashes($przejscie);
    $id_prezentacji = addslashes($id_prezentacji);
    $nr_slajdu = addslashes($nr_slajdu);


    $db = connectDB();
    $query = "INSERT INTO `slajdy` (`id_slajdu`, `tytul`, `tresc`, `kolor1`, `kolor2`, `kolor3`, `kolor4`, `przejscie`, `id_prezentacji`, `numer_slajdu`) VALUES (NULL, '$tytul', '$tresc', '$kolor1', '$kolor2', '$kolor3', '$kolor4', '$przejscie', '$id_prezentacji', '$nr_slajdu');";


    if ($result = $db->query($query)) {
        //Dodano poprawnie post
        // header("Location: index.php?id=" . $id . '&comm=1');
        $idSlajdu = $db->insert_id;
        echo($idSlajdu);
    } else {
        //Nie udalo sie dodac postu
        //header("Location: index.php?id=" . $id . '&comm=0');
    }


    //$result->close();
    $db->close();
}

if ($_GET['akcja'] == 1) {
    if (!empty($_POST['tytul']) && !empty($_POST['mail'])) {
        dodajPrezentacje($_POST['tytul'], $_POST['mail']);
    }
}

if ($_GET['akcja'] == 2) {
    if (!empty($_POST['tytul']) && !empty($_POST['tresc'])) {
        dodajSlajd($_POST['tytul'], $_POST['tresc'], $_POST['kolor1'], $_POST['kolor2'], $_POST['kolor3'], $_POST['kolor4'], $_POST['przejscie'], $_POST['id_prezentacji'], $_POST['numer_slajdu']);
    }
}
?>