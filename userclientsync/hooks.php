<?php
function syncUser2Client($vars) {
    $module = "Sync User to Client";
    $oldData = $vars['olddata'];
    $userID = $vars['user_id'];
    if (
        $oldData['email'] === $vars['email'] &&
        $oldData['firstname'] === $vars['firstname'] &&
        $oldData['lastname'] === $vars['lastname']
    ) {
        logModuleCall($module, "Sync Ended", "No Changes to Sync", '', '', '');
        return;
    }
    logModuleCall($module, "Sync Started", "A change to the User has been detected, Starting Sync", $oldData['email'], '', '');
    $oldEmail = $oldData['email'];
    $apiResponse = localAPI('GetClients', ['action' => 'GetClients', 'search' => $oldEmail]);
    logModuleCall($module, "Client ID Search", ['action' => 'GetClients', 'search' => $oldEmail], $apiResponse, '', '');
    if ($apiResponse['result'] === 'success' && !empty($apiResponse['clients'])) {
        $clientID = $apiResponse['clients']['client'][0]['id'];
        $updateData = ['clientid' => $clientID, 'firstname' => $vars['firstname'], 'lastname' => $vars['lastname'], 'email' => $vars['email']];
        $updateResponse = localAPI('UpdateClient', $updateData);
        $logMessage = $updateResponse['result'] === 'success' ? "Client Update Success" : "Client Update Failed";
        logModuleCall($module, $logMessage, $updateData, $updateResponse, '', '');
        logActivity($logMessage, $userID);
    }
}
function syncUser2Client($vars) {
    $module = "Sync Client to User";
    $oldData = $vars['olddata'];
    if (
        $oldData['email'] === $vars['email'] &&
        $oldData['firstname'] === $vars['firstname'] &&
        $oldData['lastname'] === $vars['lastname']
    ) {
        logModuleCall($module, "Sync Ended", "No Changes to Sync", '', '', '');
        return;
    }
    logModuleCall($module, "Sync Started", "A change to the Client has been detected, Starting Sync", $oldData['email'], '', '');
    $oldEmail = $oldData['email'];
    $apiResponse = localAPI('GetUsers', ['action' => 'GetUsers', 'search' => $oldEmail]);
    logModuleCall($module, "User ID Search", ['action' => 'GetUsers', 'search' => $oldEmail], $apiResponse, '', '');
    if ($apiResponse['result'] === 'success' && !empty($apiResponse['users'])) {
        $userID = $apiResponse['users'][0]['id'];
        $updateData = ['userid' => $userID, 'firstname' => $vars['firstname'], 'lastname' => $vars['lastname'], 'email' => $vars['email']];
        $updateResponse = localAPI('UpdateUser', $updateData);
        $logMessage = $updateResponse['result'] === 'success' ? "User Update Success" : "User Update Failed";
        logModuleCall($module, $logMessage, $updateData, $updateResponse, '', '');
        logActivity($logMessage, $userID);
    }
}
add_hook('UserEdit', 1, 'syncUser2Client');
add_hook('ClientEdit', 1, 'syncClient2User');
?>
