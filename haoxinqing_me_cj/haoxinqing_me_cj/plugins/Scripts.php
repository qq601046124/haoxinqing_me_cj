<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * haoxinqing_me_cj plugin class extending haoxinqing_me_cj object.
 * Methods from this class are callable on every haoxinqing_me_cj object.
 *
 * Class name prefix 'haoxinqing_me_cjObjectPlugin_' must be preserved.
 */
abstract class haoxinqing_me_cjObjectPlugin_Scripts {
	/**
	 * Limit binded methods.
	 *
	 * null means all public.
	 * array means only specified ones.
	 *
	 * @var array|null
	 */
	public static $haoxinqing_me_cjMethods = null;
	public static $config = array();
	/**
	 * Enter description here...
	 *
	 * @param haoxinqing_me_cjObject $self
	 */
	public static function script($self, $arg1) {
		$params = func_get_args();
		$params = array_slice($params, 2);
		$return = null;
		$config = self::$config;
		if (haoxinqing_me_cjPlugin_Scripts::$scriptMethods[$arg1]) {
			haoxinqing_me_cj::callbackRun(
				haoxinqing_me_cjPlugin_Scripts::$scriptMethods[$arg1],
				array($self, $params, &$return, $config)
			);
		} else if ($arg1 != '__config' && file_exists(dirname(__FILE__)."/Scripts/$arg1.php")) {
			haoxinqing_me_cj::debug("Loading script '$arg1'");
			require dirname(__FILE__)."/Scripts/$arg1.php";
		} else {
			haoxinqing_me_cj::debug("Requested script '$arg1' doesn't exist");
		}
		return $return
			? $return
			: $self;
	}
}
abstract class haoxinqing_me_cjPlugin_Scripts {
	public static $scriptMethods = array();
	public static function __initialize() {
		if (file_exists(dirname(__FILE__)."/Scripts/__config.php")) {
			include dirname(__FILE__)."/Scripts/__config.php";
			haoxinqing_me_cjObjectPlugin_Scripts::$config = $config;
		}
	}
	/**
	 * Extend scripts' namespace with $name related with $callback.
	 * 
	 * Callback parameter order looks like this:
	 * - $this
	 * - $params
	 * - &$return
	 * - $config
	 * 
	 * @param $name
	 * @param $callback
	 * @return bool
	 */
	public static function script($name, $callback) {
		if (haoxinqing_me_cjPlugin_Scripts::$scriptMethods[$name])
			throw new Exception("Script name conflict - '$name'");
		haoxinqing_me_cjPlugin_Scripts::$scriptMethods[$name] = $callback;
	}
}
?>