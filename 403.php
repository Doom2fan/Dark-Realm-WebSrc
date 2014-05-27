<?php
	$file = 'Restricted/403ForbiddenLog.txt'; // location of the text file that will log all the ip adresses
	$ipadress = $_SERVER['REMOTE_ADDR']; // ip address of the user
	$date = date('d/F/Y h:i:s'); // date of the visit that will be formated this way: 29/May/2011 12:20:03
	$webpage = $_SERVER['SCRIPT_NAME']; // name of the page that was accessed
	$browser = $_SERVER['HTTP_USER_AGENT']; // user's browser information
	$fp = fopen($file, 'a'); // Opening the text file and writing the user's data
	fwrite($fp, $ipadress.' - ['.$date.'] '.$webpage.' '.$browser."\r\n");
	fclose($fp);
?>

<html>
	<head>
		<title>you shouldn't have done that</title>
        <link rel="stylesheet" href="http://darkrealm.altervista.org/content/global.css" />
		<style type="text/css">
			html, body {
			background: url(images/youshouldnthavedonethat.jpg);
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			}
		</style> 
	</head>
	<body>
		<embed src="./audio/youshouldnthavedonethat.mp3" hidden="true" autostart="true"></embed>
	</body>
</html>