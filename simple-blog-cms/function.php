<?php

@include('config.php');

function connectDB() {
    /* funkcja zwraca obiekt do polaczenia sie z baza danych */
    @$db = new mysqli("localhost", "root", "1234", "db_blog");
    if (mysqli_connect_errno()) {
        die("Problem z baza danych!");
    }
    return $db;
}

function getAllUserPost() {
    $db = connectDB();
    $query = "SELECT id_post, tytul, tresc, kategoria, autor, widocznosc, data FROM blog_posty WHERE widocznosc=1 ORDER BY id_post DESC";

    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        for ($i = 0; $i < $count; $i++) {
            //PRINT BLOG POST
            $post = $result->fetch_assoc();
            $id = trim(stripcslashes(htmlspecialchars($post['id_post'])));
            $header = trim(stripcslashes(htmlspecialchars($post['tytul'])));
            $content = trim(stripcslashes($post['tresc']));
            $znaki = array('[b]', '[/b]', '[i]', '[/i]', '[u]', '[/u]', '[quote]', '[/quote]', '[code]', '[/code]', '[url]', '[/url]', '[img]', '[/img]', '[s]', '[/s]', '[center]', '[/center]');
            $znaki_zamienione = array('<b>', '</b>', '<i>', '</i>', '<u>', '</u>', '</p><cite>', '</cite><p class="tresc">', '</p><code class="kodek">', '</code><p class="tresc">', '[ link ]', '', '', '<s>', '</s>', '</p><center>', '</center><p class="tresc">');
            $content = str_replace($znaki, $znaki_zamienione, $content); 
            if (strlen($content) > 500)
                $content = substr($content, 0, 500) . '...<br/><br/> <a href="index.php?id=' . $id . '">Czytaj dalej</a>';
            $category = trim(stripcslashes(htmlspecialchars($post['kategoria'])));
            $author = trim(stripcslashes(htmlspecialchars($post['autor'])));
            $data = trim(stripcslashes(htmlspecialchars($post['data'])));
            echo('<h2><a class="linka" href="index.php?id=' . $id . '">' . $header . '</a></h2>');
            echo('<p class="data">' . $data . '</p>');
            echo('<p class="tresc">' . nl2br($content) . '</p>');
            //echo($category);
            echo('<p class="data">Autor: ' . $author . '</p><div class="oddziel"></div>');
        }
        $result->close();
    }

    $db->close();
}

function getAllUserPostByCategory($id) {
    $db = connectDB();
    if (!is_numeric($id))
        die("PRÓBA WŁAMANIA!");
    $query = "SELECT id_post, tytul, tresc, kategoria, autor, widocznosc, data FROM blog_posty WHERE widocznosc=1 and kategoria='" . $id . "' ORDER BY id_post DESC";

    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        echo('<h2 style="color: green;">Kategoria: ');
        echo(getCategoryByID($id));
        echo('</h2><br/><div class="oddziel"></div>');
        for ($i = 0; $i < $count; $i++) {
            //PRINT BLOG POST
            $post = $result->fetch_assoc();
            $header = trim(stripcslashes(htmlspecialchars($post['tytul'])));
            $content = nl2br(trim(stripcslashes($post['tresc'])));
            $znaki = array('[b]', '[/b]', '[i]', '[/i]', '[u]', '[/u]', '[quote]', '[/quote]', '[code]', '[/code]', '[url]', '[/url]', '[img]', '[/img]', '[s]', '[/s]', '[center]', '[/center]');
            $znaki_zamienione = array('<b>', '</b>', '<i>', '</i>', '<u>', '</u>', '</p><cite>', '</cite><p class="tresc">', '</p><code class="kodek">', '</code><p class="tresc">', '', '[ link ]', '', '', '<s>', '</s>', '</p><center>', '</center><p class="tresc">');
            $content = str_replace($znaki, $znaki_zamienione, $content); 
            $id_post= trim(stripcslashes(htmlspecialchars($post['id_post'])));
            if (strlen($content) > 500)
                $content = substr($content, 0, 500) . '...<br/><br/> <a href="index.php?id=' . $id_post . '">Czytaj dalej</a>';
            $category = trim(stripcslashes(htmlspecialchars($post['kategoria'])));
            $author = trim(stripcslashes(htmlspecialchars($post['autor'])));
            $data = trim(stripcslashes(htmlspecialchars($post['data'])));
            echo('<a class="linka" href="index.php?id=' . $id_post . '"><h2>' . $header . '</h2></a>');
            echo('<p class="data">' . $data . '</p>');
            echo('<p class="tresc">' . $content . '</p>');
            //echo($category);
            echo('<p class="data">Autor: ' . $author . '</p><div class="oddziel"></div>');
        }
        $result->close();
    }

    $db->close();
}

