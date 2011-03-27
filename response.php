<?php
$from=$_REQUEST['From'];
$case = $_REQUEST['Body'];
$case=strtoupper($case);
if ($case == "ADD")
{
	$message="You have been added. Thank you for supporting Project 515";
	//add to the db
}
else if ($case == "STOP")
{
	$message = "You have been unsubscribed. Txt Add to subscribe again";
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
	    <Sms><?php echo $message ;?></Sms>
	</Response>