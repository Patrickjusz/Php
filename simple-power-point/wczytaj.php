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

function getSlideByID($idSlajdu)
{
    if (is_numeric($idSlajdu)) {
        $db = connectDB();
        $query = "SELECT * FROM  slajdy where id_prezentacji=$idSlajdu ORDER BY numer_slajdu ASC;";
        sleep(1);
        if ($result = $db->query($query)) {
            $count = $result->num_rows;
            echo("<script>");
            echo("var iloscSlajdow = $count;
		");
            for ($i = 0; $i < $count; $i++) {
                $post = $result->fetch_assoc();
                echo("slajdTytul[$i] = '" . stripslashes($post['tytul']) . "';
			slajdTresc[$i] = '" . stripslashes($post['tresc']) . "';


			slajdKolor1[$i]  = '" . stripslashes($post['kolor1']) . "';
			slajdKolor2[$i]  = '" . stripslashes($post['kolor2']) . "';
			slajdKolor3[$i]  = '" . stripslashes($post['kolor3']) . "';
			slajdKolor4[$i]  = '" . stripslashes($post['kolor4']) . "';


			przejscieZmienna[$i] = " . stripslashes($post['przejscie']) . ";");
            }
            echo("</script>");
            $result->close();
        }

        $db->close();
    } else {
        echo('lol');
        die();
    }
}

if (!empty($_GET['id']) && is_numeric($_GET['id']))
    getSlideByID($_GET['id']);
?>