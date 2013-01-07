<?php
class Curl{
	
	static public function post($url, $param)
	{
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, self::makeParamStr($param));
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
	
	static public function makeParamStr($param)
	{
		if(empty($param))
			return ;
		foreach ($param as $key => $value)
		{
			$p[] = $key . '=' . $value;
		}
		return implode('&', $p);
	}
}