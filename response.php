<?php
include 'config.php';
$dbconnect=mysql_connect('localhost', $mysql_user, $mysql_pass);
if(!$dbconnect){
	die('Could Not Connect:' .mysql_error());
}
mysql_select_db('twilio_app');
$from=$_REQUEST['From'];
$case = $_REQUEST['Body'];
$case=strtoupper($case);

if ($case == "ADD")
{	$new_number=$_REQUEST['From'];
	$number = ereg_replace("[^0-9]", "", $new_number );
	$dupecheck="select $number from numbers where active='1'";
	$result=mysql_query($dupecheck);
	if (!mysql_num_rows($result)>0)
	{
	$query="INSERT INTO numbers (number, active) VALUES ('".mysql_real_escape_string($number)."','1')";
	echo $query;
	$query=mysql_query($query);
	$message="You have been added. Thank you for supporting Project 515";
	}
	else 
	{
		$message="You are already subscribed. Thank you for supporting Project 515"
	}
	
}
else if ($case == "STOP")
{	$new_number=$_REQUEST['From'];
	$number = ereg_replace("[^0-9]", "", $new_number );
	$message = "You have been unsubscribed. Txt Add to subscribe again";
	$query = "UPDATE twilio_app SET active='0' WHERE number='".mysql_real_escape_string($number)."'";
	//switch active to 0
}
else if($case=="NEWS"){
	//pull recent news headline
	$message = "The most recent news item is: TITLE LINK";
}
else if ($case=="EVENT" OR $case=="EVENTS")
{
	//pull most recent event
	$message="The next event is TITLE on DATE at LOCATION";
}
else {
	$message="I didn't understand that. Try Add, News, Event, or Stop"
}
 header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>

	<Response>
	    <Sms><?php echo $case ;?></Sms>
	</Response>