<?php

require_once __DIR__ . '/Controller.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $this->loadView('user/index');
    }



}