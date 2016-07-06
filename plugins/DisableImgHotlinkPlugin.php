<?php

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;

use Phasty\Log\File as log;

class DisableImgHotlinkPlugin extends AbstractPlugin {

	public function onHeadersReceived(ProxyEvent $event){
                // fired right after response headers have been fully received - last chance to modify before sending it$
		//$referer 	= $event['request']->headers->get('referer');
		$referer = $_SERVER['HTTP_REFERER'];
		$content_type	= $event['response']->headers->get('content-type');

		//log::notice('Referer: ' . $referer);
		//log::notice('Content-type: ' . $content_type);
		//log::notice('CT: ' . $_SERVER['HTTP_REFERER']);

		if( strlen($referer) == 0 || !preg_match('/.hiddenservice.net/', $referer) ) {
			if( preg_match('/image/', $content_type) ) {
				log::notice('Image hot link prevented: '. $event['request']->getUri());
				throw new \Exception("Hotlinking of images is prohibited.");
			}
		}
        }
}

?>
