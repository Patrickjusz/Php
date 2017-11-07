var slajdTytul = new Array();
var slajdTresc = new Array();
var slajdKolor1 = new Array();
var slajdKolor2 = new Array();
var slajdKolor3 = new Array();
var slajdKolor4 = new Array();
var przejscieZmienna = new Array();
var iloscSlajdow = 0;
var obecnySlajd = 0;


function addit() {
    var wiad = prompt("Podaj nazwe slajdu", "Slajd " + (obecnySlajd + 1));
    var wybranoPrzejscie = document.getElementById('przejscie').selectedIndex;
    var x = document.getElementById("Select1");
    var option = document.createElement("option");
    iloscSlajdow = x.length + 1;
    option.text = wiad;
    option.value = iloscSlajdow;

    var kolor1 = document.getElementById('kolor1').value;
    var kolor2 = document.getElementById('kolor2').value;
    var kolor3 = document.getElementById('kolor3').value;
    var kolor4 = document.getElementById('kolor4').value;

    if (x.selectedIndex === -1) {
        x.add(option);
        slajdTytul[iloscSlajdow] = wiad;
        slajdTresc[iloscSlajdow] = 'tresc ' + iloscSlajdow;
        slajdKolor1[iloscSlajdow] = kolor1;
        slajdKolor2[iloscSlajdow] = kolor2;
        slajdKolor3[iloscSlajdow] = kolor3;
        slajdKolor4[iloscSlajdow] = kolor4;
        przejscieZmienna[iloscSlajdow] = wybranoPrzejscie;
    } else {
        slajdTytul.splice(x.selectedIndex + 2, 0, wiad);
        slajdTresc.splice(x.selectedIndex + 2, 0, 'tresc ' + iloscSlajdow);
        slajdKolor1.splice(x.selectedIndex + 2, 0, kolor1);
        slajdKolor2.splice(x.selectedIndex + 2, 0, kolor2);
        slajdKolor3.splice(x.selectedIndex + 2, 0, kolor3);
        slajdKolor4.splice(x.selectedIndex + 2, 0, kolor4);
        przejscieZmienna[iloscSlajdow] = wybranoPrzejscie;
        x.add(option, x[x.selectedIndex + 1]);
    }


    document.getElementById('ilosc-slajdow').innerHTML = iloscSlajdow;
    document.getElementById('tytul-slajdu').innerHTML = wiad;
    document.getElementById('tresc-slajdu').innerHTML = slajdTresc[iloscSlajdow];
    obecnySlajd = iloscSlajdow;
    document.getElementById("Select1").selectedIndex = obecnySlajd;
    document.getElementById('obecny-slajd').innerHTML = obecnySlajd;
    rysujRGB(kolor1, kolor2, kolor3, kolor4);
    przejscie(przejscieZmienna[iloscSlajdow]);
}

function delit() {
    var x = document.getElementById("Select1");
    slajdTytul.splice(x.selectedIndex + 1, 1);
    slajdTresc.splice(x.selectedIndex + 1, 1);
    slajdKolor1.splice(x.selectedIndex + 1, 1);
    slajdKolor2.splice(x.selectedIndex + 1, 1);
    slajdKolor3.splice(x.selectedIndex + 1, 1);
    slajdKolor4.splice(x.selectedIndex + 1, 1);
    przejscieZmienna.splice(x.selectedIndex + 1, 1);
    x.remove(x.selectedIndex);
    if ((iloscSlajdow > 0)) {
        iloscSlajdow = x.length;
        obecnySlajd = obecnySlajd - 1;
        document.getElementById('obecny-slajd').innerHTML = obecnySlajd;
        x.selectedIndex = obecnySlajd - 1;
        document.getElementById('ilosc-slajdow').innerHTML = iloscSlajdow;
        document.getElementById('tytul-slajdu').innerHTML = slajdTytul[obecnySlajd];
        document.getElementById('tresc-slajdu').innerHTML = slajdTresc[obecnySlajd];
    }
}

