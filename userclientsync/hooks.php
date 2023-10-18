<?php
function syncUser2Client($vars)
{
    // Log the start of the hook
    logModuleCall(
        'Client Sync Module', // Replace with your module name
        'UserEdit Synchronization Start',
        $vars,
        '',
        '',
        ''
    );

    // Get the old user data
    $oldData = $vars['olddata'];

    // Compare email, firstname, and lastname for changes
    if (
        $oldData['email'] !== $vars['email'] ||
        $oldData['firstname'] !== $vars['firstname'] ||
        $oldData['lastname'] !== $vars['lastname']
    ) {
        // Changes detected, proceed with synchronization

        // Use the old email to search for client ID
        $oldEmail = $oldData['email'];
        $postData = array(
            'action' => 'GetClients',
            'search' => $oldEmail,
        );

        // Log the search request
        logModuleCall(
            'Client Sync Module',
            'UserEdit Synchronization Search',
            $postData,
            '',
            '',
            ''
        );

        // Perform the local API call
        $apiResponse = localAPI('GetClients', $postData);

        // Log the API response
        logModuleCall(
            'Client Sync Module',
            'UserEdit Synchronization API Response',
            $apiResponse,
            '',
            '',
            ''
        );

        // Check if the API call was successful
        if ($apiResponse['result'] === 'success' && !empty($apiResponse['clients'])) {
            $clientID = $apiResponse['clients']['client'][0]['id'];

            // Prepare data for updating the client
            $updateData = array(
                'clientid' => $clientID, // The client ID obtained earlier
                'firstname' => $vars['firstname'],
                'lastname' => $vars['lastname'],
                'email' => $vars['email'],
            );

            // Log the client update request
            logModuleCall(
                'Client Sync Module',
                'UserEdit Synchronization Client Update Request',
                $updateData,
                '',
                '',
                ''
            );

            // Perform the API call to update the client
            $updateResponse = localAPI('UpdateClient', $updateData);

            // Log the client update response
            logModuleCall(
                'Client Sync Module',
                'UserEdit Synchronization Client Update Response',
                $updateResponse,
                '',
                '',
                ''
            );

            // Check if the update was successful
            if ($updateResponse['result'] === 'success') {
                // Log the successful synchronization
                logModuleCall(
                    'Client Sync Module',
                    'UserEdit Synchronization Client Update Successful',
                    '',
                    '',
                    '',
                    ''
                );
            } else {
                // Handle the error and log it
                logModuleCall(
                    'Client Sync Module',
                    'UserEdit Synchronization Client Update Failed',
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
