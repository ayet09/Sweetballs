<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

<?php include "header.php"; ?>

<h2 class="text-center mb-4">Products</h2>

<div class="text-center mb-3">

<a href="index.php" class="btn btn-sm btn-secondary">All</a>

<?php
$cats = $conn->query("SELECT * FROM categories");
while ($c = $cats->fetch_assoc()):
?>
    <a href="index.php?cat=<?= $c['id'] ?>" class="btn btn-sm btn-warning">
        <?= htmlspecialchars($c['name']) ?>
    </a>
<?php endwhile; ?>

</div>

<?php
$sql = "
    SELECT products.*, categories.name AS category_name
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
";

if (isset($_GET['cat'])) {
    $cat = (int)$_GET['cat'];
    $sql .= " WHERE category_id = $cat";
}

$res = $conn->query($sql);
?>

<div class="row">
<?php while($p=$res->fetch_assoc()): ?>
<div class="col-md-4">
<div class="card shadow mb-3">

<img src="images/<?php echo $p['image']; ?>" class="card-img-top">

<div class="card-body text-center">

<h5><?php echo $p['name']; ?></h5>

<small class="text-muted">
    <?= $p['category_name'] ? htmlspecialchars($p['category_name']) : 'Uncategorized' ?>
</small>

<p>₱<?php echo $p['price']; ?></p>

<form action="add_to_cart.php" method="POST">
<input type="hidden" name="id" value="<?php echo $p['id']; ?>">
<input type="number" name="qty" value="1" class="form-control mb-2">
<button class="btn btn-warning w-100">Add to Cart</button>
</form>

</div>
</div>
</div>
<?php endwhile; ?>
</div>

<?php include "footer.php"; ?>
</body>
</html>