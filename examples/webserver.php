<?php
define('DEBUG', 'on');
define("WEBPATH", realpath(__DIR__.'/../'));
require __DIR__ . '/../libs/lib_config.php';
//require __DIR__'/phar://swoole.phar';
Swoole\Config::$debug = false;
$AppSvr = new Swoole\Network\Protocol\AppServer();
$AppSvr->loadSetting(__DIR__.'/swoole.ini'); //加载配置文件
$AppSvr->setAppPath(WEBPATH.'/apps/'); //设置应用所在的目录
$AppSvr->setDocumentRoot(WEBPATH);
$AppSvr->setLogger(new \Swoole\Log\EchoLog(true)); //Logger

Swoole\Error::$echo_html = false;
$server = new \Swoole\Network\Server('0.0.0.0', 8888);
$server->setProtocol($AppSvr);
$server->daemonize(); //作为守护进程
$server->run(array('worker_num' => 8, 'max_request' => 5000));
