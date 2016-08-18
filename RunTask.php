<?php

namespace crontabForPHP;

abstract class RunTask {

	function startTask($maxTime = 0){
		if(!$this->checkTime($maxTime)){
			exit('时间间隔过短');
		};
		set_time_limit(0);
        ignore_user_abort(true);
		$taskObjs = $this->getNowTask();
		$taskRets = $this->run($taskObjs);		
	}
	
	abstract function getNowTask();
	
	function run(array $taskObjs){	    
		foreach($taskObjs as $v){
			$v['message'] = $v['taskObj']->run($v['pk_cr']);			
			$this->afterTask($v);	
		}		
	}
	
	abstract function afterTask($taskRets);
		 
    function checkTime($maxTime){
        // 锁定自动执行
        $lockfile = __DIR__.'\\cron.lock';
        if (is_writable($lockfile) && filemtime($lockfile) > $_SERVER['REQUEST_TIME'] - $maxTime) {
        	unlink($lockfile);
        	return false;
        } else {
            //设置指定文件的访问和修改时间
            touch($lockfile);            
        }   		     
        return true;  
    }

     /**
     * 获得下次执行时间
     * @param string $loopType month/week/day/hour/now
     * @param int $day 几号， 如果是99表示当月最后一天
     * @param int $hour 几点
     * @param int $minute 每小时的几分
     */
    protected function getNextTime($loopType, $day = 0, $hour = 0, $minute = 0) {
        $time = time();
        $_minute = intval(date('i', $time));
        $_hour = date('G', $time);
        $_day = date('j', $time);
        $_week = date('w', $time);
        $_mouth = date('n', $time);
        $_year = date('Y', $time);
        $nexttime = mktime($_hour, 0, 0, $_mouth, $_day, $_year);
        switch ($loopType) {
            case 'month':
                //是否闰年
                $isLeapYear = date('L', $time);
                //获得天数
                $mouthDays = $this->_getMouthDays($_mouth, $isLeapYear);
                //最后一天
                if ($day == 99)
                    $day = $mouthDays;
                $nexttime += ($hour < $_hour ? -($_hour - $hour) : $hour - $_hour) * 3600;
                if ($hour <= $_hour && $day == $_day) {
                    $nexttime += ($mouthDays - $_day + $day) * 86400;
                } else {
                    $nexttime += ($day < $_day ? $mouthDays - $_day + $day : $day - $_day) * 86400;
                }
                break;
            case 'week':
                $nexttime += ($hour < $_hour ? -($_hour - $hour) : $hour - $_hour) * 3600;
                if ($hour <= $_hour && $day == $_week) {
                    $nexttime += (7 - $_week + $day) * 86400;
                } else {
                    $nexttime += ($day < $_week ? 7 - $_week + $day : $day - $_week) * 86400;
                }
                break;
            case 'day':
                $nexttime += ($hour < $_hour ? -($_hour - $hour) : $hour - $_hour) * 3600;
                if ($hour <= $_hour) {
                    $nexttime += 86400;
                }
                break;
            case 'hour':
                $nexttime += $minute < $_minute ? 3600 + $minute * 60 : $minute * 60;
                break;
            case 'now':
                $nexttime = mktime($_hour, $_minute, 0, $_mouth, $_day, $_year);
                $_time = $day * 24 * 60;
                $_time += $hour * 60;
                $_time += $minute;
                $_time = $_time * 60;
                $nexttime += $_time;
                break;
        }
        return $nexttime;
    }

    /**
     * 获取该月天数
     * @param type $month 月份
     * @param type $isLeapYear 是否为闰年
     * @return int
     */
   protected function _getMouthDays($month, $isLeapYear) {
        if (in_array($month, array('1', '3', '5', '7', '8', '10', '12'))) {
            $days = 31;
        } elseif ($month != 2) {
            $days = 30;
        } else {
            if ($isLeapYear) {
                $days = 29;
            } else {
                $days = 28;
            }
        }
        return $days;
    }
}
