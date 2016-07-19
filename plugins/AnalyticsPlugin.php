<?php

use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\ProxyEvent;

class AnalyticsPlugin extends AbstractPlugin {

	public function onCompleted(ProxyEvent $event){

		$request = $event['request'];
		$response = $event['response'];

		//$url = $request->getUri();

		// we attach url_form only if this is a html response
		if(!is_html($response->headers->get('content-type'))){
			return;
		}

		$output = $response->getContent();

		$analytics_code = render_template("./templates/analytics.php", array());

		// does the html page contain <body> tag, if so insert our form right after <body> tag starts
		$output = preg_replace('@</body.*?>@is', '$0'.PHP_EOL.$analytics_code, $output, 1, $count);

		// <body> tag was not found, just put the form at the top of the page
		if($count == 0){
			$output = $output.$analytics_code;
		}
		
		$response->setContent($output);
	}
}

?>
