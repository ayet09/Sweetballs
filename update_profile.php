<?php
include "db.php";

$user_id = $_SESSION['user']['id'];
$bio = $_POST['bio'];

$pic_name = "";

if (!empty($_FILES['profile_pic']['name'])) {
    $pic_name = time() . "_" . $_FILES['profile_pic']['name'];
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/" . $pic_name);

    $conn->query("
        UPDATE users 
        SET bio='$bio', profile_pic='$pic_name'
        WHERE id=$user_id
    ");
} else {
    $conn->query("
        UPDATE users 
        SET bio='$bio'
        WHERE id=$user_id
    ");
}

header("Location: profile.php");
exit;