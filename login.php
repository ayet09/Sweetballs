<?php include "db.php"; ?>
<?php require "google-config.php";

$login_url = $client->createAuthUrl();
?>

<?php
if ($_POST) {
    $email = $_POST['email'];
    $pass = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $_SESSION['user'] = [
            "id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
            "role" => $user['role']
        ];

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<?php include "header.php"; ?>

<h3 class="text-center">Login</h3>

<form method="POST" class="col-md-4 mx-auto">
<label class="form-label">Email</label>
<input class="form-control mb-2" name="email" required>
<label class="form-label">Password</label>
<input class="form-control mb-2" type="password" name="password" required>
<button class="btn btn-warning w-100">Login</button>
</form>
<div class="text-center mt-2">
    <label class="form-label">or</label>
</div>
<div class="text-center mt-3">
<a href="<?= $login_url ?>" class="btn btn-danger">Login with Google</a>
</div>

<div class="text-center mt-2">
    <a href="register.php">Don't have an account? Register</a>
</div>

<?php include "footer.php"; ?>