<?php
include '../db_connect.php';
?>
<div class="container-fluid">
	<form action="" id="manage-restriction">
		<div class="row">
			<div class="col-md-4 border-right">
				<input type="hidden" name="event_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
				<div id="msg" class="form-group"></div>
				<div class="form-group">
					<label for="" class="control-label">Organization</label>
					<select name="" id="org_id" class="form-control form-control-sm select2">
						<option value="0">Applicable to all</option>
						<?php
						$orgs = $conn->query("SELECT *, name FROM org_list order by concat(name) asc");
						$o_arr = array();
						while ($row = $orgs->fetch_assoc()) :
							$o_arr[$row['id']] = $row;
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($org_id) && $org_id == $row['id'] ? "selected" : "" ?>><?php echo $row['abbre'] . " - " . ucwords($row['name']) ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Year Level</label>
					<select name="" id="year_id" class="form-control form-control-sm select2">
						<option value="0">Applicable to all</option>
						<?php
						$year_level = $conn->query("SELECT *, level as year FROM year_list");
						$y_arr = array();
						while ($row = $year_level->fetch_assoc()) :
							$y_arr[$row['id']] = $row;
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($year_id) && $year_id == $row['id'] ? "selected" : "" ?>><?php echo $row['year'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Course</label>
					<select name="" id="course_id" class="form-control form-control-sm select2">
						<option value="0">Applicable to all</option>
						<?php
						$courses = $conn->query("SELECT * FROM course_list");
						$c_arr = array();
						while ($row = $courses->fetch_assoc()) :
							$c_arr[$row['id']] = $row;
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? "selected" : "" ?>><?php echo $row['code'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<div class="d-flex w-100 justify-content-center">
						<button class="btn btn-sm btn-flat btn-primary bg-gradient-primary" id="add_to_list" type="button">Add to List</button>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<table class="table table-condensed" id="r-list">
					<thead>
						<tr>
							<th>Organization</th>
							<th>Year</th>
							<th>Course</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$restriction = $conn->query("SELECT * FROM restriction_list where event_id = {$_GET['id']} order by id asc");
						while ($row = $restriction->fetch_assoc()) :
						?>
							<tr>
								<td>
									<b><?php echo isset($o_arr[$row['org']]) ? $o_arr[$row['org']]['name'] : 'Applicable to All' ?></b>
									<input type="hidden" name="rid[]" value="<?php echo $row['id'] ?>">
									<input type="hidden" name="org[]" value="<?php echo $row['org'] ?>">
								</td>
								<td>
									<b><?php echo isset($y_arr[$row['year']]) ? $y_arr[$row['year']]['year'] : 'Applicable to All' ?></b>
									<input type="hidden" name="year[]" value="<?php echo $row['year'] ?>">
								</td>
								<td>
									<b><?php echo isset($c_arr[$row['course']]) ? $c_arr[$row['course']]['code']: 'Applicable to All' ?></b>
									<input type="hidden" name="course[]" value="<?php echo $row['course'] ?>">
								</td>
								<td class="text-center">
									<button class="btn btn-sm btn-outline-danger" onclick="$(this).closest('tr').remove()" type="button"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<script>
	$(document).ready(function() {
		$('.select2').select2({
			placeholder: "Please select here",
			width: "100%"
		});
		$('#manage-restriction').submit(function(e) {
			e.preventDefault();
			start_load()
			$('#msg').html('')
			$.ajax({
				url: 'ajax.php?action=save_restriction',
				method: 'POST',
				data: $(this).serialize(),
				success: function(resp) {
					if (resp == 1) {
						alert_toast("Data successfully saved.", "success");
						setTimeout(function() {
							location.reload()
						}, 1750)
					} else if (resp == 2) {
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Class already exist.</div>')
						end_load()
					}
				}
			})
		})
		$('#add_to_list').click(function() {
			start_load()
			var frm = $('#manage-restriction')
			var yid = frm.find('#year_id').val()
			var oid = frm.find('#org_id').val()
			var cid = frm.find('#course_id').val()
			var o_arr = <?php echo json_encode($o_arr) ?>;
			var y_arr = <?php echo json_encode($y_arr) ?>;
			var c_arr = <?php echo json_encode($c_arr) ?>;

			var org = "";
			var year = "";
			var course = "";
			
			if (oid == 0){
				org = "All organization";
			}
			else {
				org = o_arr[oid].name;
			}
			if(cid == 0){
				course = "All Courses";
			}else{
				course = c_arr[cid].code
			}
			if(yid == 0){
				year = "All year level";
			}else{
				year = y_arr[yid].year
			}
			var tr = $("<tr> </tr>");
			tr.append('<td><b>' + org + '</b><input type="hidden" name="rid[]" value=""><input type="hidden" name="org[]" value="' + oid + '"></td>');
			tr.append('<td><b>' + year + '</b><input type="hidden" name="year[]" value="' + yid + '"></td>');
			tr.append('<td><b>' + course + '</b><input type="hidden" name="course[]" value="' + cid + '"></td>');
			tr.append('<td class="text-center"><span class="btn btn-sm btn-outline-danger" onclick="$(this).closest(\'tr\').remove()" type="button"><i class="fa fa-trash"></i></span></td>');
			$('#r-list tbody').append(tr);
			frm.find('#year_id').val('0').trigger('change')
			frm.find('#org_id').val('0').trigger('change')
			frm.find('#course_id').val('0').trigger('change')
			end_load()
		})
	})
</script>