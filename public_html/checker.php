<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
//		include_once "includes/bubble/top.php";
		include "config.php";
		include INC;
		include_once "classes/classAdmin.php";
		$Admin = new classAdmin();
		$options = '';

		$FieldId    = $_REQUEST['fieldId'];
		$FieldValue = $_REQUEST['fieldValue'];
		$SQL = "SELECT count(`UserName`) as 'Recs' FROM `Learner` WHERE UPPER(`$FieldId`) = UPPER('$FieldValue')";
//		echo "<br>$SQL<br>";
		$QRY = $Admin->execSQL($SQL, 'S');
		$NumRecs = $QRY[0]['Recs'];
		if ($NumRecs == 0) {
			$result = 0;
		}
		elseif ($NumRecs > 0) {
			$result = 1;
		}
		echo $result;
	}
?>
