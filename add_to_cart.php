<?php
include "db.php";

$id = $_POST['id'];
$qty = $_POST['qty'];

if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = 0;
}

$_SESSION['cart'][$id] += $qty;

header("Location: cart.php");
exit;