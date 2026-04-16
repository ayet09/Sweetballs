<?php include "db.php"; ?>
<?php include "header.php"; ?>

<?php
if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user']['id'];
$res = $conn->query("SELECT * FROM orders WHERE user_id=$user ORDER BY id DESC");
?>

<div class="container">
<div class="row justify-content-center">
<div class="col-12 col-md-8">

<h4 class="mb-3">Order History</h4>

<?php if ($res->num_rows == 0): ?>
    <div class="text-muted">No orders found.</div>
<?php endif; ?>

<?php while ($o = $res->fetch_assoc()): ?>
<?php
$total = 0;

$totalRes = $conn->query("
    SELECT oi.quantity, p.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = {$o['id']}
");

while ($t = $totalRes->fetch_assoc()) {
    $total += $t['price'] * $t['quantity'];
}
?>
    
<div class="card shadow border-0 mb-3">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-2">
    <h6 class="mb-0">Order #<?= $o['id'] ?></h6>

    <span class="badge 
        <?= $o['status']=='pending'?'bg-warning':'' ?>
        <?= $o['status']=='shipped'?'bg-info':'' ?>
        <?= $o['status']=='delivered'?'bg-success':'' ?>
        <?= $o['status']=='cancelled'?'bg-danger':'' ?>
    ">
        <?= strtoupper($o['status']) ?>
    </span>
</div>
<div class="mb-2">
    <small class="text-muted">
        Name: <strong><?= htmlspecialchars($o['name']) ?></strong><br>
        Address: <?= htmlspecialchars($o['address']) ?><br>
        Payment: <?= htmlspecialchars($o['payment_method']) ?>
    </small>
</div>

<?php
$items = $conn->query("
    SELECT oi.*, p.name, p.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = {$o['id']}
");
?>

<?php while ($i = $items->fetch_assoc()): ?>
<div class="d-flex justify-content-between border-bottom py-1">
    <div>
        <?= $i['name'] ?> x<?= $i['quantity'] ?>
    </div>
    <div>
        ₱<?= number_format($i['price'] * $i['quantity'], 2) ?>
    </div>
</div>
<?php endwhile; ?>
<div class="d-flex justify-content-between mb-2">
    <strong>Total:</strong>
    <strong>₱<?= number_format($total, 2) ?></strong>
</div>
<?php if ($o['status'] == 'pending'): ?>
<form method="POST" action="cancel_order.php" class="mt-3">
    <input type="hidden" name="id" value="<?= $o['id'] ?>">
    <button class="btn btn-danger btn-sm w-100"
        onclick="return confirm('Cancel this order?')">
        Cancel Order
    </button>
</form>
<?php endif; ?>
</div>
</div>

<?php endwhile; ?>
</div>
</div>
</div>

<?php include "footer.php"; ?>