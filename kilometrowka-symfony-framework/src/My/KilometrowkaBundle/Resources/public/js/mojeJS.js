function drukuj(elem)
{
    drukujNoweOkno($(elem).html());
}

function drukujNoweOkno(tresc)
{
    var mojeOkno = window.open("", "to_print", "height=600,width=600");
    var html = "<html><head><title>Kilometrówka 2017 - Drukuj raport</title><style type=\"text/css\">table, th, td {border: 1px solid black; width: 100%; text-align:center; }</style></head>" +
            "<body onload=window.focus(); window.print(); window.close()>" +
            tresc +
            "</body></html>";
    mojeOkno.document.write(html);
    mojeOkno.print();
    mojeOkno.document.close();
    return true;
}

function OtworzWNowymOknie(url) {
    var win = window.open(url, '_blank');
    win.focus();
}


$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip({
        placement: 'top'
    });
});



function sprawdzHasla() {
    if (document.getElementById('haslo').value == document.getElementById('haslo2').value) {
        return true;
    } else {
        alert('Hasła nie są identyczne!');
        return false;
    }
}

function sprawdzCelPrzejazdu() {
    var uchwyt = document.getElementById("celWyjazdu");
    var dlugosc = uchwyt.value.length;
    if ((dlugosc >= 2) && (dlugosc <= 32)) {
        return true;
    } else {
        alert('Proszę podać cel wyjazdu. Cel może składać się od 2 do 32 znaków.');
        return false;
    }
}

function op(obj) {
    x = document.getElementById(obj);
    if (x.style.display == "none")
        x.style.display = "block";
    else
        x.style.display = "none"
}
