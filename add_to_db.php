<?php
include 'config.php';
$dbconnect=mysql_connect('localhost', $mysql_user, $mysql_pass);
if(!$dbconnect){
	die('Could Not Connect:' .mysql_error());
}
mysql_select_db('twilio_app');

$new_number=$_POST['phone_number'];	
$number = ereg_replace("[^0-9]", "", $new_number );
$dupecheck="select $new_number from numbers where active='1'";
$result=mysql_query($dupecheck);
if (mysql_num_rows($result) == 0){
$query="INSERT INTO numbers (number, active) VALUES ('".mysql_real_escape_string($new_number)."','1')";
echo $query;
$query=mysql_query($query);
//redirect to thank you page
}
else {
	echo "fail"; 
	//redirect to already done page
}
?>