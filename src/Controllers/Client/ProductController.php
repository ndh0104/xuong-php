<?php

namespace Duchuy\Php2\Controllers\Client;

use Duchuy\Php2\Commons\Controller;
use Duchuy\Php2\Models\Product;

class ProductController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function products()
    {
        $products = $this->product->all();
        $this->renderViewClient('products', [
            'products' => $products
        ]);
    }

    public function detail($id)
    {
        $product = $this->product->findByID($id);

        $this->renderViewClient('product-detail', [
            'product' => $product
        ]);
    }
}
