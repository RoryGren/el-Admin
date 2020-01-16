<?php
	session_start();
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include "includes/bubble/top.php";
		$_SESSION['LogInStart'] = $Today;
//		$_SESSION['LoggedInToken'] = 'New';

?>
    <body>
		<script>
			$(document).ready(function () {
				setActive('#menu-Admin');	
			});
		</script>
		<?php
		include 'topNavBar.php';
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col col-lg-2">
					<h4 class="text-center">Profile</h4>
					<button id="btnEdit" class="btn btn-block dark-theme">Edit</button>
					<!--<button id="btnNew" class="btn btn-block dark-theme">Create New</button>-->
				</div>
				<div class="col col-lg-8" id="working">
					<?php include 'profileShow.php'; ?>
					
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