function getPostByID($id) {
    $db = connectDB();
    if (!is_numeric($id))
        die("PRÓBA WŁAMANIA!");
    $query = "SELECT tytul, tresc, kategoria, autor, widocznosc, komentarze, data FROM blog_posty WHERE widocznosc=1 and id_post=" . $id;

    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        if ($count == 0)
            getAllUserPost(); else {
            for ($i = 0; $i < $count; $i++) {
                //PRINT BLOG POST
                $post = $result->fetch_assoc();
                $header = trim(stripcslashes(htmlspecialchars($post['tytul'])));
                $content = nl2br(trim(stripcslashes($post['tresc'])));
                //$content = str_replace('[b]', '<b>', $content);
               
                $znaki = array('[b]', '[/b]', '[i]', '[/i]', '[u]', '[/u]', '[quote]', '[/quote]', '[code]', '[/code]', '[url]', '[/url]', '[img]', '[/img]', '[s]', '[/s]', '[center]', '[/center]');
                $znaki_zamienione = array('<b>', '</b>', '<i>', '</i>', '<u>', '</u>', '</p><cite>', '</cite><p class="tresc">', '</p><pre class="kodek">', '</pre><p class="tresc">', '<a href="', '">[ link ]</a>', '<p><center><img class="foto" src="', '"></center> <p class="tresc">', '<s>', '</s>', '</p><center>', '</center><p class="tresc">');
                $content = str_replace($znaki, $znaki_zamienione, $content);
                $category = trim(stripcslashes(htmlspecialchars($post['kategoria'])));
                $author = trim(stripcslashes(htmlspecialchars($post['autor'])));
                $data = trim(stripcslashes(htmlspecialchars($post['data'])));
                $komentarze = trim(stripcslashes(htmlspecialchars($post['komentarze'])));
                echo("<h2>$header</h2>");
                echo('<p class="data">' . $data . '</p>');
                echo('<p class="tresc">' . $content . '</p>');
                //echo($category);
                echo('<p class="data">Autor: ' . $author . ', Kategoria: ');
                echo(getCategoryByID($category) . '</p>');
                if ($komentarze==1)
                    getCommentByID($id);
                else { 
                    echo('<p class="komentarze_naglowek">Możliwość komentowania została wyłączona przez administratora.</p><br/>');
                };
            }
        }
        $result->close();
    }

    $db->close();
}

function getAllUSerCategory() {
    $db = connectDB();
    $query = 'SELECT id_kategori, nazwa FROM blog_kategorie';
    // ORDER BY data DESC
    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        for ($i = 0; $i < $count; $i++) {
            //PRINT BLOG POST
            $post = $result->fetch_assoc();
            $id = trim(stripcslashes(htmlspecialchars($post['id_kategori'])));
            $name = trim(stripcslashes(htmlspecialchars($post['nazwa'])));

            //------------------------ILE KATEGORIA MA WPISOW bo getCategoryCountByID() powoduje wydajnosciowe problemy
            $query2 = 'SELECT COUNT(*) as liczba FROM blog_posty WHERE widocznosc=1 and kategoria=' . (int) $id;

            if ($result2 = $db->query($query2)) {
                $post = $result2->fetch_assoc();
                $ilosc = $post['liczba'];
            } else
                $ilosc = '-';
            //--------------------------------------------------

            echo('<a href="index.php?cat=' . $id . '">' . $name . ' (' . $ilosc . ')</a><br />');
        }

        //----brak kategori----------------------
        $query3 = 'SELECT COUNT(*) as liczba FROM blog_posty WHERE widocznosc=1 and kategoria=-1';

        if ($result3 = $db->query($query3)) {
            $post = $result3->fetch_assoc();
            $ilosc = $post['liczba'];
        } else
            $ilosc = '-';
        //------------------------------------------------

        echo('<a href="index.php?cat=-1">Brak kategorii (' . $ilosc . ')</a><br />');
        $result->close();
        $result2->close();
        $result3->close();
    }


    $db->close();
}

function getCategoryByID($id) {
    $db = connectDB();
    if ($id != '-1') {
        if (!is_numeric($id))
            die("PRÓBA WŁAMANIA!");
        $query = "SELECT nazwa FROM blog_kategorie WHERE id_kategori=" . (int) $id . " LIMIT 1";

        if ($result = $db->query($query)) {
            $count = $result->num_rows;
            if ($count == 0)
                getAllUserPost(); else {
                for ($i = 0; $i < $count; $i++) {
                    //PRINT BLOG POST
                    $post = $result->fetch_assoc();
                    $nazwa = trim(stripcslashes(htmlspecialchars($post['nazwa'])));
                    echo("$nazwa");
                }
            }
            $result->close();
        }

        $db->close();
    } else {
        echo("Brak kategorii");
    }
}

