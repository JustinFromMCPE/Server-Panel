<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="A simple, yet non-minimalistic Minecraft server control panel.">
    <meta name="author" content="Cole &quot;Rocket_Scientist&quot; Crouter">
    <link rel="icon" href="../../favicon.ico">

    <title>Server Control Panel</title>
	
	<!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
	<link href="custom.css" rel="stylesheet">
	
</head>
<body style="background:linear-gradient(#5B5B5B 0%, #2B2B2B 100%); background-attachment:fixed;">
	<img src="../wallpaper.png" style="background-attachment:fixed; background-size: cover; position: absolute">
		<div class="card login col-sm-8 col-sm-offset-2">
			<form id="login" class="col-sm-9 col-sm-offset-3" action="login.php" method="post">
				<h4>Username:</h4>
				<input name="username" class="form-control">
				<br>
				<h4>Password:</h4>
				<input name="password" class="form-control" type="password">
				<h6 style="padding-top: 10px">Forgot your password?</h6>
				<input type="submit" class="btn btn-block btn-success" style="margin-top: 60px; margin-bottom: 20px;" value="Log In">
			</form>
			  <script>
    function LogIn() {
		form = document.getElementById("login");
      	jQuery.post('login.php', jQuery(form).serialize(), function(data) {
        	jQuery('#login').html(data);
      });
    }
  </script>
		</div>
</body>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
</html>