<?php
include_once __DIR__ . '/../model/Favourite.php';

class FavouriteController
{
    private $favourite;

    public function __construct()
    {
        $this->favourite = new Favourite();
    }

    // 添加收藏
    public function addFavourite($userId, $productId)
    {
        if ($this->favourite->isFavourite($userId, $productId)) {
            return ['success' => false, 'message' => 'Product already in favourites'];
        }
        
        return $this->favourite->addFavourite($userId, $productId) 
            ? ['success' => true, 'message' => 'Added to favourites']
            : ['success' => false, 'message' => 'Failed to add to favourites'];
    }

  
    public function removeFavourite($userId, $productId)
    {
        return $this->favourite->removeFavourite($userId, $productId)
            ? ['success' => true, 'message' => 'Removed from favourites']
            : ['success' => false, 'message' => 'Failed to remove from favourites'];
    }

    public function getFavourites($userId)
    {
        $favourites = $this->favourite->getUserFavourites($userId);
        return $favourites 
            ? ['success' => true, 'data' => $favourites]
            : ['success' => false, 'message' => 'No favourites found'];
    }

    public function checkFavourite($userId, $productId)
    {
        return [
            'success' => true,
            'isFavourite' => $this->favourite->isFavourite($userId, $productId)
        ];
    }
}
?>