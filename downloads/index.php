<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>marrub's place</title>
	<link rel="stylesheet" type="text/css" href="../content/global.css">
</head>

<body>
<div id="wrapper">
	<!-- Top (navigation) bar -->
	<div id="topbar">
		<p><a href="../index/">[Index]</a> | [Downloads] | <a href="../guestbook/">[Guestbook]</a></p>
	</div>
	<div id="head"><h1>the downloads</h1></div>
	<!-- Main part of the page -->
	<div id="main">
		<?php
		// open the xml file, read some stuff from it //
		$parser = xml_parser_create();
		$posts = fopen("../content/dls.xml","r");
		$postdat = fread($posts, 4096);
		
		xml_parse_into_struct($parser,$postdat,$postvals);
		xml_parser_free($parser);
		fclose($posts);
		
		// parse it thoroughly and add links //
		foreach($postvals as $key=>$val) {	
			if($val[tag] == "URL") {
				echo("<a href=\""); print_r($val[value]); echo("\">");
			}
			if($val[tag] == "NAME") {
				echo("<h4>\n"); print_r($val[value]); echo("</h4></a>\n");
				echo("<a name=\""); print_r($val[value]); echo("\">");
			}
			if($val[tag] == "DESC") {
				echo("<p>"); print_r($val[value]); echo("</p><br/>\n");
			}
		}
		unset($val);
		?>
	</div>
	<!-- Sidebar -->
	<div id="sidebar">
		<h4>Links</h4>
		<!-- Example:
			 <a href="1">Hello, world!</a>-->
		<?php
		// add links //
		foreach($postvals as $key=>$val) {
			if($val[tag] == "NAME") {
				echo("<a href=\"#"); print_r($val[value]); echo("\">");
				echo("<p>"); print_r($val[value]); echo("</p></a>");
			}
		}
		unset($val);
		?>
	</div>
	<div id="footer"><a href="https://freedns.afraid.org/">FreeDNS</a> | <a href="http://marby.cf.gs/">Main</a></div>
</div>
</body>
</html>