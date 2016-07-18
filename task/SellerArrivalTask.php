<?php
/**
 * 卖家金额到账
 */

require_once ROOT.'task.class.php';

class SellerArrivalTask implements  task {

	/**
	 * 返回信息
	 */
	private $message = '';
	
	/**
	 * 任务主体
	 * @param int $cronId 任务ID
	 */
    public function run($cronId) {
    	return  '已执行SellerArrivalTask';
    }
	
    /**
     * 返回信息
     * @return string
     */
    public function getMessage(){
    	return $this->message;
    }
    
}