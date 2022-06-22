<?php include '../db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM student_list where id = ".$_GET['id'])->fetch_array();
  $year_level = $conn->query("SELECT id,level as `year` FROM year_list where id = " . $qry['year'])->fetch_array()['year'];
  $code = $conn->query("SELECT id,code FROM course_list where id = " . $qry['course_id'])->fetch_array()['code'];
  $org = $conn->query("SELECT id,name,abbre FROM org_list where id = " . $qry['org_id'])->fetch_array();
  $status = $conn->query("SELECT id,status FROM status_list where id = " . $qry['status'])->fetch_array()['status'];
  $avatar = $qry['avatar'];
  $name = $qry['name'];
  $email = $qry['email'];
  $school_id = $qry['school_id'];
}
?>
<div class="container-fluid">
	<div class="card card-widget widget-user shadow">
      <div class="widget-user-header bg-dark">
        <h3 class="widget-user-username"><?php echo ucwords($name) ?></h3>
        <h5 class="widget-user-desc"><?php echo $email ?></h5>
      </div>
      <div class="widget-user-image">
      	<?php if(empty($avatar) || (!empty($avatar) && !is_file('../assets/uploads/'.$avatar))): ?>
      	<span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px;height:90px"><h4><?php echo strtoupper(substr($firstname, 0,1).substr($lastname, 0,1)) ?></h4></span>
      	<?php else: ?>
        <img class="img-circle elevation-2" src="assets/uploads/<?php echo $avatar ?>" alt="User Avatar"  style="width: 90px;height:90px;object-fit: cover">
      	<?php endif ?>
      </div>
      <div class="card-footer">
        <div class="container-fluid">
          <dl>
            <dt>School ID</dt>
            <dd><?php echo $school_id ?></dd>
            <dt>Year</dt>
            <dd><?php echo(!empty($year_level) ? $year_level." Year" : 'N/A' ) ?></dd>
            <dt>Course</dt>
            <dd><?php echo (!empty($code) ? $code : 'No Course Available' ) ?></dd>
            <dt>Organization</dt>
            <dd><?php echo (!empty($org) ? $org['abbre']." - ".$org['name'] : 'N/A')?></dd>
            <dt>Status</dt>
            <dd><?php echo $status ?></dd>
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