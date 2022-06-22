<?php include '../db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM org_list where id = ".$_GET['id'])->fetch_array();
	$num_scholars = $conn->query("SELECT COUNT(*) FROM student_list WHERE org_id = ".$_GET['id'])->fetch_array()[0];
}
?>
<div class="container-fluid">
	<div class="card card-widget widget-user shadow">
      <div class="widget-user-header bg-dark">
        <h3 class="widget-user-username"><?php echo ucwords($qry['name']) ?></h3>
      </div>
      <div class="widget-user-image">
      	<?php if(empty($qry['avatar']) || (!empty($qry['avatar']) && !is_file('../assets/uploads/'.$qry['avatar']))): ?>
      	<span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px;height:90px"><h4><?php echo strtoupper(substr($firstname, 0,1).substr($lastname, 0,1)) ?></h4></span>
      	<?php else: ?>
        <img class="img-circle elevation-2" src="assets/uploads/<?php echo $qry['avatar'] ?>" alt="User Avatar"  style="width: 90px;height:90px;object-fit: cover">
      	<?php endif ?>
      </div>
      <div class="card-footer">
        <div class="container-fluid">
        	<dl>
        		<dt>Number of Scholars</dt>
        		<dd><?php echo $num_scholars;?></dd>
        	</dl>
        </div>
    </div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>