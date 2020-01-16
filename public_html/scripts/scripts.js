
function setActive(activeButton) {
	$('#navbar').children('li').removeClass('active');
	$(activeButton).addClass('active');
}

function showFile(fileName, btnId) {
	$('#working').empty();
	newFileName = fileName+'.php';
	$('#working').load(newFileName);
	$('#'+btnId).siblings('button').removeClass('active');
	$('#'+btnId).addClass('active');
}

function showModal(recId, sender) {
	var fileName;
	var divMain = $('#detailModal');
	switch(sender) {
		case 'ce':
			fileName = 'courseEdit.php';
			break;
		case 'le':
			fileName = 'learnerDetailDisplay.php'
			break;
		default:
			fileName = 'detailDisplay.php';
	}
//	console.log(sender+' : '+fileName);
	divMain.html('');
	$.ajax({
		url: fileName,
		data:{'recId':recId},
		type: 'POST',

		success: function(data){
			divMain.html(data);
//			$("#modalDiv").modal("show");
		}
	});
}

function logout() {
	alert('Logging Out');
	window.location.href = 'http://admin.inspiredinterfaces.co.za';
}

function addLearner(formId) {
	alert('addLearner - '+formId);
	$('#rightHalf').html('');
	$.ajax({
		url: 'learnerInsert.php',
		data:{
			'UserName': $('#Email').val(), 
			'pwd': $('#pwd').val(), 
			'FName':$("#FName").val(), 
			'SName':$("#SName").val(), 
			'SAIDNo':$("#SAIDNo").val(), 
			'Email':$("#Email").val(), 
			'CompanyId':$("#CompanyId").val(), 
			'CourseId':$("#CourseId").val()},
		type: 'POST',

		success: function(data){
			alert('Posted');
			$('#rightHalf').html(data);
			return true;
		}
	});
}

function addCourse() {
	$('#btnSubmit').prop('disabled', 'disabled');
	$.ajax({
		url: 'courseInsert.php',
		data: {
			Code: $('#Code').val(),
			Description: $('#Description').val()
		},
		type: 'POST',

		success: function(data){
			$('#rightCol').html(data);
		},
		complete: function() {
			$('#btnCourseList').click();
		},
		error: function() {
			alert('There was an error saving your new course...');
			$('#btnCourseNew').click();
		}
	})
}

function checkExists(fieldId, fieldValue) {
//	alert("Checking "+fieldValue);
	$.ajax({
		url: 'checker.php',
		data:{'fieldId':fieldId,'fieldValue':fieldValue},
		type: 'POST',

		success: function(data){
			fullFieldId = "#"+fieldId;
			if (data == 1) {
				alert(fieldValue+" already exists in the database.");
				$('#rightHalf').html("<br><br><p>"+fieldId+" already exists with the value "+fieldValue+"</p>");
				$(fullFieldId).select();
				return true;
			}
			else {
				$('#rightHalf').html('');
//				$('#'+fieldId).addClass('invalidField');
				return false;
			}
		}
	});
	
}

function check_submit(fieldId, fieldValue) {
	if (
		($('#Email').val().length == 0) ||
		($('#FName').val().length == 0) ||
		($('#SName').val().length == 0) ||
		($('#SAIDNo').val().length == 0) ||
		($('#CompanyId').val() === 'zzzz') ||
		($('#CourseId').val() === 'zzzz'))
	{
//		alert('There are still some empty fields: '+fieldId+' - '+$('#'+fieldId).val().length);
		$("#btnSubmit").attr("disabled", true);
	}
	else {
		$("#btnSubmit").removeAttr("disabled");
	}
}

