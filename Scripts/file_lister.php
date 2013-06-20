#!/usr/bin/php
<?php

// Iterating over directory to grab current names
$directory = "/Users/michael/Documents/ER/KB/Content/";
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

// Function to standardize list format for filenames
function format_for_list($text) {
	$t = no_ds($text);
	$t = preg_replace("~$directory~","",$t);
	$t = preg_replace("~.*?/~","",$t);
	return $t;
}

// Get rid of DS_Store files
function no_ds($text) {
	if ( !preg_match("/DS_Store/",$text) ) {
		return $text;
	}
}

function doc_status($obj) {
	if (!preg_match("/DS_Store/",$obj)) {
		$string = file_get_contents($obj);
		if (preg_match("/^xxx$/",$string)) {
			return ",x,x,x\r";
		} elseif (preg_match("/^xx$/",$string)) {
			return ",x,x,,\r";
		} elseif (preg_match("/\rx/",$string)) {
			return ",x,,,\r";
		} else {
			return ",NO,NO,NO\r";
		}
	}
}

function write_to_csv($list) {
	// Formatting for CSV
	$headers = "Name,Draft,Final,Deploy\r";
	$w = $headers . $list;

	// Write to file
	file_put_contents( "/Users/michael/Documents/ER/KB/File List.csv" , $w );
}

while ( $it->valid() ) {
    if ( ! $it->isDot() ) {
    	$path = $it->key();
    	
    	$stat = doc_status($path);
		$text = format_for_list($path);

		if ($text != '') {
			$list = $list . $text . $stat;
			write_to_csv($list);
		}
	}
    $it->next();
}

?>