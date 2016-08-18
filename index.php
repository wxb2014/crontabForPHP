<?php
define('ROOT', getcwd().'/');
require_once ROOT.'AutoPlan.class.php';
$play = new AutoPlan();
$play->startTask();
