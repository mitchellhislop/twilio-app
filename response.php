<?php
include 'config.php';
$dbconnect=mysql_connect('localhost', $mysql_user, $mysql_pass);
if(!$dbconnect){
	die('Could Not Connect:' .mysql_error());
}
mysql_select_db('twilio_app');
$from=$_REQUEST['From'];
$case = $_REQUEST['Body'];
//$case = "EVENT";
$case=strtoupper($case);

if ($case == "ADD")
{	$new_number=$_REQUEST['From'];
	$number = ereg_replace("[^0-9]", "", $new_number );
	
	$dupecheck="SELECT * FROM numbers WHERE number='".mysql_real_escape_string($number)."' AND active='1'";

	$result=mysql_query($dupecheck);
	$num_rows=mysql_num_rows($result);
	if ($num_rows == 0)
	{
	$query="INSERT INTO numbers (number, active) VALUES ('".mysql_real_escape_string($number)."','1')";	
	$results=mysql_query($query);
	$message="You have been added. Thank you for supporting Project 515";
	}
	else 
	{ 
	$message="You are already subscribed. Thank you for supporting Project 515";
	}
	
}
else if ($case == "STOP")
{	$new_number=$_REQUEST['From'];
	$number = ereg_replace("[^0-9]", "", $new_number );
	
	$query = "DELETE FROM numbers WHERE number='".mysql_real_escape_string($number)."'";
	$result=mysql_query($query);
	$message = "You have been unsubscribed. Txt Add to subscribe again";
	
}
else if($case=="NEWS"){
	mysql_select_db('fcw_wp_00');
	$query="SELECT max(id) as id FROM wp_posts WHERE post_type='post'"; //WHERE type="blast this shit yo"
	$result=mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$row=$row['id'];
	$query="SELECT post_title, guid FROM wp_posts WHERE id=$row";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	$link=$row['guid'];
	$title=$row['post_title'];
	//bit.ly api goes here
	$login="project515";
	$appkey="R_315ad1d93fff05076a8f9d7e053c6257";
	$format="xml";
	$url=$link;
	$bitly = 'http://api.bit.ly/v3/shorten?longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
	//get the url
	//could also use cURL here
	$response = file_get_contents($bitly);
	//parse depending on desired format
	$xml = simplexml_load_string($response);
	$link = $xml->data->url;
	$message = "The most recent news item is: $title $link";
}
else if ($case=="EVENT" OR $case=="EVENTS")
{
	//pull most recent event
	mysql_select_db('fcw_wp_00');
	$query="SELECT * from `wp_em_events` where `event_start_date` > NOW() ORDER BY `event_start_date` LIMIT 1"; 
	$result=mysql_query($query);
	$result=mysql_fetch_assoc($result);
	$event = $result['event_name'];
	$date=$result['event_start_date'];
	$loc_id=$result['location_id'];
	$query2="SELECT location_name FROM wp_em_locations WHERE location_id=$loc_id ";
	$result2=mysql_query($query2);
	$result2=mysql_fetch_assoc($result2);
	$location=$result2['location_name'];
	$message="Next Event: $event on $date at $location.";
	
}
else {
	$message="I didn't understand that. Try Add, News, Event, or Stop";
}
	header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
	<Response>
	    <Sms><?php echo $message;?></Sms>
	</Response>
