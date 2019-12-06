<?php

require 'vendor/autoload.php';

use Persistence\TableDataGateway\{Product};

$pdo = new PDO("mysql:host=localhost;dbname=store","root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

Product::setConnection($pdo);

$product = (new product())->find(1);

echo $product;
