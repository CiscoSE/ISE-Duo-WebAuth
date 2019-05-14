<?php

#Change the values of the variables below

$radserver = '<ip-of-ISE>';
$radport = 1812;
$radport2 = 1813;
$sharedsecret = '<RADIUS shared secret>';

//Create RADIUS Request
$ip = $_SERVER['REMOTE_ADDR'];
$file=fopen("data.txt","r");
$username=trim(fgets($file));
$class=trim(fgets($file));
$sess=trim(fgets($file));
$asess=trim(fgets($file));
fclose($file);

// Send Accounting Stop

$res2 = radius_acct_open();
radius_add_server($res2, $radserver, $radport2, $sharedsecret, 5, 2);
radius_create_request($res2, RADIUS_ACCOUNTING_REQUEST);
radius_put_attr($res2, RADIUS_USER_NAME, $username);
radius_put_string($res2, RADIUS_CALLING_STATION_ID, isset($ip) ? $ip : '192.168.1.101');
radius_put_int($res2, RADIUS_SERVICE_TYPE, 5);
radius_put_addr($res2, RADIUS_FRAMED_IP_ADDRESS, isset($ip) ? $ip : '192.168.1.101');
radius_put_addr($res2, RADIUS_NAS_IP_ADDRESS, '192.168.1.6');
radius_put_int($res2, RADIUS_NAS_PORT_TYPE, 0);
radius_put_int($res2, RADIUS_ACCT_STATUS_TYPE, RADIUS_STOP);
radius_put_string($res2, RADIUS_ACCT_SESSION_ID, $asess);
radius_put_string($res2, RADIUS_CLASS, $class);
radius_put_vendor_string($res2, 9, 1, $sess);
radius_put_int($res2, RADIUS_ACCT_TERMINATE_CAUSE, 2);
radius_put_int($res2, 41, 2);

$req2 = radius_send_request($res2);
switch($req2) {

case RADIUS_ACCOUNTING_RESPONSE:
    //echo "Radius Accounting response \n";
    break;

default:
    //echo "Unexpected return value:$req\n";

}
radius_close($res2);
echo "User - ".$username." - Logged Out" ;
?>
