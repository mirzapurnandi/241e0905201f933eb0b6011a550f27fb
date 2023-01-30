<?php
require_once 'config/RedisConnect.php';
$redis = new RedisConnect();
$redis->worker();
