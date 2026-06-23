<?php
if(!isset($_SESSION['user'])){
    header("Location: /shop-app/login.php");
    exit;
}
?>