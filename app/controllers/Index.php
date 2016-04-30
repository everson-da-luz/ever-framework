<?php

namespace App\Controllers;

use Ever\Controller\Action,
    App\Models;

class Index extends Action
{
    public function index()
    {
        $this->render('index');
    }
}