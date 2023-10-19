# User/Client Sync WHMCS Module
WHMCS Syncing tool for 2 way synchronisation between client and user details.

## Overview

The User/Client Sync module is designed to automate a two-way synchronization of client and user details within WHMCS. This synchronization ensures that changes made to client information, including first name, last name, and email, are reflected in the user details and vice versa.

## Installation

1. Download the User/Client Sync module from the source.
2. Upload the module to your WHMCS installation in the modules/addons directory.
3. Log in to your WHMCS admin area.
4. Navigate to Setup > Addon Modules.
5. Find "User/Client Sync" in the list of available addon modules and click the "Activate" button.
6. Click on the "Configure" button to set up the module's settings.

## Usage

The User/Client Sync module operates automatically in the background. It hooks into WHMCS events to detect changes to client information, such as first name, last name, and email. When a change is detected, the module initiates synchronization with the corresponding user data.

## Version Information

- Module Name: User/Client Sync
- Description: This module provides automatic two-way syncing between client and user details.
- Author: Twizel
- Language: English
- Version: 1.1

## Support

For questions, issues, or support related to the User/Client Sync module, please contact the author, Twizel, via the https://github.com/TwistedPretzel/whmcs-userclientsync/.

## License

This module is released under the GNU GENERAL PUBLIC license. You can find the full license details in the provided license file.

## Changelog

- **1.2** - Improved logging & reduced code while maintaining functionality
- **1.1** - Updated and fixed errors
- **1.0** - Initial release

## Credits

The User/Client Sync module was created by Twizel.

