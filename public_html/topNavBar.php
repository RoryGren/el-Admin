<?php
//if (!isset($_SESSION)) {session_start();}
//	print_r($learnerProfileData);
?>
			<nav class="navbar navbar-inverse" id="topMenu">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navBar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span> 
						</button>
						<a class="navbar-brand" href="adminDash.php">ii-eLearning Admin Dashboard</a>
					</div>
					<div class="collapse navbar-collapse" id="navBar">
						<ul class="nav navbar-nav" id="navbar">
							<li id="menu-Learners" class=" dropdown">
								<a href="#"><span class="glyphicon glyphicon-user"></span> Learners <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu" id="menu-UserTasks">
									<li><a href="menuLearnerMaint.php">Maintenance</a></li>
									<li><a href="learnerRep">Learner Reporting</a></li>
								</ul>
							</li>
							<li id="menu-Courses" class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-list-alt"></span> Courses <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu" id="menu-UserTasks">
									<li><a href="menuCourseMaint.php">Maintenance</a></li>
									<li><a href="courseRep">Reporting</a></li>
								</ul>
							</li>
							<li id="menu-Admin" class=" dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> Admin <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu" id="menu-UserTasks">
									<li><a href="menuProfileMaint.php">Personal Profile</a></li>
									<li><a href="menuAdminMaint.php">Maintenance</a></li>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li id="menu-Logout" class="navbar-right" onclick="logout();">
								<a href="#">&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
							<li id="menu-SignedIn" class="navbar-right">
								<h4 class="SignedIn" id="SignedIn"><span class="glyphicon glyphicon-user"></span>
									Signed in as <?php echo $_SESSION['UserName']; ?>
								</h4>
							</li>
						</ul>
					</div>
				</div>
			</nav>
