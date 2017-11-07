<?php
session_start();
@include('adminFunction.php');
if (isAdminLogin()) {
    //ZALOGOWANO!
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
                    <?php include('navi.html'); ?>
                </div>

                <div id="content">


                    <div id="left">
                        <table class="tabelkaCSS">
                            <tr>
                                <td>ID</td>	<td>Tytuł</td> <td>Treść</td> <td>Komentarze</td> <td>Widoczność</td> <td>Kategoria</td> <td>Tagi</td> <td>Autor</td>  <td>Data</td> <td>Edytuj</td> <td>Usuń</td>
                            </tr>
                            <tr>
                                <?php getAllAdminPost(); ?>
                            </tr>
                        </table>
                        <p class="tresc"><?php echo("Ilosc wpisow: " . getAdminPostCount() . ' <br />'); ?>
                            <a href="addPost.php">[ Dodaj nowy post ]</a></p>

                    </div>


                </div>

                <div id="footer">
                    <p>Patryk Jastrzębski 2013</p>
                </div>

            </div>

        </body>

    </html>
    <?php
//KONIEC ZALOGOWANIA
} else {
    $_SESSION['zalogowano'] = 0;
    header('Location: login.php');
}
?>