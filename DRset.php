<?php
$dnsip = $_POST['seturl'];
$sender = $_POST['sender'];
$astcmd = $_POST['astcmd'];
$test = $_POST['test'];
if ($test == "Test")
{
$dnshost = "testHOSTNAME.dns.org";
}
else
{
$dnshost = "HOSTNAME.dns.org";
}
$url = "https://dyndnsusername:dyndnspassword@members.dyndns.org/nic/update?hostname=$dnshost&myip=$dnsip&wildcard=NOCHG&mx=NOCHG&backmx=NOCHG";
 		// create a new cURL resource
		$curl = curl_init();
		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
		// grab URL and pass it to the browser
		curl_exec($curl);
		if (curl_errno($curl)) {
    		print curl_error($curl);
		} else {
    		curl_close($curl);
		}
		// close cURL resource, and free up system resources
		//curl_close($ch);
system("sudo /etc/init.d/asterisk $astcmd > /dev/null");
echo "System is now set to point to " .$dnsip.", Please wait." ;
print "<script>";
print " self.location='$sender.php';";
print "</script>";
?>
