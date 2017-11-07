<?php
session_start();
@include("function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl-PL">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
        <title>MyBlog - mój przykładowy blog.</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>

    <body>

        <div id="page">
            <div id="header">
                <h1>Mój blog</h1>
                <h2>Mój pierwszy blog...</h2>
            </div>

            <div id="navi">
                <a href="index.php">Strona główna</a> | 
                <a href="index.php?contact=1">Kontakt</a>

            </div>

            <div id="content">


                <div id="left">
                    <?php
                    if (!empty($_GET['id'])) {
                        getPostByID($_GET['id']);
                    } else if (!empty($_GET['cat'])) {
                        getAllUserPostByCategory($_GET['cat']);
                    } else if (!empty($_GET['contact'])) {
                        getContactForm();
                    } else {
                        getAllUserPost();
                    }
                    ?>
                </div>

                <div id="right">
                    <p><b>Kategorie:</b><br />
                        <?php getAllUSerCategory(); ?></p>
                    <p><b>Linki:</b><br />
                        <a href="http://pl.wikipedia.org/wiki/Wikipedia:Strona_g%C5%82%C3%B3wna">pl.wikipedia.org</a><br />
                        <a href="http://www.dobreprogramy.pl/">dobreprogramy.pl</a></p>
                </div>	

            </div>

            <div id="footer">
                <p>Patryk Jastrzębski 2013</p>
            </div>

        </div>

    </body>

</html>
