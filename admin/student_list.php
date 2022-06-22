<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_student"><i class="fa fa-plus"></i> Add New Student</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>School ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Year & Course</th>
						<th>Organization</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$statuses = array();

					$year_levels = array();
					$courses = array();
					$orgs = array();


					$year_qry = $conn->query("SELECT id,level as `year` FROM year_list");
					$course_qry = $conn->query("SELECT * FROM course_list");
					$orgs_qry = $conn->query("SELECT * FROM org_list");
					$status_qry = $conn->query("SELECT * FROM status_list");

					while ($row = $year_qry->fetch_assoc()) {
						$year_levels[$row['id']] = $row['year'];
					}
					while ($row = $course_qry->fetch_assoc()) {
						$courses[$row['id']] = $row['code'];
					}

					while ($row = $orgs_qry->fetch_assoc()) {
						$orgs[$row['id']] = $row['abbre'] . " - " . $row['name'];
					}
					while ($row = $status_qry->fetch_assoc()) {
						$statuses[$row['id']] = $row['status'];
					}
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM student_list order by concat(firstname,' ',lastname) asc");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo $row['school_id'] ?></b></td>
							<td><b><?php echo ucwords($row['name']) ?></b></td>
							<td><b><?php echo $row['email'] ?></b></td>
							<td><b><?php echo $year_levels[$row['year']] . " year " . (!empty($courses[$row['course_id']]) ? $courses[$row['course_id']] : 'No Course Available') ?></b></td>
							<td><b><?php echo (!empty($orgs[$row['org_id']]) ? $orgs[$row['org_id']] : 'No Scholarship') ?></b></td>
							<td><b><?php echo isset($statuses[$row['status']]) ? $statuses[$row['status']] : "N/A" ?></b></td>
							<td class="text-center">
								<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									Action
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item view_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./index.php?page=edit_student&id=<?php echo $row['id'] ?>">Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.view_student').click(function() {
			uni_modal("<i class='fa fa-id-card'></i> student Details", "<?php echo $_SESSION['login_view_folder'] ?>view_student.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_student').click(function() {
			_conf("Are you sure to delete this student?", "delete_student", [$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})

	function delete_student($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_student',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>