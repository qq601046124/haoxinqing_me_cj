<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * Example of haoxinqing_me_cj plugin.
 *
 * Load it like this:
 * haoxinqing_me_cj::plugin('example')
 * haoxinqing_me_cj::plugin('example', 'example.php')
 * pq('ul')->plugin('example')
 * pq('ul')->plugin('example', 'example.php')
 *
 * Plugin classes are never intialized, just method calls are forwarded
 * in static way from haoxinqing_me_cj.
 *
 * Have fun writing plugins :)
 */

/**
 * haoxinqing_me_cj plugin class extending haoxinqing_me_cj object.
 * Methods from this class are callable on every haoxinqing_me_cj object.
 *
 * Class name prefix 'haoxinqing_me_cjObjectPlugin_' must be preserved.
 */
abstract class haoxinqing_me_cjObjectPlugin_example {
	/**
	 * Limit binded methods.
	 *
	 * null means all public.
	 * array means only specified ones.
	 *
	 * @var array|null
	 */
	public static $haoxinqing_me_cjMethods = null;
	/**
	 * Enter description here...
	 *
	 * @param haoxinqing_me_cjObject $self
	 */
	public static function example($self, $arg1) {
		// this method can be called on any haoxinqing_me_cj object, like this:
		// pq('div')->example('$arg1 Value')

		// do something
		$self->append('Im just an example !');
		// change stack of result object
		return $self->find('div');
	}
	protected static function helperFunction() {
		// this method WONT be avaible as haoxinqing_me_cj method,
		// because it isn't publicly callable
	}
}

/**
 * haoxinqing_me_cj plugin class extending haoxinqing_me_cj static namespace.
 * Methods from this class are callable as follows:
 * haoxinqing_me_cj::$plugins->staticMethod()
 *
 * Class name prefix 'haoxinqing_me_cjPlugin_' must be preserved.
 */
abstract class haoxinqing_me_cjPlugin_example {
	/**
	 * Limit binded methods.
	 *
	 * null means all public.
	 * array means only specified ones.
	 *
	 * @var array|null
	 */
	public static $haoxinqing_me_cjMethods = null;
	public static function staticMethod() {
		// this method can be called within haoxinqing_me_cj class namespace, like this:
		// haoxinqing_me_cj::$plugins->staticMethod()
	}
}
?>