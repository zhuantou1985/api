<?php
/**
* ********************************************
* Description   : 配置文件
* author        : zhuantou
* Create time   : 2012-01-06
* Last modified : 2012-01-06 
* ********************************************
**/ 
define("API_DIR", "api");		//api的目录
define("DATA_DIR", "data");		//数据目录
define("LOG_DIR", "log");		//日志目录  


$config = array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',

	
	//路由配置
	$urlRule = array(
	    'pk' => array(          // control
	        'top' => array(     // action
	            'type'    => 'day,week,month' //params
	          ),
	    ),
	),


	//mysql
	'mysql'=>array( 
		'master' => array(
			"host"  => "localhost",  
			"user"  => 'test',  
			"pwd"   => '123456',  
			"db"    => 'test',  
		),
		'slave' => array( 
			"host"  => "localhost", 
			"user"  => 'test',  
			"pwd"   => '123456',  
			"db"    => 'test',  
		)
	),
	
	//mecache
	'memcache'=>array(
		'code'=>array(
			array('host'=>'192.168.133.10', 'port'=>11211, 'weight'=>50),
			array('host'=>'192.168.133.2', 'port'=>11211, 'weight'=>50),
		),
		'test'=>array(
			array('host'=>'localhost', 'port'=>11211, 'weight'=>50),
		),
	)
)
?>