<?
$conn = new mysqli('192.168.66.6','root','medadmin','eoffice');
if($conn->connect_error) { alert("can't connect db"); } 
date_default_timezone_set("Asia/Bangkok");

?>