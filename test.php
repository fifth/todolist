<?php
	$todolist=array();
	$content=file_get_contents("https://github.com/fifth/todolist/wiki");
	$content=strstr($content, '<ul class="wiki-pages"');
	$content=substr($content, 0, strpos($content, '</ul>')+4);
	$content=strip_tags($content,"<a>");
	while (strpos($content, "<a")) {
		$tmp=substr($content, 0, strpos($content, '</a>')+4);
		$todolist[]=array("title"=>strip_tags($tmp), "url"=>"https://github.com".substr($tmp, strpos($tmp, '"')+1, strrpos($tmp, '"')-strpos($tmp, '"')-1));
		$content=substr($content, strpos($content, '</a>')+4);
	}
	
	// print_r(substr_count($content, "<a"));
	print_r($todolist);
?>