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
    $id = $_GET['id'];
    if (!empty($_SESSION['capA']) && !empty($_SESSION['capB']) && ($_SESSION['capA']+$_SESSION['capB'])==$_POST['kod']) {
        setComment($pseudonim, $email, $tresc, $ip, $id);
    } else {
        $_SESSION['capA'] = rand(10, 60);
        $_SESSION['capB'] = rand(10, 60);
        header("Location: index.php?id=".$id.'&comm=2');
    }
     
} else { header("Location: index.php?id=".(int)$_GET['id']); }

?>

