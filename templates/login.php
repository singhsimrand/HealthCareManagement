<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Log In</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo $BASE_URL; ?>/packages/font-awesome/css/font-awesome.min.css" />
		<link href="<?php echo $BASE_URL; ?>/packages/bootstrap-3.0.0/dist/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<style>
		body {
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #eee;
		}

		.form-signin {
		  max-width: 330px;
		  padding: 15px;
		  margin: 0 auto;
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
		  margin-bottom: 10px;
		}
		.form-signin .checkbox {
		  font-weight: normal;
		}
		.form-signin .form-control {
		  position: relative;
		  font-size: 16px;
		  height: auto;
		  padding: 10px;
		  -webkit-box-sizing: border-box;
		     -moz-box-sizing: border-box;
		          box-sizing: border-box;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		.form-signin input[type="text"] {
		  margin-bottom: -1px;
		  border-bottom-left-radius: 0;
		  border-bottom-right-radius: 0;
		}
		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}
		</style>
	</head>
	<body>
		<div class="container">
			<form class="form-signin" method="post" action="<?php echo $BASE_URL; ?>/login">
				<h2 class="form-signin-heading">Please sign in</h2>
				<input type="text" name="email" class="form-control" placeholder="Email address" autofocus />
				<input type="password" name="password" class="form-control" placeholder="Password" />
				<input type="hidden" name="action" value="<?php echo $ACTION; ?>" />
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			</form>
		</div>
	</body>
</html>
