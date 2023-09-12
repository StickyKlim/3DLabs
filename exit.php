<?php 
    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['error']);
    header_remove();
    header("location: adminin.php");
?>