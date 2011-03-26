<?php

include 'twilio-php/twilio.php';
include 'config.php';

$client = new TwilioRestClient($AccountSid, $AuthToken);
//this will get pulled out of the database of people who have signed up for SMS
$testers=array(
	"6124184992" => "Mitchell",
	"6127203122" => "Justin",
	"9524846686" => "Lauren"
	);
	
	
//build this for new posts, tweets, whatever we want	
foreach ($testers as $number => $name){
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
	            "POST", array(
	            "To" => $number,
	            "From" => "612-360-2696",
	            "Body" => "Hello $name, you look nice today"
	        ));

		if($response->IsError)
            echo "Error: {$response->ErrorMessage}";
        else
            echo "Sent message to $name";
    }
 
?>