function setComment($pseudonim, $email, $tresc, $ip, $id) {
    $db = connectDB();

    $pseudonim = trim(addslashes(mysql_real_escape_string($pseudonim)));
    $email = trim(addslashes(mysql_real_escape_string($email)));
    $tresc = trim(addslashes(mysql_real_escape_string($tresc)));
    $ip = trim(addslashes(mysql_real_escape_string($ip)));
    $id = trim(addslashes(mysql_real_escape_string($id)));
    $query = "INSERT INTO `db_blog`.`blog_komentarze` (`id_komentarza`, `pseudonim`, `email`, `widocznosc`, `tresc`, `ip`, `data`, `id_postu`) VALUES (NULL, '$pseudonim', '$email', '0', '$tresc', '$ip', NOW(), '$id');";
    if ($result = $db->query($query)) {
        //Dodano poprawnie post
        header("Location: index.php?id=" . $id . '&comm=1');
    } else {
        //Nie udalo sie dodac postu
        header("Location: index.php?id=" . $id . '&comm=0');
    }
}


function getCommentByID($id) {
    $db = connectDB();
    if (!is_numeric($id))
        die("PRÓBA WŁAMANIA!");
    $query = "SELECT pseudonim, email, tresc, data FROM blog_komentarze WHERE widocznosc=1 and id_postu=" . $id;

    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        if ($count == 0)
            echo('<p class="komentarze_naglowek">Komentarze:</p><p class="komentarze"> <b>Brak komentarzy!</b><br />'); else {
            echo('<p class="komentarze_naglowek">Komentarze:</p><p class="komentarze"> ');
            for ($i = 0; $i < $count; $i++) {
                //PRINT BLOG POST
                $post = $result->fetch_assoc();
                $pseudonim = trim(stripcslashes(htmlspecialchars($post['pseudonim'])));
                $email = trim(stripcslashes($post['email']));
                $tresc = trim(stripcslashes(htmlspecialchars($post['tresc'])));
                $data = trim(stripcslashes(htmlspecialchars($post['data'])));
                //echo("<h2>$pseudonim</h2>");
                echo('<b>' . " $pseudonim, $email napisał/a: ($data)" . '</b><br />');
                echo($tresc . '<br /><br />');
            }
            if (!empty($_GET['comm']) && $_GET['comm'] == 1)
                echo('<span style="color: red; font-size: 13px;"><br />Komentarz został dodany poprawnie, czeka na zatwierdzenie przez administratora!</span>');
            if (!empty($_GET['comm']) && $_GET['comm'] == 2)
                echo('<span style="color: red; font-size: 13px;"><br />Nieporawne rozwiązanie równania!</span>');
            echo('</p>');
        }
        $result->close();
    }

    $db->close();
    echo('<div id="formularz"><p class="dodaj_k">Dodaj komentarz:</p><form action="addComment.php?id=' . $id . '" method="post">
<fieldset>    
<label>Pseudonim:</label><br/>
    <input type="text" name="pseudonim"/><br/>
    <label>E-mail:</label><br/>
    <input type="text" name="email"/><br/>
    <label>Treść:</label><br/>
    <textarea rows="6" cols="60" name="tresc"></textarea><br/>
    <label>Rozwiąż równanie <b>');
    include("genCaptcha.php");
    echo('</b>:</label><br/>
    <input type="text" name="kod"/><br/>
    <input class="send" type="submit" value="Dodaj komentarz"/>
</fieldset></form></div>');
}

function getContactForm() {
    if (!empty($_GET['contact']) && !is_numeric($_GET['contact'])) die("PRÓBA WŁAMANIA!");
    echo('<div id="formularz"><p class="dodaj_k"><br/>Kontakt:</p><form action="sendMail.php" method="post">
<fieldset>    
<label>Pseudonim:</label><br/>
    <input type="text" name="pseudonim"/><br/>
    <label>E-mail:</label><br/>
    <input type="text" name="email"/><br/>
    <label>Treść:</label><br/>
    <textarea rows="6" cols="60" name="tresc"></textarea><br/>
    <label>Rozwiąż równanie <b>');
    include("genCaptcha.php");
    echo('</b>:</label><br/>
    <input type="text" name="kod"/><br/>
    <input class="send" type="submit" value="Dodaj komentarz"/>
</fieldset></form>');

    if (!empty($_GET['contact']) && $_GET['contact'] == 3) {
        echo('<span style="color: red; font-size: 13px;">Wysłano wiadomoś poprawnie!<br /><br /></spain>');
    }

    if (!empty($_GET['contact']) && $_GET['contact'] == 2) {
        echo('<span style="color: red; font-size: 13px;">Nie udało się wysłać poprawnie wiadomości!<br /><br /></spain>');
    }
    echo('</div>');
}

/* //powoduje problemy wydajnosciowe przez czeste wywolania zliczajace ilosc kategorii, kod przeniesiony do innej funkcji
  function getCategoryCountByID($id)
  {
  $db = connectDB();
  if (!is_numeric($id)) die("PRÓBA WŁAMANIA!");
  $query = "SELECT COUNT(*) as liczba FROM blog_posty WHERE widocznosc=1 and kategoria=".(int)$id;

  if ($result = $db->query($query))
  {
  $post = $result->fetch_assoc();
  return $post['liczba'];
  }

  $result->close();
  $db->close();
  }
 */
?>