<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include_once "includes/bubble/top.php";
		include_once 'classes/classAdmin.php';
		$Admin = new classAdmin();
		$LearnerList = $Admin->getLearnerList();
		include_once 'classes/classDisplay.php';
		$Display = new classDisplay();
		$Display->setPrettyHeaders($Admin->getPrettyHeaders());
?>
<script>
//	$(document).ready(function () {
//		sessionStorage.clear('selectedLearner');
//		$('#btnRed').on('click', function(){alert('Delete');});
//		$('#btnGreen').on('click', function(){alert('Update');});
//	})
</script>
<div class="panel filterable">
	<div class="panel-heading">
		<h4 class="panel-title">Learner List</h4>
		<div>
			<button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		</div>
	</div>
	<?php
		$Display->tableHeader($LearnerList);
		$Display->tableBody($LearnerList, 'le');
	?>
</div>
<?php
	}
	else {
		header('location: index.php');
	}
?>
