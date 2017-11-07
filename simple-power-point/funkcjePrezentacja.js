var slajdTytul = new Array();
var slajdTresc = new Array();
var slajdKolor1 = new Array();
var slajdKolor2 = new Array();
var slajdKolor3 = new Array();
var slajdKolor4 = new Array();
var przejscieZmienna = new Array();
var obecnySlajd = -1;

/* GENERUJE PLIK PHP W PLIKU prezentacja.php
 var iloscSlajdow = 1;
 slajdTytul[0] = 'Hello world 1!';
 slajdTresc[0] = 'To jest tresc prezentacji 1';


 slajdKolor1[0]  = '#004080';
 slajdKolor2[0]  = '#c0c0c0';
 slajdKolor3[0]  = '#ffffff';
 slajdKolor4[0]  = '#ffffff';

 przejscieZmienna = new Array();

 przejscieZmienna[0] = 1;
 */


function rysujRGB(kolor1, kolor2, kolor3, kolor4, slajd) {
    var canvas = document.getElementById('myCanvas');
    var context = canvas.getContext('2d');
    context.rect(0, 0, canvas.width, canvas.height);

    // add linear gradient
    var grd = context.createLinearGradient(0, 0, canvas.width, canvas.height);
    // light blue
    grd.addColorStop(0, kolor1);
    // dark blue
    grd.addColorStop(1, kolor2);
    context.fillStyle = grd;
    context.fill();
    //

    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");

    ctx.fillStyle = kolor3;
    ctx.font = "35px Arial";
    ctx.shadowColor = '#494949';
    ctx.shadowOffsetX = 1;
    ctx.shadowOffsetY = 1;

    var Tytul = slajdTytul[slajd];
    ctx.fillText(Tytul, 40, 50);

    ctx.fillStyle = kolor4;
    ctx.font = "12px Arial";
    ctx.shadowColor = '#494949';
    //ctx.shadowOffsetX = 1;
    //ctx.shadowOffsetY = 1;

    var tresc = slajdTresc[slajd];
    ctx.fillText(tresc, 80, 80);
}

function przejscie(numer) {
    $(document).ready(function () {

        if (numer == 0) {
            $("#myCanvas").hide();
            $("#myCanvas").fadeIn(800);
        }

        if (numer == 1) {
            $("#myCanvas").hide();
            $("#myCanvas").show(800);
        }
    });
}

function zaladujPrezentacje(slajd, kierunek) {
    if (kierunek == 1 && slajd < iloscSlajdow) {
        slajd = slajd + 1;
        rysujRGB(slajdKolor1[slajd], slajdKolor2[slajd], slajdKolor3[slajd], slajdKolor4[slajd], slajd);
        przejscie(przejscieZmienna[slajd]);
        obecnySlajd = slajd;
    }

    if (kierunek == 0 && slajd > 0) {
        slajd = slajd - 1;

        rysujRGB(slajdKolor1[slajd], slajdKolor2[slajd], slajdKolor3[slajd], slajdKolor4[slajd], slajd);
        przejscie(przejscieZmienna[slajd]);
        obecnySlajd = slajd;
    }
    document.getElementById('obecny').innerHTML = obecnySlajd + 1;
    document.getElementById('maxSlajd').innerHTML = iloscSlajdow;
}

