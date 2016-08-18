<?php

namespace crontabForPHP\task;

interface task{
	function run($cronId);
}