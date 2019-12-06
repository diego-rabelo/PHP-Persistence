<?php

require 'vendor/autoload.php';

use Persistence\TableDataGateway\{Product as ProductGateway};
use Persistence\ActiveRecord\{Product as ProductRecord};

$pdo = new PDO("mysql:host=localhost;dbname=store","root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

ProductGateway::setConnection($pdo);

$product = (new ProductGateway())->find(1);

echo $product;

ProductRecord::setConnection($pdo);

$product2 = new ProductRecord();

$product2->description = 'Car';
$product2->cost_price =  20000;
$product2->sale_price = 40000;
$product2->stock = 40;
$product2->bar_code = 'Car001';

var_dump($product2->save());
var_dump($product2->all());

