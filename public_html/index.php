<?php
	ob_start();
	session_start();
	if (count($_REQUEST) > 1 && $_REQUEST['Login'] === 'HelloAdmin') {
		include "config.php";
		include 'modules/userControl/classLogin.php';
		$Today = gmdate("Y-m-d H:i:s", strtotime(" + 2 hours"));
		$Login = new classLogin($_REQUEST['userName'], $_REQUEST['pwd'], $Today);
		if ($Login->userExists()) {
			$_SESSION['LoggedIn'] = 'YouAreLoggedInToTheAdminModuleNow';
			$_SESSION['LogInStart'] = $Today;
			$_SESSION['LoggedInToken'] = 'New';
			$_SESSION['UserId'] = 'New';
//			$_SESSION['UserName'] = $Login->getUserName();
			header('location: adminDash.php');
		}
		else {
			session_destroy();
//			header('location: index.php');
		}
	}
	else {
		session_destroy()
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="all" >
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all" >
		
		<link rel="stylesheet" type="text/css" href="style/e-AdminStyle.min.css"/>

		<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://use.fontawesome.com/6f7c9f8c3d.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="resources/scripts/dashScripts.min.js" type="text/javascript"></script>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
        <title>II e-Learning Admin Login</title>
    </head>
    <body>
		<nav class="navbar navbar-inverse" id="topMenu">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navBar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
					<a class="navbar-brand" href="#">ii-eLearning Admin Login</a>
				</div>
				<div class="collapse navbar-collapse" id="navBar">
					<ul class="nav navbar-nav navbar-right">
						<li id="menu-Logout" class="navbar-right" onclick="">
							<a href="#">&nbsp;&nbsp; </a></li>
						<li id="menu-SignedIn" class="navbar-right">
							<h4 class="SignedIn" id="SignedIn"><span class="glyphicon glyphicon-user"></span>
								Not signed in
							</h4>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row">
				<div class="col col-md-4 "></div>
				<div class="col col-md-4 text-center"><h3>User Login</h3></div>
				<div class="col col-md-4 leftNav"></div>
			</div>
			<div class="row">
				<div class="col col-md-4 "></div>
				<div class="col col-md-4">
					<form class="form-vertical" method="post">
						<div class="form-group">
							<label for="userName" class="control-label text-left">Name:</label>
							<input type="text" class="form-control" id="userName" name="userName">
						</div>
						<div class="form-group">
							<label for="pwd">Password:</label>
							<input type="password" class="form-control" id="pwd" name="pwd">
						</div>
						<div class="form-group text-center">
							<label></label>
							<button class="btn btn-block dark-theme formButton" id="Login" name="Login" type="submit" value="HelloAdmin">Login</button>
						</div>
					</form>
				</div>
				<div class="col col-lg-4 leftNav"></div>
			</div>
		</div>
    </body>
</html>
<?php
ob_flush();
	}
?>