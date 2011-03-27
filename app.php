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
$query="select last_checked from settings";
$checktime=mysql_query($query);
$checktime=mysql_fetch_assoc($checktime);
$checktime=time($checktime['last_checked']);

//build this for new posts, tweets, whatever we want	
mysql_select_db('fcw_wp_00');
$query="select max(post_date) as latest_post from wp_posts"; //WHERE type="blast this shit yo"
$result=mysql_query($query);
$row=mysql_fetch_assoc($result);
$latestposttime =time($row['latest_post']);
$sendtime=time();

if ($lastposttime < $checktime)
{
	
foreach ($txt_list as $number){
	$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
	            "POST", array(
	            "To" => $number,
	            "From" => "612-360-2696",
	            "Body" => "give mitch a thumbs up if this works. "
	        ));
		if($response->IsError)
            echo "Error: {$response->ErrorMessage}";
        else
            echo "Message Sent";
    }
  }
?>