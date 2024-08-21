<?php

/**
 * Selsela Template info
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));


// Register the auto-loader
require __DIR__.'/vendor/autoload.php';


// Load the app
$app = require_once __DIR__.'/bootstrap/app.php';

// Run the app
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
