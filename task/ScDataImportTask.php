<?php
/**
 * 导入学校、班级数据计划任务
 */

require_once ROOT.'task.class.php';

class ScDataImportTask implements task{
    /**
     * 返回信息
     */
    private $message = '';

    protected $passtime = 180;

    /**
     * 任务主体
     * @param int $cronId 任务ID
     */
    public function run($cronId) {
    	return  '已执行ScDataImportTask';
    }
    
    /**
     * 返回信息
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }
}