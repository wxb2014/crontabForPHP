<?php
/**
 * 学习记录计划任务
 */
require_once ROOT.'task/task.class.php';
class LearningRecordTask implements task{

	/**
	 * 返回信息
	 */
	private $message = '';
	
	/**
	 * 任务主体
	 * @param int $cronId 任务ID
	 */
    public function run($cronId) {
    	return  '已执行LearningRecordTask';
    }
	
    /**
     * 返回信息
     * @return string
     */
    public function getMessage(){
    	return $this->message;
    }
    
}
