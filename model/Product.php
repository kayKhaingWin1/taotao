<?php
include_once __DIR__ . '/../include/dbconfig.php';

class Product
{
    private $conn, $statement;

    public function __construct()
    {
        $this->conn = Database::connect();
    }

    public function getProducts()
    {
        $sql = "SELECT * FROM product WHERE status IS NULL OR status != 'deleted'";
        $this->statement = $this->conn->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduct($id)
{
    $sql = "SELECT p.*, 
                   b.name AS brand_name,
                   sc.name AS subcategory_name
            FROM product p
            LEFT JOIN brand b ON p.brand_id = b.id
            LEFT JOIN subcategory sc ON p.sub_id = sc.id
            WHERE p.id = :id AND (p.status IS NULL OR p.status != 'deleted')";

    $this->statement = $this->conn->prepare($sql);
    $this->statement->bindParam(':id', $id);
    $this->statement->execute();
    return $this->statement->fetch(PDO::FETCH_ASSOC);
}



public function getFilteredProducts($keyword = null, $filters = [], $sort = null, $categoryId = null)

{
    $sql = "SELECT p.*, 
               GROUP_CONCAT(DISTINCT c.color_code) AS color_codes,
               GROUP_CONCAT(DISTINCT s.size) AS sizes,
               b.name AS brand_name,
               sc.name AS subcategory_name
        FROM product p
        LEFT JOIN product_size_color psc ON p.id = psc.product_id
        LEFT JOIN color c ON psc.color_id = c.id
        LEFT JOIN size s ON psc.size_id = s.id
        LEFT JOIN brand b ON p.brand_id = b.id
        LEFT JOIN subcategory sc ON p.sub_id = sc.id
        LEFT JOIN discount_product dp ON p.id = dp.product_id
        WHERE (p.status IS NULL OR p.status != 'deleted')";

    if (!empty($keyword)) {
        $sql .= " AND (p.name LIKE :keyword OR b.name LIKE :keyword OR sc.name LIKE :keyword)";
    }

    if (!empty($categoryId)) {
    $sql .= " AND sc.cat_id = :category_id";
}

    if (!empty($filters['subcategory'])) {
        $sql .= " AND p.sub_id = :subcategory";
    }

    if (!empty($filters['brand'])) {
        $sql .= " AND p.brand_id = :brand";
    }

    if (!empty($filters['color'])) {
        $sql .= " AND c.id = :color";
    }

    if (!empty($filters['size'])) {
        $sql .= " AND s.id = :size";
    }

    if (!empty($filters['price_min'])) {
        $sql .= " AND p.price >= :price_min";
    }

    if (!empty($filters['price_max'])) {
        $sql .= " AND p.price <= :price_max";
    }

    if (!empty($filters['has_discount']) && $filters['has_discount'] == '1') {
        $sql .= " AND dp.discount_id IS NOT NULL";
    }

    $sql .= " GROUP BY p.id";

    if ($sort === 'price_asc') {
        $sql .= " ORDER BY p.price ASC";
    } elseif ($sort === 'price_desc') {
        $sql .= " ORDER BY p.price DESC";
    } elseif ($sort === 'name_asc') {
        $sql .= " ORDER BY p.name ASC";
    } elseif ($sort === 'name_desc') {
        $sql .= " ORDER BY p.name DESC";
    } else {
        $sql .= " ORDER BY p.id DESC";
    }

    $this->statement = $this->conn->prepare($sql);

    if (!empty($keyword)) {
        $keywordParam = '%' . $keyword . '%';
        $this->statement->bindParam(':keyword', $keywordParam);
    }
    if (!empty($categoryId)) {
    $this->statement->bindParam(':category_id', $categoryId);
}

    if (!empty($filters['subcategory'])) {
        $this->statement->bindParam(':subcategory', $filters['subcategory']);
    }
    if (!empty($filters['brand'])) {
        $this->statement->bindParam(':brand', $filters['brand']);
    }
    if (!empty($filters['color'])) {
        $this->statement->bindParam(':color', $filters['color']);
    }
    if (!empty($filters['size'])) {
        $this->statement->bindParam(':size', $filters['size']);
    }
    if (!empty($filters['price_min'])) {
        $this->statement->bindParam(':price_min', $filters['price_min']);
    }
    if (!empty($filters['price_max'])) {
        $this->statement->bindParam(':price_max', $filters['price_max']);
    }

    $this->statement->execute();
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
}

}
