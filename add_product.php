<?php
// Include necessary files and initialize classes
require_once 'config.php';
require_once 'Product.php';
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

// Save product if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $productType = $_POST['productType'];

    // Check if SKU already exists
    if (Product::isSkuExists($sku)) {
        echo json_encode(['success' => false, 'message' => 'SKU already exists']);
        exit;
    }

    // Create instance of the selected product type
    $product = Product::createProduct($productType);
    $product->setSku($sku);
    $product->setName($name);
    $product->setPrice($price);

    // Set product-specific attributes
    if ($product instanceof DVD) {
        $size = $_POST['size'];
        $product->setSize($size);
    } elseif ($product instanceof Book) {
        $weight = $_POST['weight'];
        $product->setWeight($weight);
    } elseif ($product instanceof Furniture) {
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        $product->setDimensions($height, $width, $length);
    }

    // Save the product
    $product->save();

    echo json_encode(['success' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <!-- Include Bootstrap CSS if used -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Update form based on selected product type
            $('#productType').change(function() {
                var productType = $(this).val();
                $('.product-attribute').hide();
                $('#' + productType).show();
            });

            // Form submission
            $('#product_form').submit(function(e) {
                e.preventDefault();

                var sku = $('#sku').val();
                var name = $('#name').val();
                var price = $('#price').val();
                var productType = $('#productType').val();
                var formData = {
                    sku: sku,
                    name: name,
                    price: price,
                    productType: productType
                };

                // Add product-specific attributes to form data
                if (productType === 'dvd') {
                    formData.size = $('#size').val();
                } else if (productType === 'book') {
                    formData.weight = $('#weight').val();
                } else if (productType === 'furniture') {
                    formData.height = $('#height').val();
                    formData.width = $('#width').val();
                    formData.length = $('#length').val();
                }

                // Submit form data
                $.post('add_product.php', formData, function(response) {
                    if (response.success = true) {
                        console.log('sucesss')
                        location.href = 'index.php';
                    } else {
                        // location.href = 'index.php';
                        alert(response.message);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <form id="product_form">
            <div class="form-group">
                <label for="sku">SKU:</label>
                <input type="text" id="sku" name="sku" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="productType">Product Type:</label>
                <select id="productType" name="productType" class="form-control" required>
                    <option value="dvd">DVD</option>
                    <option value="book">Book</option>
                    <option value="furniture">Furniture</option>
                </select>
            </div>
            <div class="form-group product-attribute" id="dvd" style="display: none;">
                <label for="size">Size (MB):</label>
                <input type="number" id="size" name="size" class="form-control">
            </div>
            <div class="form-group product-attribute" id="book" style="display: none;">
                <label for="weight">Weight (Kg):</label>
                <input type="number" id="weight" name="weight" class="form-control">
            </div>
            <div class="form-group product-attribute" id="furniture" style="display: none;">
                <label for="height">Height:</label>
                <input type="number" id="height" name="height" class="form-control">
                <label for="width">Width:</label>
                <input type="number" id="width" name="width" class="form-control">
                <label for="length">Length:</label>
                <input type="number" id="length" name="length" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
