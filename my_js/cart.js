$(function () {

    $('.qty-btn').click(function () {
        const cartId = $(this).data('id');
        const action = $(this).hasClass('increase') ? 'increase' : 'decrease';

        $.ajax({
            url: 'update_quantity.php',
            method: 'POST',
            data: { cart_id: cartId, action: action },
            success: function () {
                location.reload();
            }
        });
    });

    $('.btn-outline-danger').click(function () {
        const cartId = $(this).siblings('input[name="cart_id"]').val();

        if (confirm('Do you want to delete this item?')) {
            $.ajax({
                url: 'remove_item.php',
                method: 'POST',
                data: { cart_id: cartId },
                success: function () {
                    location.reload();
                }
            });
        }
    });

    $('#clear-cart').click(function () {
        if (confirm('Do you want to delete all items in your cart?')) {
            $.ajax({
                url: 'clear_cart.php',
                method: 'POST',
                success: function () {
                    location.reload();
                }
            });
        }
    });
});
