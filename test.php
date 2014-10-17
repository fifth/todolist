<?php
	$todolist=array();
	$re=array();
	$content=file_get_contents("https://github.com/fifth/todolist/wiki");
	if (preg_match("/\<ul\sclass=\"wiki-pages\"[\s\S]*?\<\/ul\>/", $content, $matches)) {
		$content=$matches[0];
	}
	if (preg_match_all("/\<a[\s\S]*?\<\/a\>/", $content, $matches)) {
		$content=$matches[0];
		array_pop($content);
		foreach ($content as $key => $value) {
			if ((preg_match("/(?<=\")[\s\S]*(?=\")/", $value, $url))&&($url[0]!="/fifth/todolist/wiki")&&($url[0]!="/fifth/todolist/wiki/wiki%E6%A8%A1%E6%9D%BF%E9%A1%B5%E9%9D%A2")&&(preg_match("/(?<=\>)[\s\S]*(?=\<\/a\>)/", $value, $title))) {
				$todolist[]=array(
					"url" => "https://github.com".$url[0],
					"title" => $title[0]
				);
			}
		}
	}
	foreach ($todolist as $key => $value) {
		// $re[$key]=array();
		$content=file_get_contents($value['url']);
		if (preg_match("/\<div\sclass=\"markdown-body\"\>[\s\S]*?\<\/div\>/", $content, $matches)) {
			$content=$matches[0];
		}
		if (preg_match("/(?<=\<\/a\>)[\s\S]*?(?=\<\/h1\>)/", $content, $matches)) {
			$re[$key]['title-zh']=$matches[0];
			preg_match("/(?<=\<\/h1\>)[\s\S]*/", $content, $matches);
			$content=$matches[0];
		}
		if (preg_match("/(?<=\<\/a\>)[\s\S]*?(?=\<\/h2\>)/", $content, $matches)) {
			$re[$key]['title-jp']=$matches[0];
			preg_match("/(?<=\<\/h2\>)[\s\S]*/", $content, $matches);
			$content=$matches[0];
		}
		if (preg_match("/(?<=\<\/a\>)[\s\S]*?(?=\<\/h3\>)/", $content, $matches)) {
			$re[$key]['title-en']=$matches[0];
			preg_match("/(?<=\<\/h3\>)[\s\S]*/", $content, $matches);
			$content=$matches[0];
		}
		if (preg_match_all("/\<p\>[\s\S]*?\<\/p\>/", $content, $matches)) {
			print_r(count($matches[0]));
			print_r("<br/>");
		}
		if ($key==3) {
			print_r($re[$key]['title-zh']);
			print_r($re[$key]['title-jp']);
			print_r($re[$key]['title-en']);
			print_r($content);
			die();	
		}
	}
?>