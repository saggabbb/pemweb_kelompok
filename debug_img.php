<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$products = \App\Models\Product::whereNotNull('image')->get(['id', 'product_name', 'image']);
echo json_encode($products);
