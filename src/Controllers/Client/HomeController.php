<?php

namespace Duchuy\Php2\Controllers\Client;

use Duchuy\Php2\Commons\Controller;
use Duchuy\Php2\Commons\Helper;
use Duchuy\Php2\Models\Product;

class HomeController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index()
    {

        $products = $this->product->all();
        // Helper::debug($products);
        $this->renderViewClient('home', [
            'products' => $products
        ]);
    }
}
