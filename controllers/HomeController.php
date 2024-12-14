<?php

require_once __DIR__ . '/Controller.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $this->loadView('user/home-page');
    }

    public function about(): void
    {
        $this->loadView('user/about-page');
    }

    public function contact(): void
    {
        $this->loadView('user/contact-page');
    }

}