<?php

namespace Duchuy\Php2\Controllers\Client;

use Duchuy\Php2\Commons\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $name = 'NDH0104';

        $this->renderViewClient('home', [
            'name' => $name
        ]);
    }
}
