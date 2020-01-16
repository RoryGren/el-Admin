<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include_once "config.php";
		include_once 'classes/classAdmin.php';
		$Admin = new classAdmin();
		print_r($_SESSION);
		$NewCourse = array ($_POST['Code'], $_POST['Description'], $_SESSION['UserId']);
	
		
		
	}
	else {
		header('location: index.php');
	}
?>
