<?php

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;

class SetHeadersPlugin extends AbstractPlugin {

	public function onBeforeRequest(ProxyEvent $event){
		$event['request']->headers->set('X-Forwarded-Server', 'hiddenservice.net');
	}

	 public function onCompleted(ProxyEvent $event){
		$event['response']->headers->set('x-robots-tag', 'noindex');
	}
}

?>
