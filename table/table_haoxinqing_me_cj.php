<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_haoxinqing_me_cj extends discuz_table
{
	public function __construct() {

		$this->_table = 'haoxinqing_me_cj';
		$this->_pk    = 'id';

		parent::__construct();
	}
	
	public function fetch_all_dh(){
		return DB::fetch_all('SELECT * FROM %t ORDER BY displayorder,id',array($this->_table),'id');
	}

}

?>