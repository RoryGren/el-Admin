<?php
	if (!isset($_SESSION)) {session_start();}
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
//		include_once "includes/bubble/top.php";
		include_once "config.php";
		include_once INC;
		include_once "classes/classAdmin.php";
		$Admin = new classAdmin();
		$CompanyList = $Admin->getCompanyList();
		$CourseList  = $Admin->getCourseList();
		include_once "classes/classDisplay.php";
		$Display = new classDisplay();
//		$selCompany = $Display->selectOptions($CompanyList, 'All');
//		print_r($CompanyList);
//		print_r($CourseList);
		$options = '';
?>
<script type='text/javascript'>
	$(document).ready(function () {
		$('#Email').focus();
	});
		
    /* attach a submit handler to the form */
    $("#newLearner").submit(function(event) {
		
		/* stop form from submitting normally */
		event.preventDefault();
		$("#btnSubmit").attr('disabled', 'disabled');

		$('#rightHalf').html('');
		
		if (
			(!checkExists('UserName', $('#Email').val()) == 1) && 
			(!checkExists('SAIDNo', $('#SAIDNo').val())  == 1)
			) {

			$.ajax({
				url: 'learnerInsert.php',
				data:{
					'UserName': $('#Email').val(), 
					'pwd':		$('#pwd').val(), 
					'FName':	$("#FName").val(), 
					'SName':	$("#SName").val(), 
					'SAIDNo':	$("#SAIDNo").val(), 
					'Email':	$("#Email").val(), 
					'CompanyId':$("#CompanyId").val(), 
					'CourseId':	$("#CourseId").val()
				},
				type: 'POST',

				success: function(data){
					$('#rightHalf').append(data);
					$('#newLearner').trigger("reset");
				}
			});
		}
		else {
			alert("There is already a record in the database with the email address "+$("#Email").val());
			$("#Email").select();
		}

    });
</script>
<div class="row">
	<div class="col col-md-6">
		<h4>Create New Learner</h4>
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
	</div>
	<div class="col col-md-6" id="rightHalf"><br></div>
</div>
<?php
	}
	else {
		header('location: index.php');
	}
?>
