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
if (!empty($_POST['tytul'])) 
{
    $tytul = $_POST['tytul'];
    $db = connectDB();
    setCategory($tytul);
}

?>
<h2>Dodaj Kategorie</h2>
<div id="formularz">
<form action="addCategory.php" method="post">
    <label>Nazwa:</label><br/>
    <input type="text" name="tytul"><br/>
    <input type="submit">
</form><br />
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