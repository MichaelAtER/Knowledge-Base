#!/usr/bin/php
<?php

$directory = "/Users/michael/Documents/ER/KB/Content/";

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

while($it->valid()) {

    if (!$it->isDot()) {
        
        $text = preg_replace("/.*?DS_Store.*?/",'',$it->key());
        $text = preg_replace("~$directory~","",$text);
        $text = preg_replace("~.*?/~","\t",$text);
        $text = preg_replace("/^\t/","",$text);
        $text = preg_replace("/^(\w)/","* $1",$text);
        $text = preg_replace("/^(\t+?)(\w)/","$1* $2",$text);
        if (!$text == '') {
        	$list = $list . $text . "\r";
		}
    }

    $it->next();
}

file_put_contents( "/Users/michael/Documents/ER/KB/File List.md" , $list );

?>