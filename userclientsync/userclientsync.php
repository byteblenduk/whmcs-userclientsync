<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
function userclientsync_config()
{
    return [
        'name' => 'User/Client Sync',
        'description' => 'Automatic 2 way syncing between client and user details',
        'author' => 'ByteBlend',
        'language' => 'english',
        'version' => '1.2',
    ];
}
?>
