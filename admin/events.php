<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_events" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="30%">
					<col width="50%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Title</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM event_list");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo $row['title'] ?></b></td>
							<td><b><?php echo $row['description'] ?></b></td>
							<td class="text-center">
								<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									Action
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item manage_evaluation" href="index.php?page=manage_evaluation&id=<?php echo $row['id'] ?>">Manage Evaluation</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_evaluation" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete Event</a>
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
		$('.new_events').click(function() {
			uni_modal("New Event", "<?php echo $_SESSION['login_view_folder'] ?>manage_events.php")
		})
		$('.delete_evaluation').click(function() {
			_conf("Are you sure to delete this event?", "delete_evaluation", [$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})

	function delete_evaluation($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_evaluation',
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