<?php

namespace App\Controllers;

use Ever\Controller\Action;

class Error extends Action
{
    public function index()
    {
        $error = $this->getParam('error');
        
        $this->view->error = $error;

        $this->render('index');
    }
}