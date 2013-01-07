<?php
class DataController{
	private $_model;
	
	public function __construct(){
		$this->_model = $this->loadModel();
	}
	

	//列表
	public function actionList($condition=""){
		$params = http_build_query($condition);
		$params = urldecode($params);
		//print_r($condition);exit;
		

		$result = $this->_model->dataList($condition);
		return $result;
	}
	
	

	public function loadModel(){
		return new Data;
	}
}