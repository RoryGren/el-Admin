<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include_once "config.php";
		include_once 'classes/classAdmin.php';
		include_once 'classes/classDisplay.php';
		$courseId	= $_POST['recId'];
		$Admin		= new classAdmin();
		$courseList = $Admin->getCourseList();
		$Display    = new classDisplay();
		$Display->recordEdit($courseList[$courseId]);
	}
	else {
		header('location: index.php');
	}
?>
