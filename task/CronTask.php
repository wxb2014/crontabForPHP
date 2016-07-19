<?php
/**
 * 计划任务事例
 */
require_once ROOT.'task/task.class.php';
class CronTask implements task{

	/**
	 * 返回信息
	 */
	private $message = '';
	
	/**
	 * 任务主体
	 * @param int $cronId 任务ID
	 */
    public function run($cronId) {
    	return "我执行了计划任务事例 CronTask.php！";
        //Log::write($this->message,"NOTICE");
    }
	
    /**
     * 返回信息
     * @return string
     */
    public function getMessage(){
    	return $this->message;
    }
    
}