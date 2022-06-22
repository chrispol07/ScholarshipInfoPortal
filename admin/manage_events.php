<?php
include '../db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM event_list where id={$_GET['id']}")->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-events">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div id="msg" class="form-group"></div>
		<div class="form-group">
			<label for="year" class="control-label">Title</label>
			<input type="text" class="form-control form-control-sm" name="title" id="title" value="<?php echo isset($title) ? $title : '' ?>" placeholder="Event Title" required>
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea name="description" id="description" cols="30" rows="4" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
		</div>
	</form>
</div>
<script>
	$(document).ready(function() {
		$('#manage-events').submit(function(e) {
			e.preventDefault();
			start_load()
			$('#msg').html('')
			$.ajax({
				url: 'ajax.php?action=save_events',
				method: 'POST',
				data: $(this).serialize(),
				success: function(resp) {
					if (resp == 1) {
						alert_toast("Data successfully saved.", "success");
						setTimeout(function() {
							location.reload()
						}, 1750)
					} else if (resp == 2) {
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> events Code already exist.</div>')
						end_load()
					}
				}
			})
		})
	})
</script>