<?php
session_start();

// Sepetten Etkinliği Kaldır
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    unset($_SESSION['cart'][$id]);
    header('Location: cart_page.php');
    exit();
}
?>
