<?php

abstract class Product
{
    protected $id;
    
    protected $sku;
    protected $name;
    protected $price;
    protected $attribute;

    // Database connection and table name
    protected static $conn;
    protected static $table = 'products';

    public static function setConnection($connection)
    {
        self::$conn = $connection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public static function getAllProducts()
{
    $query = "SELECT * FROM " . self::$table;
    $stmt = self::$conn->query($query);

    $products = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product = self::createProduct($row['product_type']);

        if ($product !== null) {
            $product->id = $row['id'];
            $product->sku = $row['sku'];
            $product->name = $row['name'];
            $product->price = $row['price'];

            if ($product instanceof DVD) {
                $product->setSize($row['size']);
            } elseif ($product instanceof Book) {
                $product->setWeight($row['weight']);
            } elseif ($product instanceof Furniture) {
                $product->setDimensions($row['height'], $row['width'], $row['length']);
            }

            $products[] = $product;
        }
    }

    return $products;
}


    public static function getProductById($id)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE id = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->execute([$id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productType = $row['product_type'];
            $product = self::createProduct($productType);
            $product->id = $row['id'];
            $product->sku = $row['sku'];
            $product->name = $row['name'];
            $product->price = $row['price'];

            // Set product-specific attributes
            if ($productType === 'dvd') {
                $product->attribute = $row['size'] . ' MB';
            } elseif ($productType === 'book') {
                $product->attribute = $row['weight'] . ' Kg';
            } elseif ($productType === 'furniture') {
                $product->attribute = $row['dimensions'];
            }

            return $product;
        }

        return null;
    }

    public static function isSkuExists($sku)
    {
        $query = "SELECT COUNT(*) FROM " . self::$table . " WHERE sku = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->execute([$sku]);

        return $stmt->fetchColumn() > 0;
    }

    public function save()
    {
        // Check if SKU already exists
        if ($this->id === null && self::isSkuExists($this->sku)) {
            return false;
        }

        if ($this->id === null) {
            // Insert new product
            $query = "INSERT INTO " . self::$table . " (sku, name, price, product_type, size, weight, dimensions)
                      VALUES (:sku, :name, :price, :productType, :size, :weight, :dimensions)";
        } else {
            // Update existing product
            $query = "UPDATE " . self::$table . " SET sku = :sku, name = :name, price = :price,
                      product_type = :productType, size = :size, weight = :weight, dimensions = :dimensions
                      WHERE id = :id";
        }

        $stmt = self::$conn->prepare($query);

        $stmt->bindValue(':sku', $this->sku);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':price', $this->price);
        $stmt->bindValue(':productType', $this->getProductType());

        if ($this instanceof DVD) {
            $stmt->bindValue(':size', $this->getSize());
            $stmt->bindValue(':weight', null);
            $stmt->bindValue(':dimensions', null);
        } elseif ($this instanceof Book) {
            $stmt->bindValue(':size', null);
            $stmt->bindValue(':weight', $this->getWeight());
            $stmt->bindValue(':dimensions', null);
        } elseif ($this instanceof Furniture) {
            $stmt->bindValue(':size', null);
            $stmt->bindValue(':weight', null);
            $stmt->bindValue(':dimensions', $this->getDimensions());
        }

        if ($this->id !== null) {
            $stmt->bindValue(':id', $this->id);
        }

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM " . self::$table . " WHERE id = ?";
        $stmt = self::$conn->prepare($query);
        return $stmt->execute([$this->id]);
    }

    abstract protected function getProductType();

    public static function createProduct($productType)
    {
        switch ($productType) {
            case 'dvd':
                return new DVD();
            case 'book':
                return new Book();
            case 'furniture':
                return new Furniture();
            default:
                return null;
        }
    }
}
