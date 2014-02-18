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
		$page = (int) $_GET["page"];
		// count post files //
		$files = 0;
		for($v = 1; $v < 200; $v++)
		{
			if(file_exists("../content/posts/post$v.xml")) $files++;
			else break;
		}
		if($page == 0 || $page > ceil($files / 5))
		{
			echo("<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=http://marrub.altervista.org/index/?page=1\">");
		}
		else
		{
		// open the xml file, read some stuff from it //
		for($i = 5 * ($page)-4; $i < (5*$page)+1; $i++)
		{
			if($i <= $files)
			{
				$posts[$i] = fopen("../content/posts/post$i.xml","r");
				
				$parser[$i] = xml_parser_create();
				$postdat[$i] = fread($posts[$i], 4096);
				xml_parse_into_struct($parser[$i],$postdat[$i],$postvals[$i]);
			}
			else break;
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
					echo("<a name=\"$v\"> <a href=\"#$v\"><h3>Post $v</a>: " . $val[value] . "</h3>\n" .
						"<small>Posted " . date("m/j/y h:i", $lmod) . "</small><br/>\n");
				}
				if($val[tag] == "BODY")
				{
					echo("<p>" . 
						preg_replace('/\\n/', '<br/>$0', $val[value]) .
						"</p><br/>\n");
				}
			}
			unset($val);
		}
		?>
	</div>
	<!-- Sidebar -->
	<div id="sidebar">
		<h4>Articles</h4>
		<?php
		// add posts to the articles list //
		for($v = $i; $v > 0; $v--)
		{
			foreach($postvals[$v] as $key=>$val)
			{
				if($val[tag] == "TITLE") {
					echo("<a href=\"#$v\"><p>$v</a>: " . $val[value] . "</p>\n");
				}
			}
			unset($val);
		}
		?>
		<br/><br/>
		<?php
		// add pages to the sidebar //
		for($k = ceil($files / 5); $k > 0; $k--) echo(" : Page <a href=\"?page=$k\">". $k ."</a><br/>\n");
		}
		?>
	</div>
	<div id="footer"><p><a href="https://freedns.afraid.org/">FreeDNS</a> | <a href="http://marby.cf.gs/">Main</a></p></div>
</div>
</body>
</html>