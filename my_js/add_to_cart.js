


$(function () {
  const $firstColor = $('.color-select').first();
  $firstColor.addClass('selected-color');
  $('#selectedColorName').text($firstColor.data('name'));

  const $firstSize = $('.size-select').first();
  $firstSize.addClass('selected-size');

  $('.color-select').click(function () {
    $('.color-select').removeClass('selected-color');
    $(this).addClass('selected-color');
    const name = $(this).data('name');
    $('#selectedColorName').text(name);
  });

  $('.size-select').click(function () {
    $('.size-select').removeClass('selected-size');
    $(this).addClass('selected-size');
    console.log("Size selected:", $(this).text());
  });
});

function showBootstrapAlert(message, type = 'success') {
  const alertContainer = document.getElementById('alertContainer');
  if (!alertContainer) return;

  const alert = document.createElement('div');
  alert.className = `alert alert-${type} alert-dismissible fade show`;
  alert.role = 'alert';
  alert.style.marginBottom = '10px';
  alert.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  alertContainer.appendChild(alert);

  setTimeout(() => {
    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
    bsAlert.close();
  }, 3000);
}

document.addEventListener('DOMContentLoaded', function () {
  const addToCartBtn = document.getElementById('addToCartBtn');

  if (addToCartBtn) {
    addToCartBtn.addEventListener('click', () => {
      const productId = addToCartBtn.getAttribute('data-product-id');

      const selectedSize = document.querySelector('.size-select.selected-size');
      const selectedColor = document.querySelector('.color-select.selected-color');

      if (!selectedSize || !selectedColor) {
        showBootstrapAlert('Please select size and color!', 'warning');
        return;
      }

      const sizeId = selectedSize.getAttribute('data-size');
      const colorId = selectedColor.getAttribute('data-color');

      const quantity = document.getElementById('qtyInput')?.value || 1;

      let productSizeColorId = null;

      for (const item of productSizeColorMap) {
        if (
          item.product_id == productId &&
          item.size_id == sizeId &&
          item.color_id == colorId
        ) {
          productSizeColorId = item.id;
          break;
        }
      }

      if (!productSizeColorId) {
        showBootstrapAlert('Invalid size or color selected!', 'danger');
        return;
      }

      fetch('add-to-cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `productSizeColorId=${productSizeColorId}&quantity=${quantity}`,
        credentials: 'include'
      })
        .then(res => res.json())
        .then(data => {
          showBootstrapAlert(data.message, 'success');
          updateCartCount();
        })
        .catch(err => {
          console.error('Error adding to cart:', err);
          showBootstrapAlert('Failed to add to cart. Please try again later.', 'danger');
        });

    });
  }
});

function adjustQty(amount) {
  let qty = parseInt($('#qtyInput').val());
  qty = isNaN(qty) ? 1 : qty + amount;
  if (qty < 1) qty = 1;
  $('#qtyInput').val(qty);
}
