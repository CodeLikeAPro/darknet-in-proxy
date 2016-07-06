<?php

define('PROXY_START', microtime(true));

require("vendor/autoload.php");

use Proxy\Http\Request;
use Proxy\Http\Response;
use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\FilterEvent;
use Proxy\Config;
use Proxy\Proxy;
use Phasty\Log\File as log;

// start the session
session_start();

// load config...
Config::load('./config.php');

// custom config file to be written to by a bash script or something
Config::load('./custom_config.php');

if(!Config::get('app_key')){
	die("app_key inside config.php cannot be empty!");
}

if(!function_exists('curl_version')){
	die("cURL extension is not loaded!");
}

// very important!!! otherwise requests are queued while waiting for session file to be unlocked
session_write_close();

if( $_SERVER['HTTP_HOST'] == Config::get('base_host') || $_SERVER['HTTP_HOST'] == 'www.'.Config::get('base_host') ) {
	// must be at homepage - should we redirect somewhere else?
	if(Config::get('index_redirect')) {
		// redirect to...
		header("HTTP/1.1 302 Found"); 
		header("Location: ".Config::get('index_redirect'));
	} elseif($_POST['url']) {
		$url = $_POST['url'];
		if( !preg_match('/http(s?):\/\//i', $url) ) {
			$url = 'http://' . $_POST['url'];
		}
		$proxified_url = proxify_url($url, $url);
		log::debug('Request from homepage: ' . $url);
		log::debug('Proxified: ' . $proxified_url);
		header("HTTP/1.1 302 Found");
                header("Location: " . $proxified_url);
	} else {
		echo render_template("./templates/main.php", array('version' => Proxy::VERSION));
	}

	exit;
}

// Disclaimer
if( !$_COOKIE["disclaimer_accepted"] ) {
        echo render_template("./templates/disclaimer.php", array());
	exit;
}

$request_host = preg_replace('/.hiddenservice.net/i', '', $_SERVER['HTTP_HOST']);

if( preg_match('/[a-z2-7]{16}/i', $request_host) ) {
	$url = 'http://' . $request_host . '.onion' . $_SERVER['REQUEST_URI'];
} else {
	$url = 'http://' . $request_host . '.i2p' . $_SERVER['REQUEST_URI'];
}


$proxy = new Proxy();

// load plugins
foreach(Config::get('plugins', array()) as $plugin){

	$plugin_class = $plugin.'Plugin';

	if(file_exists('./plugins/'.$plugin_class.'.php')){

		// use user plugin from /plugins/
		require_once('./plugins/'.$plugin_class.'.php');

	} else if(class_exists('\\Proxy\\Plugin\\'.$plugin_class)){

		// does the native plugin from php-proxy package with such name exist?
		$plugin_class = '\\Proxy\\Plugin\\'.$plugin_class;
	}

	// otherwise plugin_class better be loaded already through composer.json and match namespace exactly \\Vendor\\Plugin\\SuperPlugin
	$proxy->getEventDispatcher()->addSubscriber(new $plugin_class());
}

try {

	// request sent to index.php
	$request = Request::createFromGlobals();

	log::notice( $url );
	log::debug( var_export($request->headers, true) );

	// remove all GET parameters such as ?q=
	$request->get->clear();

	// forward it to some other URL
	$response = $proxy->forward($request, $url);

	log::debug( var_export($response->headers, true) );

	// if that was a streaming response, then everything was already sent and script will be killed before it even reaches this line
	$response->send();

} catch (Exception $ex){
	// if the site is on server2.proxy.com then you may wish to redirect it back to proxy.com
	if(Config::get("error_redirect")){
		$url = render_string(Config::get("error_redirect"), array(
			'error_msg' => rawurlencode($ex->getMessage())
		));

		// Cannot modify header information - headers already sent
		header("HTTP/1.1 302 Found");
		header("Location: {$url}");
	} else {
		log::debug($ex->getMessage() . ' -- ' . $ex->getFile() . ' : ' . $ex->getLine());
		echo render_template("./templates/main.php", array(
			'url' => $url,
			'error_msg' => $ex->getMessage(),
			'version' => Proxy::VERSION
		));
	}
}

?>
