<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function userclientsync_config()
{
    return [
        // Display name for your module
        'name' => 'User/Client Sync',
        // Description displayed within the admin interface
        'description' => 'This module provides automaatic 2 way syncing between client and user details',
        // Module author name
        'author' => 'Twizel',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.1',
    ];
}
?>
