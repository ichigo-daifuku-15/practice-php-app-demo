<?php
namespace App\Controller;

use App\Controller\AppController;

class HelloController extends AppController
{
    public function index()
    {
        $message = 'こんにちは、動的な世界へようこそ！';
        $this->set(compact('message'));
    }
}
