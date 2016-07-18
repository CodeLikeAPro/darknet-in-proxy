<!DOCTYPE html>
<html>
<head>

<title>Darknet TOR and I2P In Proxy</title>

<link href="//www.hiddenservice.net/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container">

	<div class="jumbotron" style="margin-top: 20%;">
        <p><b>hiddenservice.net does not host this content</b>; the service is simply a
    		proxy connecting Internet users to content hosted inside the
    		<a target="_blank" href="https://www.torproject.org/docs/hidden-services.html.en">Tor</a>
    		or <a target="_blank" href="https://geti2p.net/en/">I2P</a> network.
		</p>

		<p>
			Please be aware that when you access this site through an in-proxy service (like hiddenservice.net)
    		you are not anonymous. To obtain anonymity, you are strongly advised to download either
    		the <a target="_blank" href="https://www.torproject.org/download/">Tor Browser Bundle (for .onion addresses)</a>
			or <a target="_blank" href="https://geti2p.net/en/">I2P (for .i2p addresses)</a>
    		and access this content over Tor.
		</p>

		<p>
          <a class="btn btn-lg btn-primary"" role="button"
			onClick="document.cookie = 'disclaimer_accepted=1; domain=.<?php echo $base_host; ?>; expires=Thu, 18 Dec 2020 12:00:00 UTC; path=/'; location.reload();" >Continue</a>
        </p>
	</div>
</div>


</body>
</html>
