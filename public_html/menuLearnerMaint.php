<?php
	session_start();
	if ($_SESSION['LoggedIn'] === 'YouAreLoggedInToTheAdminModuleNow') {
		include "includes/bubble/top.php";
?>
    <body>
		<script>
			$(document).ready(function () {
				setActive('#menu-Learners');
				sessionStorage.clear('selectedLearner');

				$('.filterable .btn-filter').click(function(){
					var $panel = $(this).parents('.filterable'),
					$filters = $panel.find('.filters input'),
					$tbody = $panel.find('.table tbody');
					if ($filters.prop('disabled') == true) {
						$filters.prop('disabled', false);
						$filters.first().focus();
					} else {
						$filters.val('').prop('disabled', true);
						$tbody.find('.no-result').remove();
						$tbody.find('tr').show();
					}
				});

				$('.filterable .filters input').keyup(function(e){
					/* Ignore tab key */
					var code = e.keyCode || e.which;
					if (code == '9') return;
					/* Useful DOM data and selectors */
					var $input = $(this),
					inputContent = $input.val().toLowerCase(),
					$panel = $input.parents('.filterable'),
					column = $panel.find('.filters th').index($input.parents('th')),
					$table = $panel.find('.table'),
					$rows = $table.find('tbody tr');
					/* Dirtiest filter function ever ;) */
					var $filteredRows = $rows.filter(function(){
						var value = $(this).find('td').eq(column).text().toLowerCase();
						return value.indexOf(inputContent) === -1;
					});
					/* Clean previous no-result if exist */
					$table.find('tbody .no-result').remove();
					/* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
					$rows.show();
					$filteredRows.hide();
					/* Prepend no-result row if all rows are filtered */
					if ($filteredRows.length === $rows.length) {
						$table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
					}

				});
			});
		</script>
		<?php
		include 'topNavBar.php';
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col col-md-2">
					<h4 class="text-center">Learners</h4>
					<button id="btnLearnerEdit"      class="btn btn-block dark-theme active" onclick="showFile('learnerEdit', this.id); sessionStorage.clear('selectedLearner');">Edit Existing Learner</button>
					<button id="btnLearnerNew"       class="btn btn-block dark-theme"        onclick="showFile('learnerNew', this.id)">Create New Learner</button>
					<button id="btnAddLearnerCourse" class="btn btn-block dark-theme"        onclick="showFile('learnerCourse', this.id)" title="Course must already exist. Create under 'Courses' on the main menu.">Add Learner Course</button>
				</div>
				<div class="col col-md-9" id="working">
					<!--This should be empty-->
					<?php include 'learnerEdit.php'; ?>
					
				</div>
				<div class="col col-md-1" id="rightBorder"></div>
			</div>
		</div>
		<?php		include 'includes/modal.php'; ?>
    </body>
</html>
<?php
	}
	else {
		header('location: index.php');
	}
?>