function zaladujSlajd() {
    var t = document.getElementById("Select1");
    var selectedText = t.options[t.selectedIndex].text;
    document.getElementById('tytul-slajdu').innerHTML = slajdTytul[t.selectedIndex + 1];
    document.getElementById('tresc-slajdu').innerHTML = slajdTresc[t.selectedIndex + 1];
    document.getElementById('obecny-slajd').innerHTML = t.selectedIndex + 1;
    obecnySlajd = t.selectedIndex + 1;
    document.getElementById('obecny-slajd').innerHTML = obecnySlajd;
    rysujRGB(slajdKolor1[t.selectedIndex + 1], slajdKolor2[t.selectedIndex + 1], slajdKolor3[t.selectedIndex + 1], slajdKolor4[t.selectedIndex + 1]);
    document.getElementById('kolor1').value = slajdKolor1[t.selectedIndex + 1];
    document.getElementById('kolor2').value = slajdKolor2[t.selectedIndex + 1];
    document.getElementById('kolor3').value = slajdKolor3[t.selectedIndex + 1];
    document.getElementById('kolor4').value = slajdKolor4[t.selectedIndex + 1];
    przejscie(przejscieZmienna[t.selectedIndex + 1]);
    document.getElementById('przejscie').selectedIndex = przejscieZmienna[t.selectedIndex + 1];
}

function edytujNaglowek() {
    var staryTytul = document.getElementById('tytul-slajdu').innerHTML;
    var wiad = prompt("Nowa nazwe slajdu", staryTytul);
    document.getElementById('tytul-slajdu').innerHTML = wiad;

    var sel = document.getElementById('Select1');
    sel.options[obecnySlajd - 1].innerHTML = wiad;
    slajdTytul[obecnySlajd] = wiad;
    rysuj();
}

function edytujTresc() {
    var zmienna = document.getElementById("pokaz");
    var tresc = document.getElementById('tresc-slajdu').innerHTML;
    zmienna.innerHTML = '<textarea id="edytowany">' + tresc + '</textarea><br><input type="submit" value="Zapisz" onclick="zapiszTresc()">';
    document.getElementById('tresc-slajdu').innerHTML = '';
    zmienna.style.display = "block";
}

function zapiszTresc() {
    var zmienna = document.getElementById("pokaz");
    var edytowany = document.getElementById("edytowany").value;
    zmienna.style.display = "none";
    document.getElementById('tresc-slajdu').innerHTML = edytowany;
    slajdTresc[obecnySlajd] = edytowany;
    rysuj();
}

/*function publikujSlajd(tytulek, trescik, kolorek1, kolorek2, kolorek3, kolorek4, przejsciaczek, idPrezentacji)
 {

 $.post("prezentacja.php?akcja=2",
 {
 tytul:tytulek,
 tresc:trescik,
 kolor1:kolorek1,
 kolor2:kolorek2,
 kolor3:kolorek3,
 kolor4:kolorek4,
 przejscie:przejsciaczek,
 id_prezentacji:idPrezentacji
 },
 function(data,status){
 alert(data+' : '+status);
 });
 }*/

function sleepFor(sleepDuration) {
    var now = new Date().getTime();
    while (new Date().getTime() < now + sleepDuration) { /* do nothing */
    }
}

function publikujPrezentacje(tytulek, trescik) {
    var tytulPrez = window.prompt("Podaj tytul prezentacji:", "");
    var email = window.prompt("Podaj adres e-mail, jesli chcesz otrzymac e-mail z linkiem:", "");
    if (email == null)
        email = 'brak';
    if (tytulPrez == null)
        tytulPrez = 'brak';
    $.post("prezentacja.php?akcja=1",
        {
            tytul: tytulPrez,
            mail: email
        },
        function (data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            if (status == 'success') {
                var numerPrezentacji = data;
                for (i = 1; i <= iloscSlajdow; i++) {
                    //publikujSlajd(slajdTytul[i], slajdTresc[i], slajdKolor1[i], slajdKolor2[i], slajdKolor3[i], slajdKolor4[i], przejscieZmienna[i], numerPrezentacji);
                    $.post("prezentacja.php?akcja=2",
                        {
                            tytul: slajdTytul[i],
                            tresc: slajdTresc[i],
                            kolor1: slajdKolor1[i],
                            kolor2: slajdKolor2[i],
                            kolor3: slajdKolor3[i],
                            kolor4: slajdKolor4[i],
                            przejscie: przejscieZmienna[i],
                            id_prezentacji: numerPrezentacji,
                            numer_slajdu: i
                        },
                        function (data, status) {
                            //alert(data+' : '+status);
                        });
                }
            }
            sleepFor(700);
            window.location.href = "viewer.php?id=" + numerPrezentacji;
        }
    );
}
