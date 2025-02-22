<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db_connection.php';
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/routes/web.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


