<?php
// Dynamically define the project root (absolute path on the filesystem)
use JetBrains\PhpStorm\NoReturn;

define('PROJECT_ROOT', realpath(__DIR__ . '/../') . '/');

// Dynamically define the base URL (for web paths)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$scriptDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

define('BASE_URL', $protocol . $host . $scriptDir);

// Function to generate file paths
function app_path($path = ''): string
{
    return PROJECT_ROOT . ltrim($path, '/');
}

// Function to generate web URLs
function base_url($path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}

#[NoReturn]
function redirect(string $path, array $data = [], string $key = 'redirect_data', int $responseCode = 302): void
{
    // Ensure session is started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Clear any existing flash data
    clearFlashData();

    // Store data in session if provided
    if (!empty($data)) {
        $_SESSION[$key] = $data;
    }

    // Add a marker to indicate the data is for one-time use
    $_SESSION['_flash_keys'][] = $key;

    // Validate and perform the redirection
    if (!empty($path)) {
        header("Location: $path", true, $responseCode);
        exit;
    } else {
        throw new InvalidArgumentException('Redirect path cannot be empty.');
    }
}

function clearFlashData(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Check if there's any flash data stored in the session
    if (!empty($_SESSION['_flash_keys'])) {
        foreach ($_SESSION['_flash_keys'] as $key) {
            unset($_SESSION[$key]);
        }
        unset($_SESSION['_flash_keys']);
    }
}

