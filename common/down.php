<?php
/**
* ********************************************
* Description   : 抓取类
* author        : zhuantou
* Create time   : 2011-01-03
* Last modified : 2011-01-03
* ********************************************
**/
class Down{
	/**
	 * 下载文件
	 * @param str $url 		//文件URL
	 * @param str $dir  	//存储目录
	 * @param int $force  	//0不强制，1强制下载
	 * @param int $rename  	//0不重命名，1重命名
	 * @return array	
	 */
	function get($url, $dir, $force=0, $rename=0, $cookie=0){
		if ($url=="" || $dir=="") {
			return false;
		}
		
		//补充目录后的斜杠
		if (preg_match('/\/$/',$dir) == false) {
			$dir = $dir."/";
		}
		
		//$this->autoFileName($url);
	
		//创建目录
		$this->createFolder($dir);
		
		//获得文件名
		if ($rename) {
			$md5 = md5($url);
			$dir = $dir . substr($md5, 0 , 2) . "/" . substr($md5, 2 , 2)."/";
			$this->createFolder($dir);
			$parse_url = parse_url($url);
			$path_info = $parse_url['path'];			
			if (preg_match('/.*\.(.*)/si', $path_info, $match)) {
				$postfix = $match[1];
			}
			$filename = $md5 . "." . $postfix;
		} else {
			$md5 = md5($url);
			$dir = $dir . substr($md5, 0 , 2) . "/" . substr($md5, 2 , 2)."/";
			$this->createFolder($dir);
			
			$pathinfo = pathinfo($url);
			$filename = $pathinfo['basename'];
			if (strpos($filename, ".") === false) {
				$filename = md5($url);
			}
		}
		//echo $dir.$filename."\n";exit;
		
		
		//文件不存在 或者 强制下载时执行下载操作
		//-q 安静模式，-P保存目录 -O文件名
		if (@filesize($dir.$filename) < 1 || $force == 1) {
			if ($cookie) {
				$cookie_str = "--load-cookies='".$cookie."'";
			}
			$cmd = "wget -q '".$url."' -P $dir -O ".$dir.$filename." ".$cookie_str;
			//echo $cmd;exit;
			exec($cmd);	
		}
		
		return $dir.$filename;
	}
	
	/**
	 * 创建多级目录
	 *
	 * @param $dir 目录路径
	 */
	function createFolder($dir) {
		$cmd = "mkdir $dir -p";
		exec($cmd);
	}
	
	/**
	 * 自动命名文件
	 */
	function autoFileName($url){
		$md5 = md5($url);
	}
}
?>