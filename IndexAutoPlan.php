
<?php

/**
 *定时执行入口文件
 */

namespace crontabForPHP;

class IndexAutoPlan extends RunTask{

	protected $dbsource = null;
	protected $dbconfig = [
		'DB_TYPE'   => 'mysql',
		'DB_HOST'   => '127.0.0.1',
		'DB_NAME'   => 'xxx',
		'DB_USER'   => 'xxx',
		'DB_PWD'    => 'xxx',
		'DB_PORT'   => '3306',
		'DB_PREFIX' => 'xxx'
	];

	function __construct($config){
		//获取配置
		$this->dbconfig = array_merge($this->dbconfig,$config);
		$this->dbsource = mysqli_connect($this->dbconfig['DB_HOST'],$this->dbconfig['DB_USER'],$this->dbconfig['DB_PWD'],$this->dbconfig['DB_NAME']);
		mysqli_set_charset($this->dbsource, "utf8"); 
	}
	
	function getNowTask(){
		$_time = time();
		$prefix_namespace = "\\crontabForPHP\\task\\";
		$sql = "SELECT * FROM `{$this->dbconfig['DB_PREFIX']}cron` WHERE ( `cr_isopen` >= 1 ) ORDER BY `cr_next_time` ASC ";
		$result = $this->dbsource->query($sql);
		$taskArr = [];
		while ($cron = $result->fetch_assoc()) {
				$filename = $cron['cr_file'];
				$cronId = $cron['pk_cr'];
	        if ( $cron['cr_next_time'] > $_time || !$filename || strpos($filename, "Task") === false){
	    		continue;       
			}else{					       
		        try{
					$taskObj = $prefix_namespace.$filename;
					$taskObj = new $taskObj($cronId);
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
		$query = "UPDATE `{$this->dbconfig['DB_PREFIX']}cron` SET `cr_modified_time`= ".time().",`cr_next_time`= ".$cr_next_time." WHERE ( `pk_cr` = ".$pk_cr." )";
		$stmt = $this->dbsource->prepare($query);		
		$stmt->execute();
		$stmt->close();
		//做日志
		$data['cr_id'] = $taskRets['pk_cr'];
        $data['cr_file'] = $taskRets['cr_file'];
        $data['crlog_message'] = $taskRets['message'];
        $data['crlog_add_time'] = time();
		$query = "INSERT INTO `{$this->dbconfig['DB_PREFIX']}cron_log` (`cr_id`,`cr_file`,`crlog_message`,`crlog_add_time`) VALUES ({$data['cr_id']},'{$data['cr_file']}','{$data['crlog_message']}',{$data['crlog_add_time']})";
		$stmt = $this->dbsource->prepare($query);		
		$stmt->execute();
		$stmt->close();
	}

 

	function __destruct(){
		mysqli_close($this->dbsource);
	}
}


