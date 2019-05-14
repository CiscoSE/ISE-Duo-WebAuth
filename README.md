# ISE-Duo-WebAuth
Sample code to create a Web based authentication portal that works with ISE and Duo both for privileged network access control
By Vivek Santuka

This script can be used to replace the Cisco ASA Cut-through proxy or Cisco IOS auth-proxy functionalities, used to control access to privileged networks. This script functions by:

1. Accepting authentication on a Web form
2. Converting the authentication into a RADIUS request to ISE
3. On receiving the authentication response, redirecting the user to Duo for 2FA
4. On receiving Duo success, sending a second authentication request to ISE with set AV pair to trigger a SGT assignment

ISE is configured to assign a SGT and distribute it to network devices such as ASA using SXP. The SGT-IP mapping acts as a "key" to open access to privileged network protected by a SGACL.

This setup replaces cumbersome auth-proxy/cut-through proxy configuration that is required on multiple devices, improves user experience, allows access through multiple devices with a single authentication and finally adds 2FA for privileged access control.

Suggestions to improve before implementing in production:

1. Use a real database instead of a text file to store session infomation
2. Implement a cron job that sends RADIUS Accounting Stop packets for active sessions every few hours

To Use, place all the files in a directory acessible by a webserver and edit index.php and stop.php to add correct values for ISE and Duo integration. Apache and PHP 7.2.8 were used to test.


Please refer to the [LICENSE](./LICENSE) file for terms of use.
