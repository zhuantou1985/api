<?php
/**
 *
 * 使用特定function对数组中所有元素做处理
 * @param	string    &$array        		要处理的字符串
 * @param	string    $function    			要执行的函数
 * @param	boolean   $apply_to_keys_also   是否也应用到key上
 *
**/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }

        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    return $array;
}
/**
 * 显示json_encode后的中文字符
 * @param str $json 字符串
 * @return str
 */
function json2chinese($json){
	$json = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $json);
	echo $json;
}

//封装一下preg_match函数
function single_preg_match($preg,$content){
	if($content == ""){
		return false;
	}
	if(preg_match($preg,$content,$matches)){
		return trim($matches[1]);
	}else{
		return false;
	}
}

//二维数组排序， $arr是数据，$keys是排序的健值，$order是排序规则，0是升序，1是降序
function array_sort($arr, $keys, $order=0) {
        if (!is_array($arr)) {
                return false;
        }
        $keysvalue = array();
        foreach($arr as $key => $val) {
                $keysvalue[$key] = $val[$keys];
        }
        if($order == 0){
                asort($keysvalue);
        }else {
                arsort($keysvalue);
        }
        reset($keysvalue);
        foreach($keysvalue as $key => $vals) {
                $keysort[$key] = $key;
        }
        $new_array = array();
        foreach($keysort as $key => $val) {
                $new_array[$key] = $arr[$val];
        }
        return $new_array;
}

/**
 * 截取字符串
 *
 * @param string $str 原字符串
 * @param int $start 起始位置
 * @param int $length 截取长度
 * @param string $charset 编码
 * @param book $suffix 后缀
 * @return string 整理好的字符串
 */
function my_substr($str, $start = 0, $length, $charset = 'utf-8', $suffix = '')
{
	if(function_exists("mb_substr")) {
		if(mb_strlen($str, $charset) <= $length) return $str;
		$slice = mb_substr($str, $start, $length, $charset);
	} else {
		$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		if(count($match[0]) <= $length) return $str;
		$slice = join("",array_slice($match[0], $start, $length));
	}

	!empty($suffix) && $slice .= $suffix;

	if($suffix) return $slice."…";
	return $slice;
}

/**
 * 过滤特殊字符及乱码
 * @param $str 
 */
function filter($str){
	$str = filterSpecialChars($str);
	$str = filterMessChars($str);
	return $str;
}

/**
 * 过滤特殊字符
 * @param $str 
 */
function filterSpecialChars($str) {
	$replace_arr = array("'", "&", ";", "--", "<", ">", "(", ")", "=", "\"", ",", "[", "]", "{", "}", "\n", '\\');
	//print_r($replace_arr);
	$new_str = str_replace($replace_arr, " ", $str);
	return $new_str;
}

/**
 * 过滤乱码
 * @param $str 
 * @param $debug
 */
function filterMessChars($str, $debug=0)
{
	$str = preg_replace('/&lt;a href=&quot;.*?&quot; target=&quot;_blank&quot;&gt;.*?&lt;\/a&gt;/si', '', $str);
	//if($debug)echo $str."<br>\n";  
	$new_str = "";
	for($i = 0; $i < strlen($str); $i++)
	{	
        	$value = ord($str[$i]);
        	if($value > 127){
            		if($value >= 192 && $value <= 223) $c = 2;
            		elseif($value >= 224 && $value <= 239) $c = 3;
            		elseif($value >= 240 && $value <= 247) $c = 4;
            		else continue;
        	}
		else
			$c = 1;
		if(($c == 3 || $c == 1) && $value != 237)
			$new_str .= substr($str, $i, $c);
	//	if($debug)
	//		echo substr($str, $i, $c) . ":$c:" . $value."<br>\n";
	    	$i += $c - 1;
	}
	return $new_str;
}

/**
 * rysnc传输文件
 */
function rsync($file){
	$file2 = str_replace("/data/www/img/", "", $file);
	
	//124.248.33.59
	$cmd = "cd /data/www/img/; rsync -Rtup ".$file2." 124.248.33.59::img";
	//echo $cmd;exit;
	exec($cmd); 
}


/*
 * 记录访问次数
 * @param $is_cache 是否调用的缓存数据
 * @param $params		每页条数
 */
function view_log($is_cache, $params){
	
}

?>