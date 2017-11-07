<?php

function connectDB() {
    /* funkcja zwraca obiekt do polaczenia sie z baza danych */
    @$db = new mysqli("localhost", "root", "1234", "db_blog");
    if (mysqli_connect_errno()) {
        die("Problem z baza danych!");
    }
    return $db;
}

function isAdminLogin() {
    if (!empty($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == 1) {
        return TRUE;
    } else
        return FALSE;
}

function setPost($tytul, $tresc, $komentarze, $widocznosc, $kategoria, $tagi, $autor) {
    $db = connectDB();

    $tytul = trim(addslashes(mysql_real_escape_string($tytul)));
    $tresc = trim(addslashes(mysql_real_escape_string($tresc)));
    $komentarze = trim(addslashes(mysql_real_escape_string($komentarze)));
    $widocznosc = trim(addslashes(mysql_real_escape_string($widocznosc)));
    $kategoria = trim(addslashes(mysql_real_escape_string($kategoria)));
    $tagi = trim(addslashes(mysql_real_escape_string($tagi)));
    $autor = trim(addslashes(mysql_real_escape_string($autor)));

    $query = "INSERT INTO `db_blog`.`blog_posty` (`id_post`, `tytul`, `tresc`, `komentarze`, `widocznosc`, `kategoria`, `tagi`, `autor`, `data`) VALUES (NULL, '$tytul', '$tresc', $komentarze, $widocznosc, $kategoria, '$tagi', '$autor', NOW())";
    if ($result = $db->query($query)) {
        //Dodano poprawnie post
        echo("Dodano post!");
        header('Location: index.php');
    } else {
        //Nie udalo sie dodac postu
        echo("Nie dodano postu!");
    }
}

function setCategory($tytul) {
    $db = connectDB();

    $tytul = trim(addslashes(mysql_real_escape_string($tytul)));

    $query = "INSERT INTO `db_blog`.`blog_kategorie` (`id_kategori`, `nazwa`) VALUES (NULL, '$tytul');";
    if ($result = $db->query($query)) {
        //Dodano poprawnie post
        echo("Dodano kategorie!");
        header('Location: category.php');
    } else {
        //Nie udalo sie dodac postu
        echo("Nie dodano kategorii!");
    }
}

function editPost($tytul, $tresc, $komentarze, $widocznosc, $kategoria, $tagi, $autor, $id) {
    $db = connectDB();
    $tytul = trim(addslashes(mysql_real_escape_string($tytul)));
    $tresc = trim(addslashes(mysql_real_escape_string($tresc)));
    $komentarze = trim(addslashes(mysql_real_escape_string($komentarze)));
    $widocznosc = trim(addslashes(mysql_real_escape_string($widocznosc)));
    $kategoria = trim(addslashes(mysql_real_escape_string($kategoria)));
    $tagi = trim(addslashes(mysql_real_escape_string($tagi)));
    $autor = trim(addslashes(mysql_real_escape_string($autor)));
    if (is_numeric($id))
        $query = "UPDATE  `db_blog`.`blog_posty` SET  `tytul` =  '$tytul', `tresc` =  '$tresc', `komentarze` =  '$komentarze', `widocznosc` =  '$widocznosc', `kategoria` =  '$kategoria', `tagi` =  '$tagi', `autor` =  '$autor' WHERE  `blog_posty`.`id_post` =$id";
    if ($result = $db->query($query)) {
        //Dodano poprawnie post
        echo("Zaktualizowano post!");
    } else {
        //Nie udalo sie dodac postu
        echo("Aktualizacja nie udana postu!");
    }
    header("Location: index.php"); /* Redirect browser */
}

function delPost($id) {
    if (is_numeric($id)) {
        $query = 'DELETE FROM blog_posty WHERE id_post=' . addslashes($id);
        $query2 = 'DELETE FROM blog_komentarze WHERE id_postu=' . addslashes($id);
    } else {
        return FALSE;
    }

    $db = connectDB();

    if ($result = $db->query($query)) {
        $db->query($query2);
        return TRUE;
    } else {
        $db->close();
        return FALSE;
    }
    $result->close();
    $db->close();
}

function delComment($id) {
    if (is_numeric($id)) {
        $query = 'DELETE FROM blog_komentarze WHERE id_komentarza=' . addslashes($id);
    } else {
        return FALSE;
    }

    $db = connectDB();

    if ($result = $db->query($query)) {
        return TRUE;
    } else {
        $db->close();
        return FALSE;
    }
    $result->close();
    $db->close();
}

function delCategory($id) {
    if (is_numeric($id)) {
        $query = 'DELETE FROM blog_kategorie WHERE id_kategori=' . addslashes($id);
    } else {
        return FALSE;
    }

    $db = connectDB();

    if ($result = $db->query($query)) {
        $query_update = "UPDATE  `db_blog`.`blog_posty` SET  `kategoria` =  '-1' WHERE  `blog_posty`.`kategoria` =" . addslashes($id);
        $db->query($query_update);
        return TRUE;
    } else {
        $db->close();
        return FALSE;
    }
    $result->close();
    $db->close();
}

function getAllAdminPost() {
    $db = connectDB();
    $query = "SELECT * FROM blog_posty";
    // ORDER BY data DESC
    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        for ($i = 0; $i < $count; $i++) {
            //PRINT BLOG POST
            $post = $result->fetch_assoc();
            $id = trim(stripcslashes(htmlspecialchars($post['id_post'])));
            $header = trim(stripcslashes(htmlspecialchars($post['tytul'])));
            $content = nl2br(trim(stripcslashes($post['tresc'])));
            $comment = trim(stripcslashes(htmlspecialchars($post['komentarze'])));
            $comment = $comment == 1 ? '<spain style="color: green;"><b>Włączone</b></spain>' : '<spain style="color: red;"><b>Wyłączone</b></spain>';
            $visibility = trim(stripcslashes(htmlspecialchars($post['widocznosc'])));
            $visibility = $visibility == 1 ? '<spain style="color: green;"><b>Tak</b></spain>' : '<spain style="color: red;"><b>Nie</b></spain>';
            $category = trim(stripcslashes(htmlspecialchars($post['kategoria'])));
            $tags = trim(stripcslashes(htmlspecialchars($post['tagi'])));
            $author = trim(stripcslashes(htmlspecialchars($post['autor'])));
            $data = trim(stripcslashes(htmlspecialchars($post['data'])));
            if (strlen($content) > 300)
                $content = substr($content, 0, 300) . ' (...)<br/><br/>';

            //--
            if ($category != '-1') {
                if (!is_numeric($category))
                    die("PRÓBA WŁAMANIA!");
                $query2 = "SELECT nazwa FROM blog_kategorie WHERE id_kategori=" . $category . " LIMIT 1";

                if ($result2 = $db->query($query2)) {
                    //PRINT BLOG POST
                    $post2 = $result2->fetch_assoc();
                    $category = trim(stripcslashes(htmlspecialchars($post2['nazwa'])));
                    $result2->close();
                }
            } else {
                $category = 'Brak kategorii';
            }




            //--
            echo('<tr style="background-color: 5fbf00;">');
            echo("<td>$id</td>");
            echo("<td><a href=\"../index.php?id=$id\">$header</a></td>");
            echo("<td>$content</td>");
            echo("<td>$comment</td>");
            echo("<td>$visibility</td>");
            echo("<td><i>$category</i></td>");
            echo("<td>$tags</td>");
            echo("<td>$author</td>");
            echo("<td>$data</td>");
            echo('<td><a href="editPost.php?id=' . $id . '">Edytuj</a></td>');
            echo('<td><a href="delPost.php?id=' . $id . '">Usun</a></td>');
            echo('</tr>');
        }
        $result->close();
    }

    $db->close();
}

