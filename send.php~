<?php
include 'twilio-php/twilio.php';
include 'config.php';
$client = new TwilioRestClient($AccountSid, $AuthToken);
//connect to DB
$dbconnect=mysql_connect('localhost', $mysql_user, $mysql_pass);
if(!$dbconnect){
	die('Could Not Connect:' .mysql_error());
}
mysql_select_db('twilio_app');

//this will get pulled out of the database of people who have signed up for SMS
$query="select number as number from numbers where active='1'";
$numbers=mysql_query($query);
$txt_list=array();
while ($row=mysql_fetch_assoc($numbers))
{
	$txt_list[]=$row['number'];
}

$message=$_POST['sms_input'];

foreach ($txt_list as $number){
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
	            "POST", array(
	            "To" => $number,
	            "From" => "612-360-2696",
	            "Body" => $message
	        ));
		if($response->IsError)
            echo "Error: {$response->ErrorMessage}";
        else
            echo "Message Sent";
    }
  }
?>