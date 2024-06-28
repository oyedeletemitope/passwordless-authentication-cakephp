<?php

namespace App\Controller;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        // This is the default action that will be called
        // when the user is redirected to the dashboard
        $this->set('title', 'Dashboard');
    }
}
