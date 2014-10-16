<?php
	$todolist=array();
	$re=array();
	$content=file_get_contents("https://github.com/fifth/todolist/wiki");
	$content=strstr($content, '<ul class="wiki-pages"');
	$content=substr($content, 0, strpos($content, '</ul>')+4);
	$content=strip_tags($content,"<a>");
	while (strpos($content, "<a")) {
		$tmp=substr($content, 0, strpos($content, '</a>')+4);
		$title=strip_tags($tmp);
		$url="https://github.com".substr($tmp, strpos($tmp, '"')+1, strrpos($tmp, '"')-strpos($tmp, '"')-1);
		if (($url!='https://github.com/fifth/todolist/wiki')&&($url!='https://github.com/fifth/todolist/wiki/wiki%E6%A8%A1%E6%9D%BF%E9%A1%B5%E9%9D%A2')) {
			$todolist[]=array("title"=>$title, "url"=>$url);
		}
		$content=substr($content, strpos($content, '</a>')+4);
	}
	array_pop($todolist);
	foreach ($todolist as $key => $value) {
		$content=file_get_contents($value['url']);
		echo $content;
		die();
		// $re[$key]=
	}
	echo json_encode($todolist);
	// print_r(substr_count($content, "<a"));
	// print_r($todolist);
?>