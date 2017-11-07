<?php
session_start();
@include('adminFunction.php');
if (isAdminLogin() && $_GET['op']==1) 
{
    $_SESSION['zalogowano'] = 0;
    unset($_SESSION['zalogowano']);
    session_destroy();
    sleep(1);
    header('Location: login.php?out=1');
}
?>

