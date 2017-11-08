<?php

if (!empty($_POST['username'])) {
    //TUTAJ MOŻNA ZAIMPLEMENTOWAĆ OBSŁUGE BAZY DANYCH Z SELECTem danego usera
    if ($_POST['username'] == "admin") {
        echo("0");
        //zajety
    } else {
        echo("1");
        //ok
    }
}
?>