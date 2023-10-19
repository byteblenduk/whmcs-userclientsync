<?php
function syncUser2Client($vars) {
    $module = "Sync User to Client";
    $oldData = $vars['olddata'];

    // Consolidated condition checks
    if (
        $oldData['email'] === $vars['email'] &&
        $oldData['firstname'] === $vars['firstname'] &&
        $oldData['lastname'] === $vars['lastname']
    ) {
        // Combined log call for "Sync Ended"
        logModuleCall($module, "Sync Ended", "No Changes to Sync", '', '', '');
        return;
    }

    // Combined log call for "Sync Started"
    logModuleCall($module, "Sync Started", "A change to the User has been detected, Starting Sync", $oldData['email'], '', '');

    $oldEmail = $oldData['email'];
    $apiResponse = localAPI('GetClients', ['action' => 'GetClients', 'search' => $oldEmail]);

    // Combined log call for "Client ID Search"
    logModuleCall($module, "Client ID Search", ['action' => 'GetClients', 'search' => $oldEmail], $apiResponse, '', '');

    if ($apiResponse['result'] === 'success' && !empty($apiResponse['clients'])) {
        $clientID = $apiResponse['clients']['client'][0]['id'];
        $updateData = ['clientid' => $clientID, 'firstname' => $vars['firstname'], 'lastname' => $vars['lastname'], 'email' => $vars['email']];
        $updateResponse = localAPI('UpdateClient', $updateData);

        $logMessage = $updateResponse['result'] === 'success' ? "Client Update Success" : "Client Update Failed";

        // Combined log call for either "Client Update Success" or "Client Update Failed"
        logModuleCall($module, $logMessage, $updateData, $updateResponse, '', '');
    }
}


function syncClient2User($vars)
{
    // Log the start of the hook
    logModuleCall(
        'User Sync Module', // Replace with your module name
        'ClientEdit Synchronization Start',
        $vars,
        '',
        '',
        ''
    );

    // Get the old client data
    $oldData = $vars['olddata'];

    // Compare email, firstname, and lastname for changes
    if (
        $oldData['email'] !== $vars['email'] ||
        $oldData['firstname'] !== $vars['firstname'] ||
        $oldData['lastname'] !== $vars['lastname']
    ) {
        // Changes detected, proceed with synchronization

        // Use the old email to search for user ID
        $oldEmail = $oldData['email'];
        $postData = array(
            'action' => 'GetUsers',
            'search' => $oldEmail,
        );

        // Log the search request
        logModuleCall(
            'User Sync Module',
            'ClientEdit Synchronization Search',
            $postData,
            '',
            '',
            ''
        );

        // Perform the local API call
        $apiResponse = localAPI('GetUsers', $postData);

        // Log the API response
        logModuleCall(
            'User Sync Module',
            'ClientEdit Synchronization API Response',
            $apiResponse,
            '',
            '',
            ''
        );

        // Check if the API call was successful
        if ($apiResponse['result'] === 'success' && !empty($apiResponse['users'])) {
            $userID = $apiResponse['users'][0]['id'];

            // Prepare data for updating the user
            $updateData = array(
                'user_id' => $userID, // The user ID obtained earlier
                'firstname' => $vars['firstname'],
                'lastname' => $vars['lastname'],
                'email' => $vars['email'],
            );

            // Log the user update request
            logModuleCall(
                'User Sync Module',
                'ClientEdit Synchronization User Update Request',
                $updateData,
                '',
                '',
                ''
            );

            // Perform the API call to update the user
            $updateResponse = localAPI('UpdateUser', $updateData);

            // Log the user update response
            logModuleCall(
                'User Sync Module',
                'ClientEdit Synchronization User Update Response',
                $updateResponse,
                '',
                '',
                ''
            );

            // Check if the update was successful
            if ($updateResponse['result'] === 'success') {
                // Log the successful synchronization
                logModuleCall(
                    'User Sync Module',
                    'ClientEdit Synchronization User Update Successful',
                    '',
                    '',
                    '',
                    ''
                );
            } else {
                // Handle the error and log it
                logModuleCall(
                    'User Sync Module',
                    'ClientEdit Synchronization User Update Failed',
                    $updateResponse,
                    '',
                    '',
                    ''
                );
            }
        }
    } else {
        // No changes detected, end the hook
        return;
    }
}

add_hook('UserEdit', 1, 'syncUser2Client');
add_hook('ClientEdit', 1, 'syncClient2User');
?>
