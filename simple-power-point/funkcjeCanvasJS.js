function rysuj() {
    var canvas = document.getElementById('myCanvas');
    var context = canvas.getContext('2d');
    var kolor1 = document.getElementById('kolor1').value;
    var kolor2 = document.getElementById('kolor2').value;
    var kolor3 = document.getElementById('kolor3').value;
    var kolor4 = document.getElementById('kolor4').value;
    slajdKolor1[obecnySlajd] = kolor1;
    slajdKolor2[obecnySlajd] = kolor2;
    slajdKolor3[obecnySlajd] = kolor3;
    slajdKolor4[obecnySlajd] = kolor4;
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

    var tytul = document.getElementById('tytul-slajdu').innerHTML;
    ctx.fillText(tytul, 40, 50);

    ctx.fillStyle = kolor4;
    ctx.font = "12px Arial";
    ctx.shadowColor = '#494949';
    //ctx.shadowOffsetX = 1;
    //ctx.shadowOffsetY = 1;

    var tresc = document.getElementById('tresc-slajdu').innerHTML;
    ctx.fillText(tresc, 80, 80);
}

function zmien($num) {
    // ile = document.getElementById('ile').value;
    // document.getElementById('myCanvas').style.webkitFilter = "contrast(" + ile + "%)";
}

function rysujRGB(kolor1, kolor2, kolor3, kolor4) {
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

    var Tytul = document.getElementById('tytul-slajdu').innerHTML;
    ctx.fillText(Tytul, 40, 50);

    ctx.fillStyle = kolor4;
    ctx.font = "12px Arial";
    ctx.shadowColor = '#494949';
    //ctx.shadowOffsetX = 1;
    //ctx.shadowOffsetY = 1;

    var tresc = document.getElementById('tresc-slajdu').innerHTML;
    ctx.fillText(tresc, 80, 80);
}

function zmienMotyw() {
    var wybrano = document.getElementById('motyw').selectedIndex;
    var kolor1 = '#ffffff';
    var kolor2 = '#ffffff';
    var kolor3 = '#ffffff';
    var kolor4 = '#ffffff';

    switch (wybrano) {
        case 0:
            kolor1 = '#004080';
            kolor2 = '#c0c0c0';
            kolor3 = '#ffffff';
            kolor4 = '#ffffff';
            break;
        case 1:
            kolor1 = '#000000';
            kolor2 = '#ffffff';
            kolor3 = '#ff0080';
            kolor4 = '#ff0080';
            break;
        case 2:
            kolor1 = '#000000';
            kolor2 = '#004040';
            kolor3 = '#00ff00';
            kolor4 = '#00ff00';
            break;
        case 3:
            kolor1 = '#ffff80';
            kolor2 = '#ff8040';
            kolor3 = '#004080';
            kolor4 = '#004080';
            break;
    }

    document.getElementById('kolor1').value = kolor1;
    document.getElementById('kolor2').value = kolor2;
    document.getElementById('kolor3').value = kolor3;
    document.getElementById('kolor4').value = kolor4;
    slajdKolor1[obecnySlajd] = kolor1;
    slajdKolor2[obecnySlajd] = kolor2;
    slajdKolor3[obecnySlajd] = kolor3;
    slajdKolor4[obecnySlajd] = kolor4;

    rysujRGB(slajdKolor1[obecnySlajd], slajdKolor2[obecnySlajd], slajdKolor3[obecnySlajd], slajdKolor4[obecnySlajd]);
    //document.getElementById('kolor1').value = slajdKolor1[t.selectedIndex + 1];
    //document.getElementById('kolor2').value = slajdKolor2[t.selectedIndex + 1];
    //document.getElementById('kolor3').value = slajdKolor3[t.selectedIndex + 1];
    //document.getElementById('kolor4').value = slajdKolor3[t.selectedIndex + 1];

}

function przejscie(numer) {
    $(document).ready(function () {

        if (numer == 0) {
            $("#myCanvas").hide();
            $("#myCanvas").fadeIn(400);
            przejscieZmienna[obecnySlajd] = 0;
        }

        if (numer == 1) {
            $("#myCanvas").hide();
            $("#myCanvas").show(400);
            przejscieZmienna[obecnySlajd] = 1;
        }
    });
}