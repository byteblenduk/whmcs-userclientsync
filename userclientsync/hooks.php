<?php
add_hook('userEdit', 1, function($vars) {
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

        // Perform the local API call
        $apiResponse = localAPI('GetClients', $postData);

        // Check if the API call was successful
        if ($apiResponse['result'] === 'success' && !empty($apiResponse['clients'])) {
            $clientID = $apiResponse['clients'][0]['id'];

            // Prepare data for updating the client
            $updateData = array(
                'action' => 'UpdateClient',
                'clientid' => $clientID, // The client ID obtained earlier
                'firstname' => $vars['firstname'],
                'lastname' => $vars['lastname'],
                'email' => $vars['email'],
            );

            // Perform the API call to update the client
            $updateResponse = localAPI('UpdateClient', $updateData);

            // Check if the update was successful
            if ($updateResponse['result'] === 'success') {
                // Log the successful synchronization
                logModuleCall(
                    'Client Sync Module', // Replace with your module name
                    'UserEdit Synchronization',
                    $vars,
                    'Client Update Successful',
                    '',
                    ''
                );
            } else {
                // Handle the error and log it
                logModuleCall(
                    'Client Sync Module', // Replace with your module name
                    'UserEdit Synchronization',
                    $vars,
                    'Client Update Failed',
                    $updateResponse,
                    ''
                );
            }
        }
    } else {
        // No changes detected, end the hook
        return;
    }
});

add_hook('clientEdit', 1, function($vars) {
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

        // Perform the local API call
        $apiResponse = localAPI('GetUsers', $postData);

        // Check if the API call was successful
        if ($apiResponse['result'] === 'success' && !empty($apiResponse['users'])) {
            $userID = $apiResponse['users'][0]['id'];

            // Prepare data for updating the user
            $updateData = array(
                'action' => 'updateuser',
                'userid' => $userID, // The user ID obtained earlier
                'firstname' => $vars['firstname'],
                'lastname' => $vars['lastname'],
                'email' => $vars['email'],
            );

            // Perform the API call to update the user
            $updateResponse = localAPI('updateuser', $updateData);

            // Check if the update was successful
            if ($updateResponse['result'] === 'success') {
                // Log the successful synchronization
                logModuleCall(
                    'User Sync Module', // Replace with your module name
                    'ClientEdit Synchronization',
                    $vars,
                    'User Update Successful',
                    '',
                    ''
                );
            } else {
                // Handle the error and log it
                logModuleCall(
                    'User Sync Module', // Replace with your module name
                    'ClientEdit Synchronization',
                    $vars,
                    'User Update Failed',
                    $updateResponse,
                    ''
                );
            }
        }
    } else {
        // No changes detected, end the hook
        return;
    }
});
?>
