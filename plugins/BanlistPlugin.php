<?php

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;
use Proxy\Config;
use Proxy\Proxy;
use Phasty\Log\File as log;

Config::load('../config.php');

class BanlistPlugin extends AbstractPlugin {

	public function onBeforeRequest(ProxyEvent $event){
                // fired right before a request is being sent to a proxy
		$request_url = $event['request']->getUri();

		$host = parse_url($request_url, PHP_URL_HOST);
		//log::notice($host);

		$ban_list = file( Config::get('banlist_path'), FILE_IGNORE_NEW_LINES );

		$host_md5 	= md5( $host );
		$url_md5 	= md5( $request_url );

		if( in_array($host_md5, $ban_list) || in_array($url_md5, $ban_list) ) {
			throw new \Exception("This domain or url is banned.");
		}
        }

}

?>
