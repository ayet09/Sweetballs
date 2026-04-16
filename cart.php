<?php include "db.php"; ?>
<?php include "header.php"; ?>

<?php
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$total = 0;
?>

<div class="row justify-content-center">
<div class="col-md-8">
<div class="card shadow border-0">
<div class="card-body">
<h4 class="mb-3 text-center">My Cart</h4>

<?php if (empty($_SESSION['cart'])): ?>

    <div class="text-center text-muted">Your cart is empty.</div>

<?php else: ?>

    <?php foreach ($_SESSION['cart'] as $id => $qty): ?>

        <?php
        $id = (int)$id;
        if ($id <= 0) continue;

        $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $p = $stmt->get_result()->fetch_assoc();

        if (!$p) continue;

        $subtotal = $p['price'] * $qty;
        $total += $subtotal;
        ?>

        <div class="d-flex justify-content-between align-items-center border-bottom py-3">

            <div>
                <strong><?= htmlspecialchars($p['name']) ?></strong><br>
                    <small class="text-muted">Qty:</small>
                <form action="update_cart.php" method="POST" class="d-flex gap-2 mt-2">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="number" name="qty" value="<?= $qty ?>" min="1"
                        class="form-control form-control-sm" style="width:80px;">
                    <button class="btn btn-sm btn-dark">Edit</button>
                </form>

            </div>

            <div class="text-end">
                <div>₱<?= number_format($subtotal, 2) ?></div>

                <a href="remove_cart.php?id=<?= $id ?>"
                class="btn btn-sm btn-danger mt-1"
                onclick="return confirm('Remove this item?')">
                Remove
                </a>
            </div>

        </div>

        <?php endforeach; ?>

    <hr>

    <div class="d-flex justify-content-between">
        <h5>Total</h5>
        <h5>₱<?= number_format($total, 2) ?></h5>
    </div>

    <a href="order.php" class="btn btn-warning w-100 mt-3">
        Checkout
    </a>

<?php endif; ?>
</div>
</div>
</div>
</div>

<?php include "footer.php"; ?>