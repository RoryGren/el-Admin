<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
//		include_once "includes/bubble/top.php";
		include_once "config.php";
		include_once 'classes/classAdmin.php';
		$Admin = new classAdmin();
//		$LearnerList = $Admin->getLearnerList();
		$CourseList  = $Admin->getCourseList();
//		print_r($CourseList);
		include_once 'classes/classDisplay.php';
		$Display = new classDisplay();
		$Display->setPrettyHeaders($Admin->getPrettyHeaders());
?>
<script>
	$(document).ready(function () {
		setActive('#menu-Courses');
		var title    = $('#modal-title');
		var btnRed   = $('#btnRed');
		var btnGreen = $('#btnGreen');
//		var btnWhite = $('#btnWhite');
		title.html('Edit Course');
		btnGreen.removeClass('hidden');
		btnGreen.html('Update');
		btnRed.removeClass('hidden');
		btnRed.html('Un-publish');
	});
</script>

<div class="panel filterable col col-lg-3">
	<div class="panel-heading">
		<h4 class="panel-title">Course List</h4>
		<div class="padded-top">
			<button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		</div>
	</div>
	<?php
		$Display->tableHeader($CourseList);
		$Display->tableBody($CourseList, 'ce');
	?>
</div>
<div class="col col-lg-9"></div>
<?php
	}
	else {
		header('location: index.php');
	}
?>
