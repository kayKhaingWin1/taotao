<?php
include_once __DIR__ . '/../../controller/SubcategoryController.php';
include_once __DIR__ . '/../../controller/CategoryController.php';

$subcategory_controller = new SubcategoryController();
$category_controller = new CategoryController();
$categories = $category_controller->getCategories();

$name = '';
$image = '';
$cat_id = '';
$error_name = '';
$error_image = '';
$error_cat_id = '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $cat_id = $_POST['cat_id'];
    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
    }

    if (!empty($name) && !empty($image) && !empty($cat_id)) {
        $targetDirectory = "../../uploads/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $status = $subcategory_controller->addSubcategory($name, $image, $cat_id);
            if ($status) {
                header('location: subcategory_list.php?status=success');
                exit;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        if (empty($name)) {
            $error_name = "Please enter subcategory name";
        }
        if (empty($image)) {
            $error_image = "Please choose an image";
        }
        if (empty($cat_id)) {
            $error_cat_id = "Please select a category";
        }
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container mt-5 bg-body-tertiary">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4 text-dark">Add New Subcategory</h3>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="subcategoryName" class="form-label">Subcategory Name</label>
                            <input type="text" name="name" id="subcategoryName" class="form-control rounded-3" value="">
                            <?php if ($error_name): ?>
                                <div class="text-danger small mt-1"><?php echo $error_name; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="subcategoryImage" class="form-label">Subcategory Image</label>
                            <input type="file" name="image" id="subcategoryImage" class="form-control rounded-3">
                            <?php if ($error_image): ?>
                                <div class="text-danger small mt-1"><?php echo $error_image; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="categorySelect" class="form-label">Select Category</label>
                            <select name="cat_id" id="categorySelect" class="form-select rounded-3">
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $cat_id) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($error_cat_id): ?>
                                <div class="text-danger small mt-1"><?php echo $error_cat_id; ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="submit" class="btn btn-success px-4">Add Subcategory</button>
                            <button type="reset" class="btn btn-outline-danger px-4">Clear</button>
                        </div>
                        <div class="text-end mt-4">
                            <a href="subcategory_list.php" class="text-decoration-none">← Back to Subcategory List</a>
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
