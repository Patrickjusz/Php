<?php
session_start();
@include('function.php');
if (
!empty($_POST['pseudonim']) |
!empty($_POST['email']) |
!empty($_POST['tresc']) | 
!empty($_POST['kod'])) 
{
    $pseudonim = $_POST['pseudonim'];
    $email =$_POST['email'];
    $tresc = $_POST['tresc'];
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SESSION['capA']) && !empty($_SESSION['capB']) && ($_SESSION['capA']+$_SESSION['capB'])==$_POST['kod']) {
        $zawartosc = $pseudonim.$email.$tresc.$ip;
        mail('sirsmark@wp.pl', 'Kontakt myBlog', $zawartosc);
        header("Location: index.php?contact=3");    //3 poprawne
    } else {
        $_SESSION['capA'] = rand(10, 60);
        $_SESSION['capB'] = rand(10, 60);
        header("Location: index.php?contact=2"); //2 niepoprawnie
    }
     
} else { header("Location: index.php?contact=2"); } //niepoprawne

?>

