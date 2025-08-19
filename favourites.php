<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Favourites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">My Favourites</h1>
        <div id="favourites-container" class="row">
   
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        loadFavourites();
        
        function loadFavourites() {
            $.ajax({
                url: 'api/favourite.php?action=list',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderFavourites(response.data);
                    } else {
                        $('#favourites-container').html('<p>'+response.message+'</p>');
                    }
                }
            });
        }
        
        function renderFavourites(products) {
            let html = '';
            if (products.length > 0) {
                products.forEach(product => {
                    html += `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="images/${product.image}" class="card-img-top" alt="${product.name}">
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">${product.price} Ks</p>
                                <button onclick="removeFavourite(${product.id})" class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>`;
                });
            } else {
                html = '<p>You have no favourite items yet.</p>';
            }
            $('#favourites-container').html(html);
        }
        
        window.removeFavourite = function(productId) {
            if (confirm('Remove this item from favourites?')) {
                $.ajax({
                    url: 'api/favourite.php?action=remove',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ product_id: productId }),
                    success: function(response) {
                        if (response.success) {
                            loadFavourites(); 
                        }
                        alert(response.message);
                    }
                });
            }
        };
    });
    </script>
</body>
</html>