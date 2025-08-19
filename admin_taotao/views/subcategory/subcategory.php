<?php
include_once __DIR__ . '/../../layouts/header.php';
include_once __DIR__ . '/../../controller/SubcategoryController.php';
include_once __DIR__ . '/../../controller/CategoryController.php';

$id = $_GET['id'];
$subcategory_controller = new SubcategoryController();
$category_controller = new CategoryController();

$subcategory = $subcategory_controller->getSubcategory($id);
$category = $category_controller->getCategory($subcategory['cat_id']);
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow rounded-4 p-4" style="max-width: 800px; width: 100%;">
        <div class="row g-4 align-items-center">
            <div class="col-md-5 text-center">
                <img src="<?php echo '../../uploads/' . $subcategory['image']; ?>" 
                     class="img-fluid rounded-3" 
                     alt="Subcategory Image" 
                     style="max-height: 250px; object-fit: cover;">
            </div>

            <div class="col-md-7">
                <h4 class="mb-3 text-dark fw-semibold">Subcategory Details</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0"><strong>ID:</strong> <?php echo $subcategory['id']; ?></li>
                    <li class="list-group-item px-0"><strong>Name:</strong> <?php echo htmlspecialchars($subcategory['name']); ?></li>
                    <li class="list-group-item px-0"><strong>Category:</strong> <?php echo htmlspecialchars($category['name']); ?></li>
                </ul>
                <div class="mt-4">
                    <a href="subcategory_list.php" class="btn btn-outline-secondary me-2">← Back</a>
                    <a href="edit_subcategory.php?id=<?php echo $subcategory['id']; ?>" class="btn btn-warning">✏️ Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
