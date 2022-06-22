<?php include('db_connect.php'); ?>

<div class="col-12">
  <div class="card">
    <div class="card-body">
      <br>
      <div class="col-md-5">
        <div class="callout callout-info">
          <h5><b>Welcome <?php echo $_SESSION['login_name'] ?>!</b></h5>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 col-sm-6 col-md-4">
    <div class="small-box bg-light shadow-sm border">
      <div class="inner">
        <h3><?php echo $conn->query("SELECT * FROM org_list ")->num_rows; ?></h3>

        <p>Total Organization</p>
      </div>
      <div class="icon">
        <i class="fa fa-user-friends"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-4">
    <div class="small-box bg-light shadow-sm border">
      <div class="inner">
        <h3><?php echo $conn->query("SELECT * FROM student_list")->num_rows; ?></h3>

        <p>Total Students</p>
      </div>
      <div class="icon">
        <i class="fa ion-ios-people-outline"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-4">
    <div class="small-box bg-light shadow-sm border">
      <div class="inner">
        <h3><?php echo $conn->query("SELECT * FROM course_list")->num_rows; ?></h3>

        <p>Total Courses</p>
      </div>
      <div class="icon">
        <i class="fa fa-list-alt"></i>
      </div>
    </div>
  </div>
</div>