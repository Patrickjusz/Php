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
		<?php include("navi.html"); ?>
	</div>
	
	<div id="content">
	
		
            <div id="left"><?php
if (
!empty($_POST['tytul']) |
!empty($_POST['tresc']) |
!empty($_POST['tagi']) |
!empty($_POST['autor']) |
!empty($_POST['komentarze']) |
!empty($_POST['widocznosc'])) 
{
    $tytul = $_POST['tytul'];
    $tresc =$_POST['tresc'];
    $tagi = $_POST['tagi'];
    $autor = $_POST['autor'];
    isset($_POST['komentarze']) ? $komentarze=1 : $komentarze=0;
    isset($_POST['widocznosc']) ? $widocznosc=1 : $widocznosc=0;
    @$kategoria = trim(addslashes(mysql_real_escape_string($_POST['kategoria'])));
    $db = connectDB();
    if (!empty($kategoria)) {
        $query = "SELECT id_kategori FROM blog_kategorie WHERE nazwa='".$kategoria."' LIMIT 1";
    if ($result = $db->query($query)) 
	{
		$count = $result->num_rows;
		for($i=0; $i <$count; $i++) 
		{	
			$post = $result->fetch_assoc();
                        $id= trim(stripcslashes(htmlspecialchars($post['id_kategori'])));
                }
         }	
	
	$db->close();
    } else $id='-1';
    setPost($tytul, $tresc, $komentarze, $widocznosc, $id, $tagi, $autor);
}

?>
<h1>Dodaj Post</h1>
<div id="formularz">
<form action="addPost.php" method="post">
    <label>Tytul</label><br/>
    <input type="text" name="tytul"><br/>
    <label>Tresc</label><br/>
    <textarea rows="16" cols="115" name="tresc"></textarea><br/>
    <i>Dopuszczalne tagi: [b], [/b], [i], [/i], [u], [/u], [quote], [/quote], [code], [/code], [url], [/url],<br /> [img], [/img], [s], [/s], [center], [/center]</i><br/><br/>
    <label>Tagi</label><br/>
    <input type="text" name="tagi"><br/>
    <label>Autor</label><br/>
    <input type="text" name="autor"><br/><br/>
    <label>Wlacz komentarze</label>
    <input type="checkbox" name="komentarze" value="1" checked><br />
    <label>Wlacz widocznosc</label>
    <input type="checkbox" name="widocznosc" value="1" checked> <br />
    <label>Wybierz kategorie</label>
    <select name="kategoria">
        <?php
            getAllCategory();
        ?>
    </select>
    <input type="submit">
</form>
</div>

	</div>
	
		
	</div>
	
	<div id="footer">
	<p>Patryk Jastrz�bski 2013</p>
	</div>
	
</div>

</body>

</html>
<?php
//KONIEC ZALOGOWANIA

} else    { 
    $_SESSION['zalogowano']=0;
    header('Location: login.php'); 
}
?>