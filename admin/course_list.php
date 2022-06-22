<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_course" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New Course</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="32%">
					<col width="32%">
					<col width="31%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Code</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM course_list");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $row['code'] ?></b></td>
						<td><b><?php echo $row['description'] ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_course">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_course" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
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
	$(document).ready(function(){
		$('.new_course').click(function(){
			uni_modal("New course","<?php echo $_SESSION['login_view_folder'] ?>manage_course.php")
		})
		$('.manage_course').click(function(){
			uni_modal("Manage course","<?php echo $_SESSION['login_view_folder'] ?>manage_course.php?id="+$(this).attr('data-id'))
		})
	$('.delete_course').click(function(){
	_conf("Are you sure to delete this course?","delete_course",[$(this).attr('data-id')])
	})
		$('#list').dataTable()
	})
	function delete_course($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_course',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>