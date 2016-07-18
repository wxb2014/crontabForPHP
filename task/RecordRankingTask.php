<?php
/**
 * 学习记录统计计划任务
 */
require_once ROOT.'task.class.php';
class RecordRankingTask implements task{

	/**
	 * 返回信息
	 */
	private $message = '';

    /**
     * 任务主体
     * @param int $cronId 任务ID
     * @return bool
     */
    public function run($cronId) {
    	return  '已执行RecordRankingTask';
    }
    /**
     * 返回信息
     * @return string
     */
    public function getMessage(){
    	return $this->message;
    }
    
}