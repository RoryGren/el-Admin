<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
//		include_once "includes/bubble/top.php";
		include "config.php";
		include INC;
		include_once "classes/classAdmin.php";
		$Admin = new classAdmin();
//		echo "<br>LearnerInsert.php<br>";
//		print_r($_REQUEST);
//		print_r($_POST);
//		echo "<br><br>";
//Array ( [UserName] => sally@green.com [FName] => Sally [SName] => Green [Email] => sally@green.com [CompanyId] => 79
		
		$NewLearner = array ('UserName' => $_POST['UserName'], 'FName' => $_POST['FName'], 'SName' => $_POST['SName'], 'SAIDNo' => $_POST['SAIDNo'], 'Email' => $_POST['Email'], 'CompanyId' => $_POST['CompanyId'], 'CourseId' => $_POST['CourseId']);
//		var_dump($NewLearner);
		$Admin->addNewLearner($NewLearner);
?>



<?php
	}
	else {
		header('location: index.php');
	}
?>