function getAllAdminComment() {
    $db = connectDB();
    $query = "SELECT * FROM blog_komentarze";
    // ORDER BY data DESC
    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        for ($i = 0; $i < $count; $i++) {
            //PRINT BLOG POST
            $post = $result->fetch_assoc();
            $id = trim(stripcslashes(htmlspecialchars($post['id_komentarza'])));
            $pseudonim = trim(stripcslashes(htmlspecialchars($post['pseudonim'])));
            $email = trim(stripcslashes($post['email']));
            $widocznosc = trim(stripcslashes(htmlspecialchars($post['widocznosc'])));
            $tresc = trim(stripcslashes(htmlspecialchars($post['tresc'])));
            $ip = trim(stripcslashes(htmlspecialchars($post['ip'])));
            $data = trim(stripcslashes(htmlspecialchars($post['data'])));
            $id_postu = trim(stripcslashes(htmlspecialchars($post['id_postu'])));
            echo('<tr>');
            echo("<td>$id</td>");
            echo("<td>$pseudonim</td>");
            echo("<td>$email</td>");
            echo("<td>");
            echo($widocznosc == 1 ? '<spain style="color: green;"><b>Tak</b></spain></td>' : '<spain style="color: red;"><b>Nie</b></spain>');
            echo('</td>');
            echo("<td>$tresc</td>");
            echo("<td>$ip</td>");
            echo("<td>$data</td>");
            echo("<td>$id_postu</td>");
            if ($widocznosc == 0)
                echo('<td><a href="acceptComment.php?id=' . $id . '&accept=1"><spain style="color: green;">Zatwierdz</spain></a></td>');
            if ($widocznosc == 1)
                echo('<td><a href="acceptComment.php?id=' . $id . '&accept=0"><spain style="color: red;">Ukryj</spain></a></td>');
            echo('<td><a href="delComment.php?id=' . $id . '">Usun</a></td>');
            echo('</tr>');
        }
        $result->close();
    }
    $db->close();
}

