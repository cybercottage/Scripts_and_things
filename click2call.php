<head>
<title>Click-to-Call</title>
</head>
<body>
<?
#Click-To-Call script brought to you by VoipJots.com modified for logging and security by cyber-cottage.co.uk
#------------------------------------------------------------------------------------------
#edit the below variable values to reflect your system/information
#------------------------------------------------------------------------------------------
#specify the name/ip address of your asterisk box
#if your are hosting this page on your asterisk box, then you can use
#127.0.0.1 as the host IP.  Otherwise, you will need to edit the following
#line in manager.conf, under the Admin user section:
#permit=127.0.0.1/255.255.255.0
#change to:
#permit=127.0.0.1/255.255.255.0,xxx.xxx.xxx.xxx ;(the ip address of the server this page is running on)
$strHost = "127.0.0.1";
#specify the username you want to login with (these users are defined in /etc/asterisk/manager.conf)
#this user is the default AAH AMP user; you shouldn't need to change, if you're using AAH.
$strUser = "USERNAME";
#specify the password for the above user
$strSecret = "SECRET";
$PartyId = $_GET['page'];
#echo $PartyId;
$pieces = explode("/", $PartyId);
//echo $pieces[0];
//echo $pieces[1];
//echo $pieces[2];
//echo $pieces[3];
//echo $pieces[4];
//echo $pieces[5];
//echo $pieces[6];
//echo $pieces[7];
$PartyID = explode("?", $pieces[4]);
#specify the channel (extension) you want to receive the call requests with
#e.g. SIP/XXXX, IAX2/XXXX, ZAP/XXXX, etc
$strChannel .= $_GET['EXTEN'];
$exts = explode("/", $strChannel);
$tec=$exts[0];
$exten=$exts[1];
$localchan="Local/$exten@CONTEXT/n";

echo $localchan;

#specify the context to make the outgoing call from.  By default, AAH uses from-internal

#Using from-internal will make you outgoing dialing rules apply

$strContext = "CONTEXT"; 

#Sets callerID(num)

$strCallid = $_GET['number'];

#if you sue a dialout prefix set it here

$strPref="9";

#specify the amount of time you want to try calling the specified channel before hangin up

$strWaitTime = "20"; 

#specify the priority you wish to place on making this call

$strPriority = "1";

#specify the maximum amount of retries

$strMaxRetry = "2";

#-------------------added for logging and security

#Get the date

$today = date("F j, Y, g:i a");

$mins = date("i");

#defines logfile location

$log_file = "/var/www/html/logfile.htm";

#Sets the password sent from greasemonkey

$strPWD .= $_GET['hgiy'];

#get the phone number from the posted form

#echo $_GET['number'];

#echo "before 9";

$strExten .= $_GET['number'];

#echo $strExten;

#echo "after 9";

#opens the log file and writes time extension and number to it

$data = fopen($log_file, "a+");

fwrite($data,"New call: $today $strChannel $strExten\n");

fclose($data);

#--------------------------------------------------------------------------------------------

#Shouldn't need to edit anything below this point to make this script work

#--------------------------------------------------------------------------------------------

#echo   $strExten;

$strExten = preg_replace('/\s+/', '', $strExten);

#echo   $strExten;

#$strExten = preg_replace('[^0-9]', '', $strExten);

$strExten = preg_replace('/\(/',  '', $strExten);

$strExten = preg_replace('/\)/',  '', $strExten);

$strPref .= $strExten;

echo    $strPref;

$strExten = $strPref;

#echo   $strExten;

#specify the caller id for the call

$strCallerId = "$strCallid <$strCallid>";

$length = strlen($strExten);

//uncomment this if want to make sure shorter numbers arnt dialed

#if ($length > 9)

#checks to see if the password is as sent over. This is to be updated

if ($strPWD = 'YOURPASSWORDPASSED FROM TAMPERMONKEY SCRIPT')

{

$oSocket = fsockopen($strHost, 5038, $errnum, $errdesc) or die("Connection to host failed");

fputs($oSocket, "Action: login\r\n");

fputs($oSocket, "Events: off\r\n");

fputs($oSocket, "Username: $strUser\r\n");

fputs($oSocket, "Secret: $strSecret\r\n\r\n");

fputs($oSocket, "Action: originate\r\n");

fputs($oSocket, "Channel: $localchan\r\n");

fputs($oSocket, "WaitTime: $strWaitTime\r\n");

fputs($oSocket, "CallerId: $strCallerId\r\n");

fputs($oSocket, "Exten: $strExten\r\n");

fputs($oSocket, "Variable: caller=$strChannel|capsual=yes|\r\n");

fputs($oSocket, "Context: $strContext\r\n");

fputs($oSocket, "Priority: $strPriority\r\n\r\n");

fputs($oSocket, "Action: Logoff\r\n\r\n");

Sleep(2);

fclose($oSocket);

?>

Done

<?

}

else

{

?>

<?

}

?>

<?php

//$PartyID = '35406304';
$Token = 'YOUR CAPSULA TOKEN ID';
$number = $strCallid;
$datetime = $today;

echo $strCallid;

$myxml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n
<historyItem>\n
  <note>Call made to $number at $datetime. Please update this note if required</note>\n
</historyItem>";

// The URL to connect with (note the /api/ that's needed and note it's person rather than party)
// SEE: http://capsulecrm.com/help/page/api_gettingstarted/

if($pieces[3] == "case") // or if(call())
{
$capsulepage =  "https://YOURNAME.capsulecrm.com/api/kase/$PartyID[0]/history";
}
else if($pieces[3] == "opportunity")
{
// do something here
$capsulepage =  "https://YOURNAME.capsulecrm.com/api/opportunity/$PartyID[0]/history";
}
else
{
$capsulepage =  "https://YOURNAME.capsulecrm.com/api/party/$PartyID[0]/history";
}

//$capsulepage =  "https://YOURNAME.capsulecrm.com/api/party/$PartyID[0]/history";

echo $capsulepage;

// Initialise the session and return a cURL handle to pass to other cURL functions.
$ch = curl_init($capsulepage);
// set appropriate options NB these are the minimum necessary to achieve a post with a useful response
// ...can and should add more in a real application such as
// timeout CURLOPT_CONNECTTIMEOUT
// and useragent CURLOPT_USERAGENT
// replace 1234567890123456789 with your own API token from your user preferences page
$options = array(CURLOPT_USERPWD => "$Token:x",
            CURLOPT_HTTPHEADER => array('Content-Type: application/xml'),
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $myxml
                );
curl_setopt_array($ch, $options);

// Do the POST and collect the response for future printing etc then close the session
$response = curl_exec($ch);
$responseInfo = curl_getinfo($ch);
curl_close($ch);

?>

</body>

</html>
