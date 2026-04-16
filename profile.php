<?php include "db.php"; ?>
<?php include "header.php"; ?>

<?php
if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
?>

<div class="container py-4">
<div class="row justify-content-center">
<div class="col-12 col-md-6">
<div class="card shadow border-0">

    <div class="card-body text-center p-4">

        <?php if (!empty($user['profile_pic'])): ?>
            <img src="uploads/<?= $user['profile_pic'] ?>"
                 class="rounded-circle mb-3 border"
                 width="120" height="120"
                 style="object-fit: cover;">
        <?php else: ?>
            <div class="rounded-circle bg-secondary mb-3 mx-auto d-flex align-items-center justify-content-center text-white"
                 style="width:120px;height:120px;font-size:40px;">
                <?= strtoupper(substr($user['name'],0,1)) ?>
            </div>
        <?php endif; ?>

        <h5 class="mb-1"><?= $user['name'] ?></h5>
        <small class="text-muted"><?= $user['email'] ?></small>

        <hr>

        <p class="text-muted mb-3">
            <?= !empty($user['bio']) ? nl2br($user['bio']) : "No bio added yet." ?>
        </p>

        <button class="btn btn-warning btn-sm" onclick="toggleEdit()">
            Edit Profile
        </button>

    </div>

    <div class="card-footer bg-light" id="editForm" style="display:none;">

        <form action="update_profile.php" method="POST" enctype="multipart/form-data">

            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-control mb-2"
                      rows="3"><?= $user['bio'] ?></textarea>

            <label class="form-label">Profile Picture</label>
            <input type="file" name="profile_pic" class="form-control mb-3">

            <button class="btn btn-warning w-100">Save Changes</button>

        </form>

    </div>

</div>
</div>
</div>
</div>

<script>
function toggleEdit() {
    const form = document.getElementById("editForm");
    form.style.display = (form.style.display === "none") ? "block" : "none";
}
</script>

<?php include "footer.php"; ?>