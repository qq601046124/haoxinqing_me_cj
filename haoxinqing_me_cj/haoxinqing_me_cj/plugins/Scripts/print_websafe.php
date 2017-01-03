<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * Script makes content safe for printing as web page and not redirecting client.
 *
 * @author Tobiasz Cudnik <tobiasz.cudnik/gmail.com>
 */
/** @var haoxinqing_me_cjObject */
$self = $self;
$self
	->find('script')
		->add('meta[http-equiv=refresh]')
			->add('meta[http-equiv=Refresh]')
				->remove();