<?php

namespace Duchuy\Php2\Controllers\Admin;

use Duchuy\Php2\Commons\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $this->renderViewAdmin(__FUNCTION__);
    }
}