function getAdminPostCount() {
    $db = connectDB();
    $query = "SELECT COUNT(*) as liczba FROM blog_posty;";

    if ($result = $db->query($query)) {
        $post = $result->fetch_assoc();
        return $post['liczba'];
        $result->close();
    }

    $db->close();
}

function getAdminCategoryCount() {
    $db = connectDB();
    $query = "SELECT COUNT(*) as liczba FROM blog_kategorie;";

    if ($result = $db->query($query)) {
        $post = $result->fetch_assoc();
        return $post['liczba'];
        $result->close();
    }

    $db->close();
}

function getAllCategory() {
    $db = connectDB();
    $query = "SELECT * FROM blog_kategorie";
    // ORDER BY data DESC
    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        for ($i = 0; $i < $count; $i++) {
            //PRINT BLOG POST
            $post = $result->fetch_assoc();
            //$id = trim(stripcslashes(htmlspecialchars($post['id_kategori'])));
            $name = trim(stripcslashes(htmlspecialchars($post['nazwa'])));
            echo("<option>$name</option>");
        }
        $result->close();
    }

    $db->close();
}

function getAdminCommentsCount() {
    $db = connectDB();
    $query = "SELECT COUNT(*) as liczba FROM blog_komentarze;";

    if ($result = $db->query($query)) {
        $post = $result->fetch_assoc();
        return $post['liczba'];
        $result->close();
    }

    $db->close();
}

function getAllAdminCategory() {
    $db = connectDB();
    $query = "SELECT id_kategori, nazwa FROM blog_kategorie";
    // ORDER BY data DESC
    if ($result = $db->query($query)) {
        $count = $result->num_rows;
        for ($i = 0; $i < $count; $i++) {
            //PRINT BLOG POST
            $post = $result->fetch_assoc();
            $id = trim(stripcslashes(htmlspecialchars($post['id_kategori'])));
            $name = trim(stripcslashes(htmlspecialchars($post['nazwa'])));
            echo('<tr>');
            echo("<td>$id</td>");
            echo("<td>$name</td>");
            echo('<td><a href="delCategory.php?id=' . $id . '">Usun</a></td>');
            echo('</tr>');
        }
        $result->close();
    }


    $db->close();
}
?>

