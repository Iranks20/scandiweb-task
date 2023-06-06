<?php
// Include necessary files and initialize classes
require_once 'config.php';
require_once 'Product.php';
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

// fetch all products
$products = Product::getAllProducts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <!-- Include Bootstrap CSS if used -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mass delete action
            $('#mass_delete_btn').click(function() {
                var selectedProducts = $('.delete-checkbox:checked').map(function() {
                    return $(this).data('product-id');
                }).get();

                if (selectedProducts.length > 0) {
                    $.post('delete_products.php', {productIds: selectedProducts}, function(response) {
                        if (response.success = true) {
                        console.log('sucesss')
                        location.href = 'index.php';
                        } else {
                            // location.href = 'index.php';
                            alert(response.message);
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Product List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Product Attribute</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product->getSku(); ?></td>
                        <td><?php echo $product->getName(); ?></td>
                        <td><?php echo $product->getPrice(); ?></td>
                        <td><?php echo $product->getAttribute(); ?></td>
                        <td><input type="checkbox" class="delete-checkbox" data-product-id="<?php echo $product->getId(); ?>"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button id="mass_delete_btn" class="btn btn-danger">MASS DELETE</button>
        <a href="add_product.php" class="btn btn-primary">ADD</a>
    </div>
</body>
</html>
