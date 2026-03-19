<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Shared Hosting Support (e.g. Hostinger)
|--------------------------------------------------------------------------
|
| On shared hosting the web root is typically "public_html". To deploy
| Laravel you can place all application files (except the "public"
| directory) one level above "public_html" and then copy or symlink the
| contents of "public" into "public_html".
|
| When this index.php lives inside "public_html" the default relative
| path "../" no longer points at the Laravel root. To handle this,
| create a file named ".app_path" in the same directory as this file
| containing the absolute path to the Laravel root, for example:
|
|   /home/username/as-minterp
|
| If that file is not present the standard layout (this file is inside
| the "public" subdirectory of the Laravel root) is assumed.
|
*/
$appBasePath = __DIR__.'/../';

if (file_exists(__DIR__.'/.app_path')) {
    $candidate = rtrim(file_get_contents(__DIR__.'/.app_path'), " \t\n\r\0\x0B/").'/';
    // Validate that the resolved path is a real Laravel root before trusting it.
    if (is_dir($candidate) && file_exists($candidate.'bootstrap/app.php')) {
        $appBasePath = $candidate;
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $appBasePath.'storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $appBasePath.'vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once $appBasePath.'bootstrap/app.php')
    ->handleRequest(Request::capture());
