<?php
require "google-config.php";
require "db.php";

if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $google_service = new Google_Service_Oauth2($client);
    $data = $google_service->userinfo->get();

    $email = $data->email;
    $name = $data->name;

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $check->fetch_assoc();

    if (!$user) {
        $conn->query("INSERT INTO users(name,email,role) VALUES('$name','$email','user')");
        $user_id = $conn->insert_id;
    } else {
        $user_id = $user['id'];
    }

    $_SESSION['user'] = [
        "id" => $user_id,
        "name" => $name,
        "email" => $email,
        "role" => $user['role']
    ];

    header("Location: index.php");
    exit();
}