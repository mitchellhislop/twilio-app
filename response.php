<?php
$from=$_REQUEST['From'];
$case = $_REQUEST['Body'];

if ($case == "add")
{
	$message="You have been added. Welcome";
}
else if ($case == "stop")
{
	$message = "Ok. I will stop";
}
else {
	$message = "I didnt understand. Text add to add, or stop to stop";
}
 header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

	<Response>
	    <Sms><?php echo $message ;?></Sms>
	</Response>