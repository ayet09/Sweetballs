<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost","root","","final_sweetballs");
if($conn->connect_error){
    die("DB Error");
}
?>