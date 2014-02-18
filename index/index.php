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
		<p>[Index] | <a href="../downloads/">[Downloads]</a> | <a href="../guestbook/">[Guestbook]</a></p>
	</div>
	<div id="head"><h1>marrub's place</h1></div>
	<!-- Main part of the page -->
	<div id="main">
		<?php
		// open the xml file, read some stuff from it //
		for($i = 1; $i < 200; $i++)
		{
			if(file_exists("../content/posts/post$i.xml"))
			{
				$posts[$i] = fopen("../content/posts/post$i.xml","r");
				
				$parser[$i] = xml_parser_create();
				$postdat[$i] = fread($posts[$i], 4096);
				xml_parse_into_struct($parser[$i],$postdat[$i],$postvals[$i]);
			}
			else
			{
				break;
			}
		}
		
		xml_parser_free($parser);
		fclose($posts);
		
		// parse it thoroughly and add posts //
		for($v = $i; $v > 0; $v--)
		{
			foreach($postvals[$v] as $key=>$val)
			{
				if($val[tag] == "TITLE") {
					$lmod = filemtime("../content/posts/post$v.xml");
					echo("<a name=\"$v\"> <a href=\"#$v\"><h3>Post $v</a>: ");print_r($val[value]); echo("</h3>\n");
					echo("<small>Posted "); echo(date("m/j/y h:i", $lmod)); echo("</small><br/>\n");
				}
				if($val[tag] == "BODY")
				{
					echo("<p>");// print_r($val[value]);
					echo(preg_replace('/\\n/', '<br/>$0', $val[value]));
					echo("</p><br/>\n");
				}
			}
			unset($val);
		}
		?>
	</div>
	<!-- Sidebar -->
	<div id="sidebar">
		<h4>Articles</h4>
		<!-- Example:
			 <a href="1">Hello, world!</a>-->
		<?php
		// add posts to the articles list //
		for($v = $i; $v > 0; $v--)
		{
			foreach($postvals[$v] as $key=>$val)
			{
				if($val[tag] == "TITLE") {
					echo("<a href=\"#$v\"><p>$v</a>: ");print_r($val[value]); echo("</p>\n");
				}
			}
			unset($val);
		}
		unset($val);
		?>
	</div>
	<div id="footer"><a href="https://freedns.afraid.org/">FreeDNS</a> | <a href="http://marby.cf.gs/">Main</a></div>
</div>
</body>
</html>