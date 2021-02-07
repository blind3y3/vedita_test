<?php
require_once '../bootstrap.php';

$id = $_POST['id'];
$method = $_POST['method'];

if ($method == 'increase') {
    (new CProducts())->increaseProduct($id);
}

if ($method == 'decrease') {
    (new CProducts())->decreaseProduct($id);
}