<?php
require_once 'bootstrap.php';

(new CProducts())->seedProductsTable(10);
$products = (new CProducts())->getProducts();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<table class="container">
    <tr>
        <th>Product id</th>
        <th>Product price</th>
        <th>Product quantity</th>
        <th>Product name</th>
        <th>Product article</th>
        <th>Hide</th>
    </tr>

    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product->product_id ?></td>
            <td><?= $product->product_price ?></td>
            <td><span><?= $product->product_quantity ?></span>
                <button class="increase" value="<?= $product->id ?>">+</button>
                <button class="decrease" value="<?= $product->id ?>">-</button>
            </td>
            <td><?= $product->product_name ?></td>
            <td><?= $product->product_article ?></td>
            <td>
                <button class="hide" value="<?= $product->id ?>">Hide</button>
            </td>
        </tr>
    <?php endforeach; ?>

</table>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(".increase").click(function () {
        let quantity_selector = $(this)[0].parentNode.childNodes[0];
        let quantity_value = parseInt(quantity_selector.innerText);
        $(quantity_selector).empty();
        quantity_value++;
        $(quantity_selector).text(quantity_value);

        let id = $(this)[0].value;
        $.post("libs/db-update-products-quantity.php", {id: id, method: 'increase'});
    });

    $(".decrease").click(function () {
        let quantity_selector = $(this)[0].parentNode.childNodes[0];
        let quantity_value = parseInt(quantity_selector.innerText);
        $(quantity_selector).empty();
        quantity_value--;
        $(quantity_selector).text(quantity_value);

        let id = $(this)[0].value;
        $.post("libs/db-update-products-quantity.php", {id: id, method: 'decrease'});
    });

    $('.hide').click(function () {
        let id = $(this)[0].value;
        $.post("libs/db-hide-product.php", {id: id});

        $(this)[0].parentNode.parentNode.remove();
    });
</script>
</html>
