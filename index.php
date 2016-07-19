<?php
define('ROOT', '/data/wwwroot/default/git/crontabForPHP/');
require_once ROOT.'AutoPlan.class.php';
$play = new AutoPlan();
$play->startTask();
