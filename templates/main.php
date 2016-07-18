<!DOCTYPE html>
<html>
<head>

<title>Darknet TOR and I2P In Proxy</title>

<meta name="globalsign-domain-verification" content="tM9wnDjDl5-GoorNGlJ6ttTLJkLqimRRYxcPnk4KqG" /> 
<meta name="msvalidate.01" content="36F5E6A7A593038359F3D1346F1F732D" />
<meta name="yandex-verification" content="47b723592fd12aa8" />
<meta name="description" content="Tor and I2P in proxy. Just like tor2web, access .onion and .i2p domains without running Tor or I2P." />
<link href="//www.hiddenservice.net/css/bootstrap.min.css" rel="stylesheet">

<style>
.bubble-content {
	text-align: center;
}
</style>

</head>

<body>


<div class="container">

	<div class="jumbotron" style="margin-top: 15%;">

		<?php if(isset($error_msg)){ ?>
		<div id="error">
			<p><?php echo $error_msg; ?></p>
		</div>
		<?php } ?>

		<div style="text-align: center;">

			<form action="//www.hiddenservice.net/index.php" method="post" style="margin-bottom:0;">
				<input name="url" type="text" style="width:400px;" autocomplete="off" placeholder="http://" />
				<input type="submit" value="Go" />
			</form>

			<script type="text/javascript">
				document.getElementsByName("url")[0].focus();
			</script>
		</div>

	</div>



	<div class="row" style="margin-top: 8%">
		<div class="col-md-4 bubble-content">
			<h3>Access Tor and I2P hidden services</h3>
			<br /><br />
			Hiddenservice.net lets you access both <a alt="Tor Project: Anonymity Online" href="https://www.torproject.org/">Tor</a> and <a alt="I2P Anonymous Privacy Network" href="https://geti2p.net/">I2P</a>
			hidden services from your browser. Just replace .onion or .i2p with .hiddenservice.net
		</div>
		<div class="col-md-4 bubble-content">
			<h3>Having issues?</h3>
			<br /><br />
			Find something thats not working right? Contact <a href="mailto:dev@hiddenservice.net">dev@hiddenservice.net</a>
		</div>
		<div class="col-md-4 bubble-content">
			<h3>Abuse?</h3>
			<br /><br />
			Hiddenservice.net does NOT host any content and is not responsible for anything you might
			find on the Tor or I2P networks. However, we do out best to block access to anythign illegal. If you can access
			something through this service you feel should be blocked, please contact <a href="mailto:abuse@hiddenservice.net">abuse@hiddenservice.net</a>
		</div>
	</div>



	<div class="panel panel-default" style="margin-top: 50px;">
  		<div class="panel-body" style="text-align: center;">
    		<?php
				$links = array(
					'Onion Dir' => 'https://auutwvpt25zfyncd.hiddenservice.net',
					'LINKZ Onion Directory' => 'https://linkzbyg4nwodgic.hiddenservice.net/',
					'Hidden Wiki' => 'https://zqktlwi4fecvo6ri.hiddenservice.net/wiki/index.php/Main_Page',
					'DeepDotWeb' => 'https://deepdot35wvmeyd5.hiddenservice.net/',
					'Cryptome on Tor' => 'https://h2am5w5ufhvdifrs.hiddenservice.net/'
				);
				$shuffled_array = array();

				$keys = array_keys($links);
				shuffle($keys);

				foreach ($keys as $key) {
					$shuffled_array[$key] = $links[$key];
				}

				$count = 0;
				foreach($shuffled_array as $lk => $lv) {
					if($count < 2) {
						echo '<a href="' . $lv . '">' . $lk . '</a> &nbsp; &nbsp; | &nbsp; &nbsp; ';
					} else {
						echo ' <a href="' . $lv . '">' . $lk . '</a>';
						break;
					}
					$count++;
				}
			?>
  		</div>
	</div>



</div>

<?php if( !isset($error_msg) ): ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-80542395-1', 'auto');
  ga('send', 'pageview');

</script>

<?php endif; ?>


</body>
</html>
