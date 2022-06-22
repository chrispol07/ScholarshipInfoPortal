<?php include('db_connect.php');

$org = $conn->query("SELECT name FROM org_list where id = {$_SESSION['login_org_id']}")->fetch_array();
$status = $conn->query("SELECT status FROM status_list where id = {$_SESSION['login_status']}")->fetch_array();
?>

<div class="col-12">
  <div class="card">
    <div class="card-body">

      <br>
      <div class="col-md-5">
        <div class="callout callout-info">
          <h5><b>Welcome <?php echo $_SESSION['login_name'] ?>!</b></h5>
          <h5><b>Scholarship: <?php echo $org['name'] ?> </b></h5>
          <h6><b>Status: <?php echo $status['status'] ?></b></h6>
        </div>
      </div>
    </div>
  </div>
</div>