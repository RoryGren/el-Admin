<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
// TODO =====> Add Companies <=====
// TODO =====> When new company added, must be selected automatically in CompanyId <=====
?>
<h4>Add a New Company</h4>
<p>On its way....</p>
<form id="newLearner" action="learnerInsert.php" method="post">
	<div class="form-group"><span class='btn-danger hidden' id="EmailExists"></span>
		<label for="Email">Email address:</label>
		<input type="email"  class="form-control" id="Email" required placeholder="This will become the learner's login name" onchange="check_submit(this.id, this.value); checkExists(this.id, this.value);">
		<input type="hidden" class="form-control" id="UserName">
		<span class='btn-danger text-small'> Default password is the First Name. Learner will be prompted to change on first login. </span>
	</div>
	<div class="form-group">
		<label for="FName">First Name:</label>
		<input type="text" class="form-control" id="FName" required onchange="check_submit(this.id, this.value); checkExists('Email', $('#Email').val());">
	</div>
	<div class="form-group">
		<label for="SName">Surname:</label>
		<input type="text" class="form-control" id="SName" required onchange="check_submit(this.id, this.value);">
	</div>
	<div class="form-group">
		<label for="SAIDNo">SA Identity Number:</label>
		<input type="text" class="form-control" id="SAIDNo" required onchange="check_submit(this.id, this.value); checkExists(this.id, this.value);">
	</div>
	<div class="form-group">
		<label for="CompanyId">Company:</label>
		<select class="form-control" id='CompanyId' onchange="check_submit(this.id, this.value);">
			<!--<option value="zzzz">===== Select =====</option>-->
		<?php 
//					echo $selCompany;
			$Display->selectOptions($CompanyList, 'All');
		?>
		</select>
	</div>
	<div class="form-group">
		<label for="CourseId">Course:</label>
		<select class="form-control" id='CourseId' onchange="check_submit(this.id, this.value);">
			<!--<option value="zzzz">===== Select =====</option>-->
		<?php 
			$Display->selectOptions($CourseList, 'All');
		?>
		</select>
	</div>
	<button type="submit" class="btn btn-danger btn-block" id="btnSubmit" disabled>Submit</button>
	<button type="button" class="btn dark-theme btn-block" id="btnNewCompany" onclick="$('#rightHalf').load('companyNew.php')">Add New Company</button>
</form>


<button class="btn btn-block btn-danger" id="btnCompanyCancel" onclick="$('#rightHalf').html('');">Cancel</button>
<?php
	}
	else {
		header('location: index.php');
	}
?>
