<!DOCTYPE html>
<html>
<head>

<title>Darknet TOR and I2P In Proxy</title>

<meta name="globalsign-domain-verification" content="tM9wnDjDl5-GoorNGlJ6ttTLJkLqimRRYxcPnk4KqG" /> 
<link href="//www.hiddenservice.net/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>


<div class="container">

	<div class="jumbotron" style="margin-top: 20%;">


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

</div>


</body>
</html>
