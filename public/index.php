<?php

include "../vendor/autoload.php";

use HCM\HcmController;
use HCM\Data\Mysql;
use HCM\Data\Redis;


$hcmCtrl = new HcmController();

echo $hcmCtrl->hello();
//$mysql = new Mysql();
//$mysql->addVisit();
$redis = new Redis();
$redis->addVisits();