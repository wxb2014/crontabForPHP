<?php
/**
 * 设置还款计划状态
 */

namespace crontabForPHP\task;

class SetLoanRepaymentPlanTask implements task {

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
        return '已执行SetLoanRepaymentPlanTask';
    }

    /**
     * 返回信息
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

}
