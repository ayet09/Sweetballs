<?php include "db.php"; ?>
<?php include "header.php"; ?>

<?php
if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

if (isset($_POST['checkout'])) {

    $user_id = (int)$_SESSION['user']['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $payment = $_POST['payment'];

    $stmt = $conn->prepare("
        INSERT INTO orders(user_id, name, address, payment_method, status)
        VALUES(?,?,?,?, 'pending')
    ");

    $stmt->bind_param("isss", $user_id, $name, $address, $payment);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    foreach ($_SESSION['cart'] as $product_id => $qty) {

        $product_id = (int)$product_id;
        $qty = (int)$qty;

        $conn->query("
            INSERT INTO order_items(order_id, product_id, quantity)
            VALUES($order_id, $product_id, $qty)
        ");
    }

    unset($_SESSION['cart']);

    header("Location: orders.php");
    exit;
}
?>

<div class="container">
<div class="row justify-content-center">
<div class="col-md-6">

<div class="card shadow border-0 p-3">
<h4>Checkout</h4>

<form method="POST">

<input name="name" class="form-control mb-2"
       value="<?= htmlspecialchars($_SESSION['user']['name']) ?>"
       readonly>

<textarea name="address" class="form-control mb-2" placeholder="Delivery Address" required></textarea>

<select name="payment" class="form-control mb-3" required>
    <option value="">Select Payment Method</option>
    <option value="COD">Cash on Delivery</option>
    <option value="GCASH">GCash</option>
    <option value="CARD">Card</option>
</select>

<button name="checkout" class="btn btn-warning w-100">
    Place Order
</button>

</form>

</div>

</div>
</div>
</div>

<?php include "footer.php"; ?>