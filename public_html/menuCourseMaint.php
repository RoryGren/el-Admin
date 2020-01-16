<?php
	session_start();
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include "includes/bubble/top.php";
?>
    <body>
		<script>
			$(document).ready(function () {
				setActive('#menu-Courses');
			});
		</script>
		<?php
		include 'topNavBar.php';
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col col-sm-2">
					<h4 class="text-center">Courses</h4>
					<button id="btnCourseList" class="btn btn-block dark-theme active" onclick="showFile('courseList', this.id);">Edit Existing</button>
					<button id="btnCourseMod" class="btn btn-block dark-theme" onclick="showFile('courseMod', this.id);">Modify Existing</button>
					<button id="btnCourseNew" class="btn btn-block dark-theme" onclick="showFile('courseNew', this.id);">Create New</button>
				</div>
				<div class="col col-sm-8" id="working">
					<?php include 'courseList.php'; ?>
					
				</div>
				<div class="col col-sm-2" id="rightCol"></div>
			</div>
		</div>
		<?php include 'includes/modal.php'; ?>
    </body>
</html>
<?php
	}
	else {
		header('location: index.php');
	}
?>
