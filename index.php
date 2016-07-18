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

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Jaybizzle\CrawlerDetect\Fixtures\Crawlers;

// start the session
session_start();

// load config...
Config::load('./config.php');

// custom config file to be written to by a bash script or something
Config::load('./custom_config.php');

$CrawlerDetect = new CrawlerDetect();

if(!function_exists('curl_version')){
	die("cURL extension is not loaded!");
}

function save_request($response) {

	log::info( "save_request" . var_export($response, true) );

	try {
        	// Create connection
        	$conn = new mysqli('127.0.0.1', 'onion_stats', 'st1Nky0n1onS', 'onion_stats');

        	// Check connection
        	if ($conn->connect_error) {
                	throw new Exception("Connection failed: " . $conn->connect_error);
        	}

        	$request = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['SERVER_PROTOCOL'];
        	$request = substr($request, 0, 255);

	        $sql = "INSERT INTO requests (source, request, ua, response_code, hostname, referer) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "', '" . $request . "', '" . $_SERVER['HTTP_USER_AGENT'] . "', '" . $response . "', '" . $_SERVER['SERVER_NAME'] . "', '" . substr($_SERVER['HTTP_REFERER'], 0, 255) . "')";

		log::info( $sql );

        	if ($conn->query($sql) !== TRUE) {
                	throw new Exception("Error: " . $sql . "<br>" . $conn->error);
        	}

        	$conn->close();
	} catch(Exception $ex) {
        	log::info("Exception: " . $ex->getMessage() . ' -- ' . $ex->getFile() . ' : ' . $ex->getLine());
	}
}

// very important!!! otherwise requests are queued while waiting for session file to be unlocked
session_write_close();


$links = array(
	'Onion Dir' => '//auutwvpt25zfyncd.' . Config::get('base_host'),
	'LINKZ Onion Directory' => '//linkzbyg4nwodgic.' . Config::get('base_host'),
	'Hidden Wiki' => '//zqktlwi4fecvo6ri.' . Config::get('base_host'),
	'DeepDotWeb' => '//deepdot35wvmeyd5.' . Config::get('base_host'),
	'Cryptome on Tor' => '//h2am5w5ufhvdifrs.' . Config::get('base_host')
);

if( $_SERVER['HTTP_HOST'] == Config::get('base_host') || $_SERVER['HTTP_HOST'] == 'www.'.Config::get('base_host') ) {

	switch( $_SERVER['REQUEST_URI'] ) {
		case (preg_match('/^\/banlist/', $_SERVER['REQUEST_URI']) ? true : false) :
			$data = file_get_contents(Config::get('banlist_path'));
			die( $data );
        	break;
		default:
			if( $_POST['url'] ) {
				$url = $_POST['url'];
        		if( !preg_match('/http(s?):\/\//i', $url) ) {
            		$url = 'http://' . $_POST['url'];
        		}
        		$proxified_url = proxify_url($url, $url);
        		header("HTTP/1.1 302 Found");
                header("Location: " . $proxified_url);
			} else {
				echo render_template("./templates/main.php", array('version' => Proxy::VERSION, 'links' => $links));
			}
	}

	exit;
}

// Disclaimer
if( !$_COOKIE["disclaimer_accepted"] && !$CrawlerDetect->isCrawler() ) {
//if( !$_COOKIE["disclaimer_accepted"] ) {
        echo render_template("./templates/disclaimer.php", array());
	exit;
}

$request_host = preg_replace('/.' . Config::get('base_host') . '/i', '', $_SERVER['HTTP_HOST']);

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

$response = null;

try {

	// request sent to index.php
	$request = Request::createFromGlobals();

	// remove all GET parameters such as ?q=
	$request->get->clear();

	// forward it to some other URL
	global $response;
	$response = $proxy->forward($request, $url);

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
		log::warning( var_export($response, true) );
		log::warning('Exception: ' . $ex->getMessage());
		//save_request(  $response->getStatusCode() );
		echo render_template("./templates/main.php", array(
			'url' => $url,
			'error_msg' => $ex->getMessage(),
			'version' => Proxy::VERSION
		));
	}

	//save_request(  $response->getStatusCode() );
}

save_request(  $response->getStatusCode() );

?>
