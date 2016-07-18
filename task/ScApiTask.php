<?php
/**
 * 学校api接口任务
 *
 */

require_once 'task.class.php';

class ScApiTask implements task{

	/**
	 * 返回信息
	 */
	private $message = '';
	
	/**
	 * 任务主体
	 * @param int $cronId 任务ID
	 */
    public function run($cronId) {
    	return  '已执行ScApiTask';
    }
	
    /**
     * 返回信息
     * @return string
     */
    public function getMessage(){
    	return $this->message;
    }
    
}