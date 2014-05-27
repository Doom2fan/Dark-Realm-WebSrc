<?php

/* PHP BBCode Parser */

// BBCode Parser function

function parseBBcodes($text)
{
	// BBcode array
	$find = array(
		'~\[b\](.*?)\[/b\]~s', // bold
		'~\[i\](.*?)\[/i\]~s', // italic
		'~\[u\](.*?)\[/u\]~s', // uncerline
		'~\[s\](.*?)\[/s\]~s', // strikethrough
		'~\[quote\](.*?)\[/quote\]~s', // quote
		'~\[size=(.*?)\](.*?)\[/size\]~s', // size
		'~\[color=(.*?)\](.*?)\[/color\]~s', // color
		'~\[url="((?:ftp|https?)://.*?)"\](.*?)\[/url\]~s', // url
		'~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s', // img
	);

	// HTML tags to replace BBcode
	$replace = array(
		'<b>$1</b>', // bold
		'<i>$1</i>', // italic
		'<span style="text-decoration:underline;">$1</span>', // uncerline
		'<strike>$1</strike>', // strikethrough
		'<pre>$1</'.'pre>', // quote
		'<span style="font-size:$1px;">$2</span>', // size
		'<span style="color:$1;">$2</span>', // color
		'<a href="$1">$2</a>', // url
		'<img src="$1" alt="" />' // img
	);

	// Replacing the BBcodes with corresponding HTML tags
	return preg_replace($find,$replace,$text);
}

?>