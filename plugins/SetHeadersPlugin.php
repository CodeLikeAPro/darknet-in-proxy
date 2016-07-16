<?php

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;

class SetHeadersPlugin extends AbstractPlugin {

	public function onBeforeRequest(ProxyEvent $event){
		$event['request']->headers->set('X-Forwarded-Server', 'hiddenservice.net');
		$event['request']->headers->set('X-tor2web', '1');
	}

	 public function onCompleted(ProxyEvent $event){
		//$event['response']->headers->set('x-robots-tag', 'noindex');
	}
}

?>
