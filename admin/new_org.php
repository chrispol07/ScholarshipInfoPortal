<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_org">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label">Name</label>
							<input type="text" name="name" class="form-control form-control-sm" required value="<?php echo isset($name) ? $name : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Abbreviation</label>
							<input type="text" name="abbre" class="form-control form-control-sm" required value="<?php echo isset($abbre) ? $abbre : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Avatar</label>
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
								<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
						</div>
						<div class="form-group d-flex justify-content-center align-items-center">
							<img src="<?php echo isset($avatar) ? 'assets/uploads/' . $avatar : '' ?>" alt="Avatar" id="cimg" class="img-fluid img-thumbnail ">
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=org_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$('#manage_org').submit(function(e) {
		e.preventDefault()
		start_load()

		$.ajax({
			url: 'ajax.php?action=save_org',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Data successfully saved.', "success");
					setTimeout(function() {
						location.replace('index.php?page=org_list')
					}, 750)
				}else if (resp == 3) {
					$('#msg').html("<div class='alert alert-danger'>Organization already exist.</div>");
					$('[name="name"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>