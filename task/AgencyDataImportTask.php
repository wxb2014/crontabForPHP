<?php
require_once ROOT.'task.class.php';
class AgencyDataImportTask implements task{
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
        return  '已执行AgencyDataImportTask';
    }

    /**
     * 返回信息
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }
}