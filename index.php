<?php
include ("./Includes/bbcodes.php");
if (isset($_COOKIE[NumberOfMaxPosts])) {
	$MaxPostsInPage = $_COOKIE[NumberOfMaxPosts];
} else {
	$MaxPostsInPage = 5;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Dark Realm</title>
	<link rel="stylesheet" type="text/css" href="../content/global.css">
</head>

<body>
<div id="wrapper">
	<!-- Top (navigation) bar -->
	<div id="topbar">
		<p>[Index]</p>
		<?php
		
		?>
	</div>
	<div id="head"><h1>Dark Realm</h1></div>
	<!-- Main part of the page -->
	<div id="main">
		<?php
		$page = (int) $_GET["page"] + 1;
		// count post files //
		$files = 0;
		for ($v = 1; $v < 100000; $v++) {
			if (file_exists ("./content/posts/post$v.xml")) $files++;
			else break;
		}
		if ($page > ceil ($files / ($MaxPostsInPage))) {
			echo ("The requested page does not exist.<br/>Redirecting to main page.");
			sleep(5);
			echo ("<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=http://darkrealm.altervista.org/\">");
		} else {
		// open the xml file, read some stuff from it //
		for ($i = ($MaxPostsInPage) * ($page) - 4; $i < (($MaxPostsInPage) * $page)+1; $i++) {
				if ($i <= $files) {
					$posts[$i] = fopen ("./content/posts/post$i.xml", "r");
					
					$parser[$i] = xml_parser_create ();
					$postdat[$i] = fread ($posts[$i], 4096);
					xml_parse_into_struct ($parser[$i], $postdat[$i], $postvals[$i]);
				}
				else break;
			}
		}
		
		xml_parser_free ($parser);
		fclose ($posts);
		
		// parse it thoroughly and add posts //
		for ($v = $i; $v > 0; $v--) {
			foreach ($postvals[$v] as $key=>$val) {
				if ($val[tag] == "TITLE") {
					$lmod = filemtime ("./content/posts/post$v.xml");
					echo ("<a name=\"$v\"> <a href=\"#$v\"><h3>Post $v</a>: " . $val[value] . "</h3>\n" .
						"<small>Date: " . date ("m/j/y h:i", $lmod) . "</small><br/>\n");
				}
				if ($val[tag] == "BODY")
				{
					echo ("<p>" . 
						preg_replace('/\\n/', '<br/>$0', parseBBcodes ($val[value])) .
						"\n");
				}
				if ($val[tag] == "AUTHOR") {
					echo ("--" . $val[value] . "</p><br/>");
				}
			}
			unset ($val);
		}
		?>
	</div>
	<!-- Sidebar -->
	<div id="sidebar"></div>
	<div id="Controls">
		<?php
		// add buttons to the bottom of the page //
		if (page < floor ($files / ($MaxPostsInPage))) {
			echo("<a href=\"?page=" . $page + 1 . "\">Older posts</a>");
		} else if (page > ceil ($files / ($MaxPostsInPage))) {
			echo ("<a href=\"?page=" . $page - 1 . "\">Newer posts</a>");
		} else {
			echo ("<a href=\"?page=" . $page - 1 . "\">Newer posts</a> - <a href=\"?page=" . $page + 1 . "\">Older posts</a>");
		}
		?>
	</div>
	<div id="footer"><p></p></div>
</div>
</body>
</html>