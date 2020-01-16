<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include_once "config.php";
		include_once 'classes/classAdmin.php';
		$Admin = new classAdmin();
?>
<script>
	$(document).ready(function () {
		$("#newCourse").submit(function(event) {
		/* stop form from submitting normally */
			event.preventDefault();
		});
		$('#rightCol').html('');
	});

</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-4">
			<h4>Create New Course</h4>
			<form id="newCourse" method="post">
				<div class="form-group">
					<label for="Code">Course Number:</label>
					<input type="text" class="form-control" id="Code" required>
				</div>
				<div class="form-group">
					<label for="Description">Course Name:</label>
					<input type="text" class="form-control" id="Description" required>
				</div>
				<button class="btn btn-success" id="btnSubmit" onclick="addCourse();">Submit</button>
				<button class="btn btn-danger" id="btnCancel"  onclick="$('#btnCourseList').click();">Cancel</button>
			</form>
			<div class="container-fluid" id="divResult"></div>
		</div>
		<div class="col-lg-6"></div>
	</div>
</div>





<?php
	}
	else {
		header('location: index.php');
	}
?>

