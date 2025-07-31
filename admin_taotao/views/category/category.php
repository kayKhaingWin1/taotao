<?php
include_once __DIR__ . '/../../layouts/header.php';
include_once __DIR__ . '/../../controller/CategoryController.php';

$id = $_GET['id'];
$category_controller = new CategoryController();
$category = $category_controller->getCategory($id);

?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow rounded-4 p-4" style="max-width: 800px; width: 100%;">
        <div class="row g-4 align-items-center">
           
            <div class="col-md-5 text-center">
                <img src="<?php echo '../../uploads/' . $category['image']; ?>" 
                     class="img-fluid rounded-3" 
                     alt="Category Image" 
                     style="max-height: 250px; object-fit: cover;">
            </div>

          
            <div class="col-md-7">
                <h4 class="mb-3 text-dark fw-semibold">Category Details</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0"><strong>ID:</strong> <?php echo $category['id']; ?></li>
                    <li class="list-group-item px-0"><strong>Name:</strong> <?php echo $category['name']; ?></li>
                 
                </ul>
                <div class="mt-4">
                    <a href="category_list.php" class="btn btn-outline-secondary me-2">← Back</a>
                    <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-warning">✏️ Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include_once __DIR__ . '/../../layouts/footer.php';
?>