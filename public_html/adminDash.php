<?php
	session_start();
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		
		include "includes/bubble/top.php";
		include_once "classes/classAdmin.php";
		$Admin = new classAdmin();
		$_SESSION['LogInStart'] = $Today;
		$_SESSION['UserName'] = $Admin->getUserName();
		$_SESSION['LoggedInToken'] = 'New';
?>
    <body>
		<?php
			include 'topNavBar.php';
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col col-lg-2">
					<h4 class="text-center">Quick Menu</h4>
<!--					<button id="btnLearnerEdit" class="btn btn-block dark-theme" onclick="showFile(adminEdit, this.id)">Edit Existing Learners</button>
					<button id="btnLearnerNew" class="btn btn-block dark-theme" onclick="showFile(adminNew, this.id)">Create New Learner</button>-->
				</div>
				<div class="col col-lg-8" id="working">
					<h4>Admin Dash</h4>
				</div>
				<div class="col col-lg-2"></div>
			</div>
		</div>
    </body>
</html>
<?php
	}
	else {
		header('location: index.php');
	}
?>
