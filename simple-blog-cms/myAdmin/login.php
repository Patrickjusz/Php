<?php
session_start();
@include('adminFunction.php');

if (!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['kod'])) {
    if (!empty($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == 1) {
        //JEST JUŻ ZALOGOWANY PRZEKIERUJ!
        header('Location: index.php');
    } else {

        if (!empty($_SESSION['capA']) && !empty($_SESSION['capB']) && ($_SESSION['capA'] + $_SESSION['capB']) == $_POST['kod']) {
            if (sha1(md5($_POST['login'])) == '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad' && sha1(md5($_POST['pass'])) == '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1') { //admin:1234
                $_SESSION['zalogowano'] = 1;
                header('Location: index.php');
                //ZALOGUJ SESJA!
            } else
                $_SESSION['zalogowano'] = 0; //USTAW SESJE NA 0 "niezalogowany"
        } else {
            $_SESSION['capA'] = rand(10, 60);
            $_SESSION['capB'] = rand(10, 60);
            header("Location: login.php?id=" . $id . '&comm=2');
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl-PL">

    <head>
<?php include('head.html'); ?>
    </head>

    <body>

        <div id="page">
            <div id="header">
                <h1>Blog myAdmin...</h1>
                <h2>panel administracyjny systemu blogowego</h2>
            </div>

            <div id="navi">
<?php //include("navi.html");  ?>
            </div>

            <div id="content">


                <div id="left"><center>
                        <h2>Zaloguj się:</h2><br/>
                        <form method="POST" action="login.php"><p class="tresc">
                                Login:<br/>
                                <input type="text" name="login"><br/>
                                    Hasło:<br/>
                                    <input type="password" name="pass"><br/>
                                        Podaj wynik: <?php include("genCaptcha.php"); ?><br/><input type="text" name="kod"><br/>
                                            <input type="submit" value="Zaloguj"><br/><br/>

<?php if (!empty($_GET['out']) && $_GET['out'] == 1) {
    echo('<spain style="color: red;">Zostałeś wylogowany poprawnie!</spain>');
} ?></p>
                                                </form>
                                                </center>
                                                </div>


                                                </div>

                                                <div id="footer">
                                                    <p>Patryk Jastrzębski 2013</p>
                                                </div>

                                                </div>

                                                </body>

                                                </html>