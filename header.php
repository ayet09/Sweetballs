<?php
include "db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current = basename($_SERVER['PHP_SELF']);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.nav-link.active {
    color: #ffc107 !important;
    font-weight: 600;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">

<a class="navbar-brand" href="index.php">Sweet Balls</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="nav">

    <ul class="navbar-nav ms-auto gap-2 text-center text-lg-end">

        <li class="nav-item">
            <a class="nav-link <?= $current == 'index.php' ? 'active' : '' ?>" href="index.php">
                Products
            </a>
        </li>

        <?php if(isset($_SESSION['user'])): ?>

            <li class="nav-item">
                <a class="nav-link <?= $current == 'cart.php' ? 'active' : '' ?>" href="cart.php">
                    Cart
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= $current == 'orders.php' ? 'active' : '' ?>" href="orders.php">
                    Orders
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= $current == 'profile.php' ? 'active' : '' ?>" href="profile.php">
                    Profile
                </a>
            </li>

            <?php if($_SESSION['user']['role'] === 'admin'): ?>
                <li class="nav-item">
                    <a href="admin/dashboard.php"
                       class="btn btn-danger btn-sm <?= strpos($current, 'dashboard.php') !== false ? 'border border-warning' : '' ?>">
                        Admin
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
            </li>

        <?php else: ?>

            <li class="nav-item">
                <a class="btn btn-warning btn-sm <?= $current == 'login.php' ? 'active' : '' ?>" href="login.php">
                    Login
                </a>
            </li>

        <?php endif; ?>

    </ul>

</div>
</div>
</nav>

<div class="container py-3">