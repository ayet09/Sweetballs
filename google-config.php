<?php
require "vendor/autoload.php";

$client = new Google_Client();
$client->setClientId("947906945362-tmghums17s0387lp3c2l6maq9lvdbhej.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/Sweetballs_ecommerce_final/google-callback.php");

$client->addScope("email");
$client->addScope("profile");
?>