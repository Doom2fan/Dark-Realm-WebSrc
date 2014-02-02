<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>marrub's place</title>
	<link rel="stylesheet" type="text/css" href="../content/global.css">
</head>

<body>
<div id="wrapper">
	<div id="head"><h1>marrub's place</h1></div>
	<!-- Top (navigation) bar -->
	<div id="topbar">
		<p>[Index] | <a href="../downloads/">[Downloads]</a> | <a href="../guestbook/">[Guestbook]</a></p>
	</div>
	<!-- Main part of the page -->
	<div id="main">
		<?php
		// open the xml file, read some stuff from it //
		$parser = xml_parser_create();
		$posts = fopen("../content/posts.xml","r");
		$postdat = fread($posts, 4096);
		
		xml_parse_into_struct($parser,$postdat,$postvals);
		xml_parser_free($parser);
		fclose($posts);
		
		// parse it thoroughly and add posts //
		foreach($postvals as $key=>$val) {
			if($val[tag] == "NUM") {
				echo("<a name=\""); print_r($val[value]); echo("\">");
				echo("<a href=\"#"); print_r($val[value]); echo("\">");
				echo("<h3>Post "); print_r($val[value]); echo("</a>: ");
			}
			if($val[tag] == "TITLE") {
				print_r($val[value]); echo("</h3>\n");
			}
			if($val[tag] == "BODY") {
				echo("<p>"); print_r($val[value]); echo("</p><br/>\n");
			}
		}
		unset($val);
		?>
	</div>
	<!-- Sidebar -->
	<div id="sidebar">
		<h4>Articles</h4>
		<!-- Example:
			 <a href="1">Hello, world!</a>-->
		<?php
		// add posts to the articles list //
		foreach($postvals as $key=>$val) {
			if($val[tag] == "NUM") {
				echo("<a href=\"#"); print_r($val[value]); echo("\">");
				echo("<p>Post "); print_r($val[value]); echo(": ");
			}
			if($val[tag] == "TITLE") {
				print_r($val[value]); echo("</p></a>\n");
			}
		}
		unset($val);
		?>
	</div>
	<div id="footer"></div>
</div>
</body>
</html>