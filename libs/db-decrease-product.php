<?php
require_once '../bootstrap.php';
$id = $_POST['id'];
(new CProducts())->decreaseProduct($id);