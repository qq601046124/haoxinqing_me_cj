<?php 

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
 
$sql = <<<EOF
DROP TABLE `pre_haoxinqing_me_cj`
EOF;

runquery($sql);
$finish = true;
?>