<?php 
session_start();
@include('adminFunction.php');
if (isAdminLogin()) {
    //ZALOGOWANO!
if (!empty($_GET['id']) |
!empty($_GET['accept'])) 
{
    $id = $_GET['id'];
    $accept = $_GET['accept'];
    if (is_numeric($accept) && is_numeric($id)) {
    $db = connectDB();
    ($accept==1) ? $accept=1 : $accept=0;
    $query = "UPDATE  `db_blog`.`blog_komentarze` SET  `widocznosc` =  '$accept' WHERE  `blog_komentarze`.`id_komentarza` = $id";
    $db->query($query); 
    }   
}
}
header("Location: comments.php");
?>