<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_org"><i class="fa fa-plus"></i> Add New Organization</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Abbreviation</th>
						<th>Name</th>
						<th>Number of Scholars</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM org_list");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<?php 
							$num_scholars = $conn->query("SELECT COUNT(*) FROM student_list WHERE org_id = ".$row['id'])->fetch_array()[0];
						?>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $row['abbre'] ?></b></td>
						<td><b><?php echo $row['name'] ?></b></td>
						<td><b><?php echo $num_scholars?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu">
		                      <a class="dropdown-item view_org" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_organization&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_org" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
	$('.view_org').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> Organization Detail","<?php echo $_SESSION['login_view_folder'] ?>view_org.php?id="+$(this).attr('data-id'))
	})
	$('.delete_org').click(function(){
	_conf("Are you sure to delete this Organization?","delete_org",[$(this).attr('data-id')])
	})
		$('#list').dataTable()
	})
	function delete_org($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_org',
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