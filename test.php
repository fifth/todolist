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
		// chinese version
		if (preg_match("/\<h1\>[\s\S]*?\<\/blockquote\>/", $content, $matches)) {
			if (preg_match("/(?<=\<\/a\>)[\s\S]*?(?=\<\/h1\>)/", $matches[0], $temp)) {
				$re[$key]['title-zh']=$temp[0];
			}
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0], $temp)) {
				$re[$key]['description-zh']=strip_tags($temp[0]);
			}
		}
		// japanese version
		if (preg_match("/\<h2\>[\s\S]*?\<\/blockquote\>/", $content, $matches)) {
			if (preg_match("/(?<=\<\/a\>)[\s\S]*?(?=\<\/h2\>)/", $matches[0], $temp)) {
				$re[$key]['title-jp']=$temp[0];
			}
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0], $temp)) {
				$re[$key]['description-jp']=strip_tags($temp[0]);
			}
		}
		// english version
		if (preg_match("/\<h3\>[\s\S]*?\<\/blockquote\>/", $content, $matches)) {
			if (preg_match("/(?<=\<\/a\>)[\s\S]*?(?=\<\/h3\>)/", $matches[0], $temp)) {
				$re[$key]['title-en']=$temp[0];
			}
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0], $temp)) {
				$re[$key]['description-en']=strip_tags($temp[0]);
			}
		}
		if (preg_match_all("/\<h4\>[\s\S]*?\<\/blockquote\>/", $content, $matches)) {
			// print_r($matches[0]);
			// die();
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0][0], $temp)) {
				$re[$key]['time-start']=strip_tags($temp[0]);
			}
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0][1], $temp)) {
				$re[$key]['time-end']=strip_tags($temp[0]);
			}
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0][2], $temp)) {
				$re[$key]['related-links']=strip_tags($temp[0]);
			}
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0][3], $temp)) {
				$re[$key]['contributer']=strip_tags($temp[0]);
			}
		}
		// extra content
		if (preg_match("/\<h5\>[\s\S]*?\<\/blockquote\>/", $content, $matches)) {
			if (preg_match("/(?<=\<blockquote\>)[\s\S]*?(?=\<\/blockquote\>)/", $matches[0], $temp)) {
				$re[$key]['extra-content']=strip_tags($temp[0]);
			}
		}
		echo json_encode($re);
	}
?>