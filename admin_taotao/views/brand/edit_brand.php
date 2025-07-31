<?php
include_once __DIR__ . '/../../controller/BrandController.php';

$id = $_GET['id'];
$brand_controller = new BrandController();
$brand = $brand_controller->getBrand($id);

$name = $brand['name'] ?? '';
$profile = $brand['profile'] ?? '';
$address = $brand['address'] ?? '';
$error_name = $error_profile = $error_address = $error_profile_img = $error_bg_img = '';
$profile_img = $bg_img = '';

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $profile = $_POST['profile'];
    $address = $_POST['address'];
    $profile_img = $_FILES['profile_img']['name'] ?? '';
    $bg_img = $_FILES['bg_img']['name'] ?? '';

    if ($name && $profile && $address && $profile_img && $bg_img) {
        $uploadDir = "../../uploads/";
        move_uploaded_file($_FILES["profile_img"]["tmp_name"], $uploadDir . $profile_img);
        move_uploaded_file($_FILES["bg_img"]["tmp_name"], $uploadDir . $bg_img);
        $status = $brand_controller->editBrand($id, $name, $profile, $profile_img, $bg_img, $address);
        if ($status) {
            header('location: brand_list.php?update_status=success');
            exit;
        }
    } else {
        if (!$name) $error_name = "Enter brand name";
        if (!$profile) $error_profile = "Enter brand profile";
        if (!$address) $error_address = "Enter brand address";
        if (!$profile_img) $error_profile_img = "Upload profile image";
        if (!$bg_img) $error_bg_img = "Upload background image";
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4 text-dark">Edit Brand</h3>
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Brand Name</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="form-control rounded-3">
                            <?php if ($error_name): ?><div class="text-danger small"><?php echo $error_name; ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile</label>
                            <textarea name="profile" rows="4" class="form-control rounded-3"><?php echo htmlspecialchars($profile); ?></textarea>
                            <?php if ($error_profile): ?><div class="text-danger small"><?php echo $error_profile; ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" class="form-control rounded-3">
                            <?php if ($error_address): ?><div class="text-danger small"><?php echo $error_address; ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_img" class="form-control rounded-3">
                            <?php if ($error_profile_img): ?><div class="text-danger small"><?php echo $error_profile_img; ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Background Image</label>
                            <input type="file" name="bg_img" class="form-control rounded-3">
                            <?php if ($error_bg_img): ?><div class="text-danger small"><?php echo $error_bg_img; ?></div><?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
                            <a href="brand_list.php" class="btn btn-outline-secondary px-4">← Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
