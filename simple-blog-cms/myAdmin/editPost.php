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
	
		
            <div id="left">
                
<?php

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
    $kategoria = trim(addslashes(mysql_real_escape_string($_POST['kategoria'])));
    $db = connectDB();
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
    editPost($tytul, $tresc, $komentarze, $widocznosc, $id, $tagi, $autor, $_GET['id']);
}

?>
<h2>Edytuj Post</h2>
<div id="formularz">
<form action="editPost.php?id=<?php if (is_numeric($_GET['id'])) { echo($_GET['id']); } ?>" method="post">
<?php
    $db = connectDB();
    if (!is_numeric($_GET['id'])) 
        die("PROBA WLAMANIA!");
    $query = "SELECT * FROM blog_posty WHERE id_post=".(int)$_GET['id'];
    if ($result = $db->query($query)) 
	{
		$count = $result->num_rows;
		for($i=0; $i <$count; $i++) 
		{	
			$post = $result->fetch_assoc();
                        $tytul= trim(stripcslashes($post['tytul']));
                        $tresc =trim(stripcslashes($post['tresc']));
                        $tagi = trim(stripcslashes($post['tagi']));
                        $autor = trim(stripcslashes($post['autor']));
                        $widocznosc = trim(stripcslashes($post['widocznosc']));
                        $komentarze = trim(stripcslashes($post['komentarze']));
                        echo('<label>Tytul</label><br/>');
                        echo('<input type="text" name="tytul" value="'.$tytul.'"><br/>');                
                        echo('<label>Tresc</label><br/>');
                        echo('<textarea rows="16" cols="115" name="tresc">'.$tresc.'</textarea><br/>');
                        echo('<i>Dopuszczalne tagi: [b], [/b], [i], [/i], [u], [/u], [quote], [/quote], [code], [/code], [url], [/url],<br /> [img], [/img], [s], [/s], [center], [/center]</i><br/><br/>');
                        echo('<label>Tagi</label><br/>');
                        echo('<input type="text" name="tagi" value="'.$tagi.'"><br/>');
                        echo('<label>Autor</label><br/>');
                        echo('<input type="text" name="autor" value="'.$autor.'"><br/><br/>');
                        echo('<label>Wlacz komentarze</label>');
                        $komentarze==1 ? $komentarze='<input type="checkbox" name="komentarze" value="1" checked><br />' : $komentarze='<input type="checkbox" name="komentarze" value="1"><br />';
                        echo($komentarze);
                        echo('<label>Wlacz widocznosc</label>');
                        $widocznosc==1 ? $widocznosc='<input type="checkbox" name="widocznosc" value="1" checked> <br />' : $widocznosc='<input type="checkbox" name="widocznosc" value="1" <br />';
                        echo($widocznosc);
                        echo('<br /><select name="kategoria">');
                        getAllCategory();
                        echo('</select>');
                        echo('<br /><input type="submit">');         
                }
                }	
	$db->close();

?>  
</form><br/>
</div>
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

} else    { 
    $_SESSION['zalogowano']=0;
    header('Location: login.php'); 
}
?>