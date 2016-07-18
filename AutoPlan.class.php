<?php

include_once './RunTask.class.php';

class AutoPlan extends RunTask{

	public $dbsource = null;

	function __construct(){
		$dbconfig = [
		    'URL_MODEL'=>2, // 如果你的环境不支持PATHINFO 请设置为3
			'DB_TYPE'=>'mysql',
			'DB_HOST'=>'192.168.0.106',
			'DB_NAME'=>'situ_com',
			'DB_USER'=>'root',
			'DB_PWD'=>'123456',
			'DB_PORT'=>'3306'];
		$this->dbsource = mysqli_connect($dbconfig['DB_HOST'],$dbconfig['DB_USER'],$dbconfig['DB_PWD'],$dbconfig['DB_NAME']);
		mysqli_set_charset($this->dbsource, "utf8"); 
	}
	
	function getNowTask(){
		$_time = time();
		$dir = "./task/";
		$sql = 'SELECT * FROM `cwh_cron` WHERE ( `cr_isopen` >= 1 ) ORDER BY `cr_next_time` ASC ';
		$result = $this->dbsource->query($sql);
		$taskArr = [];
		while ($cron = $result->fetch_assoc()) {
				$filename = $cron['cr_file'];
				$cronId = $cron['pk_cr'];		    
	        if ( $cron['cr_next_time'] > $_time || !$filename || strpos($filename, "Task") === false){
	    		continue;       
			}else{					       
		        try{
		        	$require = require_once($dir . $filename . ".php");			
	                $taskObj = new $filename();
					$cron['taskObj'] = $taskObj;		
					$taskArr[] = $cron;	
		        }catch(Exception $e){

		        }		        
			}
	    }	    
	    return $taskArr;

	}
	
	function afterTask($taskRets){
		//更新时间
		list($day, $hour, $minute) = explode('-', $taskRets['cr_loop_daytime']);        
        $cr_next_time = $this->getNextTime($taskRets['cr_loop_type'], $day, $hour, $minute);
		$pk_cr = $taskRets['pk_cr'];
		$query = "UPDATE `cwh_cron` SET `cr_modified_time`= ".time().",`cr_next_time`= ".$cr_next_time." WHERE ( `pk_cr` = ".$pk_cr." )";
		$stmt = $this->dbsource->prepare($query);		
		$stmt->execute();
		$stmt->close();
		//做日志
		$data['cr_id'] = $taskRets['pk_cr'];
        $data['cr_file'] = $taskRets['cr_file'];
        $data['crlog_message'] = $taskRets['message'];
        $data['crlog_add_time'] = time();
		$query = "INSERT INTO `cwh_cron_log` (`cr_id`,`cr_file`,`crlog_message`,`crlog_add_time`) VALUES ({$data['cr_id']},'{$data['cr_file']}','{$data['crlog_message']}',{$data['crlog_add_time']})";
		$stmt = $this->dbsource->prepare($query);		
		$stmt->execute();
		$stmt->close();
	}

 

	function __destruct(){
		mysqli_close($this->dbsource);
	}
}
$play = new AutoPlan();
$play->startTask();
