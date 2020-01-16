<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include_once 'config.php';
		$RowId = $_POST['recId'];
		include_once 'classes/classLearner.php';
		$Learner = new classLearner();
		$Data = $Learner->getLearnerDetail($RowId);
		$CompanyList = $Learner->getCompanyList();
		$CourseList  = $Learner->getCourseList();
		include_once "classes/classDisplay.php";
		$Display = new classDisplay();
//		print_r($Data);
//		Array ( [LearnerId] => 8 [UserName] => sally@mander.com [Email] => sally@mander.com [FName] => Sally [SName] => Mander [SAIDNo] => 2345234523455 [CompanyId] => 79 [LearnerStatus] => 1 [LastLogin] => [CreateUser] => 1 [CreateDate] => 2018-01-15 11:15:40 [ModUser] => 1 [ModDate] => 2018-01-15 11:15:40 )
?>
<script>
	$(document).ready(function () {

		sessionStorage.setItem('selectedLearner','<?php echo $Data['LearnerId']; ?>');
		$('#modal-title').text('Edit Learner - <?php echo $Data['FName'] . " " . $Data['SName'] ?>');
		var btnRed   = $('#btnRed');
		var btnGreen = $('#btnGreen');
		btnRed.removeClass('hidden');
		btnRed.html('Disable');
		btnGreen.removeClass('hidden');
		btnGreen.html('Save');
		$('#btnRed').on('click', function(){alert('Delete Now!');});
		$('#btnGreen').on('click', function(){alert('Update');});
	});
</script>
<form id="learnerDetail">
	<div class="form-group"><span class='btn-danger hidden' id="EmailExists"></span>
		<label for="UserName">UserName:</label>
		<input type="text"  class="form-control" id="UserName" required value="<?php echo $Data['UserName']; ?>" onchange="check_submit(this.id, this.value); checkExists(this.id, this.value);">
	</div>
	<div class="form-group">
		<label for="FName">First Name:</label>
		<input type="text" class="form-control" id="FName" required value="<?php echo $Data['FName']; ?>" onchange="check_submit(this.id, this.value); checkExists('Email', $('#Email').val());">
	</div>
	<div class="form-group">
		<label for="SName">Surname:</label>
		<input type="text" class="form-control" id="SName" required value="<?php echo $Data['SName']; ?>" onchange="check_submit(this.id, this.value);">
	</div>
	<div class="form-group">
		<label for="SAIDNo">SA Identity Number:</label>
		<input type="text" class="form-control" id="SAIDNo" required value="<?php echo $Data['SAIDNo']; ?>" onchange="check_submit(this.id, this.value); checkExists(this.id, this.value);">
	</div>
	<div class="form-group"><span class='btn-danger hidden' id="EmailExists"></span>
		<label for="Email">Email address:</label>
		<input type="email"  class="form-control" id="Email" required value="<?php echo $Data['Email']; ?>" onchange="check_submit(this.id, this.value); checkExists(this.id, this.value);">
	</div>
	<div class="form-group">
		<label for="CompanyId">Company:</label>
		<select class="form-control" id='CompanyId' onchange="check_submit(this.id, this.value);">
			<!--<option value="zzzz">===== Select =====</option>-->
		<?php 
//					echo $selCompany;
			$Display->selectOptions($CompanyList, $Data['CompanyId']);
		?>
		</select>
	</div>
	<div class="form-group">
		<table id="Courses" class="table">
			<thead><tr><th>Registered Courses</th><th>Reg Date</th></tr></thead>
			<tbody>
		<?php 
			$LearnerCourses = $Learner->getLearnerCourses();
			foreach ($LearnerCourses as $CourseId => $CourseData) {
//				Array ( [LearnerId] => 2 [CourseId] => 1 [Description] => PowerOffice Projects [RegDate] => 2017-10-26 07:29:55 [StartDate] => ) 
				echo "<tr>";
				echo "<td>";
				echo $CourseData['Description'];
				echo "</td>"; //col-sm-8
				echo "<td>";
				echo "Reg: " . substr($CourseData['RegDate'], 0, 10);
				echo "</td>"; // col-sm-4
				echo "</tr>"; // row
			}
		?>
			</tbody>
		</table>
	</div>
</form>

<?php
	}
	else {
		header('location: index.php');
	}
?>
