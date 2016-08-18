# crontabForPHP
crontab by php

使用命名空间\r\n
从data 文件夹导入数据表
调用代码如

$dbconfig = [
                'DB_HOST'   => 'xxx',
                'DB_NAME'   => 'xxx',
                'DB_USER'   => 'xxx',
                'DB_PWD'    => 'xxx',
                'DB_PREFIX' => 'xxx',
            ];
$autoPlan = new IndexAutoPlan($dbconfig);
$autoPlan->startTask();

