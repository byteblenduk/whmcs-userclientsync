<?php
use WHMCS\Database\Capsule;
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
function userclientsync_config()
{
    return [
        // Display name for your module
        'name' => 'User/Client Sync',
        // Description displayed within the admin interface
        'description' => 'Automatic 2 way syncing between client and user details',
        // Module author name
        'author' => 'ByteBlend',
        // Default language
        'language' => 'english',
        // Version number
        'version' => '1.2',
    ];
}
function userclientsync_activate() {
    $minRequiredVersion = '8.1.0';
    $pdo = Capsule::connection()->getPdo();
    $query = "SELECT value FROM tblconfiguration WHERE setting = 'Version'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result) {
        $whmcsVersion = $result['value'];
        if (version_compare($whmcsVersion, $minRequiredVersion, '<')) {
            return array(
                'status' => 'error',
                'description' => 'Your WHMCS version is below the minimum required version for this module. Please upgrade WHMCS to use this module.'
            );
        }
        return array(
            'status' => 'success',
            'description' => 'Module activated successfully.'
        );
    } else {
        return array(
            'status' => 'error',
            'description' => 'Unable to retrieve the WHMCS version. Please check your WHMCS installation.'
        );
    }
}
?>
