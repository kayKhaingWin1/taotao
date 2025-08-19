<?php
include_once __DIR__ . '/../model/Cart.php';

class CartController
{
    private $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function addToCart($user_id, $product_size_color_id, $quantity)
    {
        return $this->cart->addToCart($user_id, $product_size_color_id, $quantity);
    }

    public function getCartItems($user_id)
    {
        return $this->cart->getCartItems($user_id);
    }

    public function removeFromCart($cart_id)
    {
        return $this->cart->removeFromCart($cart_id);
    }

    public function clearCart($user_id)
    {
        return $this->cart->clearCart($user_id);
    }

    public function getUniqueCartCount($user_id)
{
    return $this->cart->getUniqueCartItemCount($user_id);
}

 public function updateCartQuantity($cart_id,$quantity)
{
    return $this->cart->updateCartQuantity($cart_id,$quantity);
}

}
