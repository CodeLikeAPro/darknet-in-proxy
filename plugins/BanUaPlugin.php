<?php

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;
use Proxy\Config;
use Proxy\Proxy;
use Phasty\Log\File as log;

Config::load('../config.php');

class BanUaPlugin extends AbstractPlugin {

	public function onBeforeRequest(ProxyEvent $event){
        // fired right before a request is being sent to a proxy
		$ban_ua_list = file( Config::get('ua_banlist_path'), FILE_IGNORE_NEW_LINES );

		$ua  = strtolower($event['request']->headers->get('user-agent'));

		foreach($ban_ua_list as $bad_ua) {
			if( preg_match("/" . strtolower($bad_ua)  . "/i", $ua) ) {
				throw new \Exception("Banned.");
			}
		}
	}
}

?>
