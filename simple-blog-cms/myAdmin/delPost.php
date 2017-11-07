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


if (!empty($_POST['akceptacja']) && $_POST['akceptacja']==1 && is_numeric($_GET['id'])) 
{
    $result = delPost($_GET['id']);
    echo $result ? "usunieto" : "nie usunieto";
    header("Location: index.php"); /* Redirect browser */
}
?>
<h2>Usuń Post</h2><br/>
<form action="delPost.php?id=<?php if (is_numeric($_GET['id'])) { echo($_GET['id']); } ?>" method="post"><p class="tresc">
Czy chcesz usunąć post o id <?php if (is_numeric($_GET['id'])) { echo($_GET['id']); } ?>?<br />
 <input type="checkbox" name="akceptacja" value="1"> 
 <label>Tak, chce usunąć </label><br />
<input type="submit">
    </p></form><br/>
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