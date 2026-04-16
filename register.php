<?php include "db.php";

if($_POST){
$name=$_POST['name'];
$email=$_POST['email'];
$pass=md5($_POST['password']);

$conn->query("INSERT INTO users(name,email,password) VALUES('$name','$email','$pass')");
header("Location: login.php");
}
?>

<?php include "header.php"; ?>

<h3 class="text-center">Register</h3>
<form method="POST" class="col-md-4 mx-auto">
<label class="form-label">Full Name</label>
<input class="form-control mb-2" name="name" required>
<label class="form-label">Email</label>
<input class="form-control mb-2" name="email" required>
<label class="form-label">Password</label>
<input class="form-control mb-2" type="password" name="password" required>
<button class="btn btn-warning w-100">Register</button>
</form>

<div class="text-center mt-2">
    <a href="login.php">Already have an account? Login</a>
</div>

<?php include "footer.php"; ?>