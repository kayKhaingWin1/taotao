<?php
include_once __DIR__ . '/../../controller/BrandController.php';

$brand_controller = new BrandController();

$name = '';
$profile = '';
$address = '';
$profile_img = '';
$bg_img = '';

$error_name = '';
$error_profile = '';
$error_address = '';
$error_profile_img = '';
$error_bg_img = '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $profile = $_POST['profile'];
    $address = $_POST['address'];

    if (isset($_FILES['profile_img'])) {
        $profile_img = $_FILES['profile_img']['name'];
    }
    if (isset($_FILES['bg_img'])) {
        $bg_img = $_FILES['bg_img']['name'];
    }

    // 表单验证
    if (!empty($name) && !empty($profile) && !empty($address) && !empty($profile_img) && !empty($bg_img)) {
        $targetDirectory = "../../uploads/";
        $profileImgTarget = $targetDirectory . basename($profile_img);
        $bgImgTarget = $targetDirectory . basename($bg_img);

        if (
            move_uploaded_file($_FILES["profile_img"]["tmp_name"], $profileImgTarget) &&
            move_uploaded_file($_FILES["bg_img"]["tmp_name"], $bgImgTarget)
        ) {
            $status = $brand_controller->addBrand($name, $profile, $profile_img, $bg_img, $address);
            if ($status) {
                header('location: brand_list.php?status=success');
                exit;
            }
        } else {
            echo "Error uploading image files.";
        }
    } else {
        if (empty($name)) $error_name = "Please enter brand name";
        if (empty($profile)) $error_profile = "Please enter brand profile";
        if (empty($address)) $error_address = "Please enter address";
        if (empty($profile_img)) $error_profile_img = "Please choose profile image";
        if (empty($bg_img)) $error_bg_img = "Please choose background image";
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4 text-dark">Add New Brand</h3>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="brandName" class="form-label">Brand Name</label>
                            <input type="text" name="name" id="brandName" class="form-control rounded-3" value="<?php echo htmlspecialchars($name); ?>">
                            <?php if ($error_name): ?>
                                <div class="text-danger small mt-1"><?php echo $error_name; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="brandProfile" class="form-label">Profile</label>
                            <textarea name="profile" id="brandProfile" class="form-control rounded-3" rows="4"><?php echo htmlspecialchars($profile); ?></textarea>
                            <?php if ($error_profile): ?>
                                <div class="text-danger small mt-1"><?php echo $error_profile; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="brandAddress" class="form-label">Address</label>
                            <input type="text" name="address" id="brandAddress" class="form-control rounded-3" value="<?php echo htmlspecialchars($address); ?>">
                            <?php if ($error_address): ?>
                                <div class="text-danger small mt-1"><?php echo $error_address; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="profileImg" class="form-label">Profile Image</label>
                            <input type="file" name="profile_img" id="profileImg" class="form-control rounded-3">
                            <?php if ($error_profile_img): ?>
                                <div class="text-danger small mt-1"><?php echo $error_profile_img; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="bgImg" class="form-label">Background Image</label>
                            <input type="file" name="bg_img" id="bgImg" class="form-control rounded-3">
                            <?php if ($error_bg_img): ?>
                                <div class="text-danger small mt-1"><?php echo $error_bg_img; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="submit" class="btn btn-success px-4">Add Brand</button>
                            <button type="reset" class="btn btn-outline-danger px-4">Clear</button>
                        </div>

                        <div class="text-end mt-4">
                            <a href="brand_list.php" class="text-decoration-none">← Back to Brand List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
