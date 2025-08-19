<?php
include_once __DIR__ . '/../../controller/CategoryController.php';

$id = $_GET['id'];
$category_controller = new CategoryController();
$category = $category_controller->getCategory($id);

$category_name = $category['name'] ?? '';
$error_name = '';
$error_image = '';
$image = '';

if (isset($_POST['update'])) {
    $category_name = $_POST['name'];
    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
    }

    if (!empty($category_name) && !empty($image)) {
        $targetDirectory = "../../uploads/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $status = $category_controller->editCategory($id,  $category_name, $image);
            if ($status) {
                header('location: category_list.php?update_status=success');
                exit;
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        if (empty($category_name)) {
            $error_name = "Please enter category name";
        }
        if (empty($image)) {
            $error_image = "Please choose an image";
        }
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4 text-dark">Edit Category</h3>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control rounded-3" value="<?php echo htmlspecialchars($category_name); ?>" id="categoryName">
                            <?php if ($error_name): ?>
                                <div class="text-danger small mt-1"><?php echo $error_name; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="categoryImage" class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control rounded-3" id="categoryImage">
                            <?php if ($error_image): ?>
                                <div class="text-danger small mt-1"><?php echo $error_image; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
                            <button type="reset" class="btn btn-outline-danger px-4">Clear</button>
                        </div>
                        <div class="text-end mt-4">
                            <a href="category_list.php" class="text-decoration-none">← Back to Category List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../../layouts/footer.php';
?>