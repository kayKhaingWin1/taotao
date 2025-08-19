
function addFavourite(productId) {
    $.ajax({
        url: 'api/favourite.php?action=add',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ product_id: productId }),
        success: function(response) {
            if (response.success) {
                alert('Added to favourites!');
            } else {
                alert(response.message);
            }
        }
    });
}


function loadFavourites() {
    $.ajax({
        url: 'api/favourite.php?action=list',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                renderFavourites(response.data);
            }
        }
    });
}