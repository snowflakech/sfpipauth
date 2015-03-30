# IP Authentication Service

## Introduction

### What does it do?

The IP Authentication Service is originally based on cc_iplogin_fe and cc_ipauth which are perfectly working extensions except for one drawback: Performance. Since the service is executed on every page hit, performance is critical here. Therefore, 'sfpipauth' has all the IPs stored in one separate table.
The Extension provides different login-modes that allow you to automatically log in users as well as to completely close your website for users with no matching IP with all possible combinations (see the Administration section for details).
To additionally improve performance, it's possible to prevent the service from being executed except the visitor starts a login-process.

### Requirements/Compatibility

The Extension currently is tested on TYPO3 6.2. However, if you encounter any problems in combination with any version, pleas drop a note.
Furthermore, it might not be wise to use this Extension in combination with cc_ipauth. It doesn't really conflict but isn't tested nor recommended either.


## Users manual

If you want to add, edit or remove a users, go to the page, where you have stored the according IP-Authentication configurations.
(Note: currently, it doesn't depend on which page the you have stored the record, sfpipauth searches the whole site anyways.)

Add a new record of type “IP-Authentication configuration” and set the configuration:
* A name so you can identify the record
* the IP-Range (You can use wildcards and subnet-masks)
* Select a user
* Choose a Login Mode

For a more detailed description to these settings, see the  “Administration” section.

## Administration

Load and install the Extension from the TYPO3 Extension Repository (TER) or from github directly.

In the Extension-Config, you can set by the option “fetchUserIfNoSession” whether the service is executed on every page hit or only if the user starts a session (e.g. by submitting a login-form).
Note: Disabling this option might increase performance a bit but auto login won't probably work as expected. Also, this could conflict with other extensions/functions. So, if you're not sure about this, set the option to true.

Once installed, you can use the List Module to create a new data record of type “IP-Authentication configuration”. It doesn't depend on which page you store your records, probably you might want them on the folder where the users are stored...

Select a user from the list that should be authenticated when the IP matches, then set the IP address of the Network, from where those user access the website.  You can set a comma-separated list and use wildcards as well as subnet-masks to specify a range of IPs:
1.1.*.* and 1.1.10.10/16 are both the definitions for the range 1.1.0.0 to 1.1.255.255.

Finally, select the mode, in which the authentication should run.
There are the following options available:

 * Autologin, normal login if no match (recommended)
  * If the IP address of the visitor matches the IP of your IP-Authentication configuration, the user is logged in automatically.
  * If the IP address doesn't match, the website visitor is still allowed to log in with username and password.
 * Autologin, disable login if no match
  * If the IP address of the visitor matches the IP of your IP-Authentication configuration, the user is logged in automatically.
  * If the IP address doesn't match, the user is not allowed to log in at all.
 * Enable normal login, disable any login if no match (attention: dismisses all other configurations)
  * If the IP address of the visitor matches the IP of your IP-Authentication configuration, the user is allowed to log in with his username and password.
  * If the IP address doesn't match, the website visitor is not allowed to log in.
  
  
## Configuration

### fetchUserIfNoSession

You can set by this option whether the service is executed on every page hit or only if the user starts a session. See the Administration section for details.