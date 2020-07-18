<?php
require 'functions.php'; // Satu file yang simpan macam2 functions kita
session_start();
/* 
  Function preload ni akan restrict user daripada access page
  Since kita ada 2 jenis user sahaja, values accepted:
  'all' maksudnya semua users/jobs boleh access page ni
  1 maksudnya job_id = 1 = MANAGER sahaja yang boleh access
*/
preload('all');

$logged_in = $_SESSION['EMP_ID']; // employee id yang login
$manager = $_SESSION['JOB_ID'] == 1; // variable nk tau manager atau tidak
?>
<html lang="en">

<head>
  <title>2r2 Mart</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="css/uniform.css" />
  <link rel="stylesheet" href="css/select2.css" />
  <link rel="stylesheet" href="css/matrix-style.css" />
  <link rel="stylesheet" href="css/matrix-media.css" />
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <style>
    .tableform {
      display:inline
    }
  </style>
</head>

<body>
  <!--top-Header-menu-->
  <?php include("topheadermenu.php"); ?>
  <!--sidebar-menu-->

  <?php include("sidebar.php"); ?>

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">View Employee</a> </div>
      <h1>View Employee</h1>
    </div>

    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
              <h5>Full Time Employee</h5>
            </div>
            <div class="widget-content nopadding">
              <div style="overflow:auto;">
                <table class="table table-bordered data-table" id="tablecb" style="white-space: nowrap;">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone No</th>
                      <th>Supervisor</th>
                      <th>Address</th>
                      <th>Salary</th>
                      <th>Hire Date</th>
                      <th>Job Position</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    require("Connection.php");
                    $con = new Connection();
                    $emp = $con->query("
                    Select e.name,e.email,e.phoneno,e.address,e.salary,e.hire_date,j.job_title,
                    (case 
                    when supervisor_id is null then 'No Supervisor' 
                    else (select name from employee where emp_id = e.supervisor_id) 
                    end) supervisor 
                    FROM employee e join full_time f on e.emp_id = f.emp_id join job j on j.job_id = e.job_id where e.emp_id != ?
                    order by e.emp_id asc", [$manager]);
                    if ($emp != null) {
                      for ($i = 0; $i < count($emp); $i++) {
                        $hiddenid = $i + 1; // for security purposes
                    ?>
                        <tr class="gradeX">
                          <td style="width:14%;white-space:normal;"><?php echo $emp[$i]['NAME'] ?></td>
                          <td><?php echo $emp[$i]['EMAIL'] ?></td>
                          <td><?php echo $emp[$i]['PHONENO'] ?></td>
                          <td><?php echo $emp[$i]['SUPERVISOR'] ?></td>
                          <?php if ($manager) { ?>
                            <td style="white-space:normal;"><?php echo $emp[$i]['ADDRESS'] ?></td>
                            <td><?php echo $emp[$i]['SALARY'] ?></td>
                            <td><?php echo $emp[$i]['HIRE_DATE'] ?></td>
                            <td><?php echo $emp[$i]['JOB_TITLE'] ?></td>
                            <td>
                              <p>
                                <center>
                                  <form class="tableform" action="register_employee.php" method="post">
                                    <input type="hidden" value="<?php echo $hiddenid ?>" name="row" />
                                    <button class="btn btn-warning" name="fulltime">Edit</button>
                                  </form>
                                  <form class="tableform" action="delete_employee.php" method="post" onsubmit="return deleteConfirmation('<?php echo $emp[$i]['NAME'] ?>')">
                                    <input type="hidden" value="<?php echo $hiddenid ?>" name="row" />
                                    <button class="btn btn-danger" name="fulltime">Delete</button>
                                  </form>
                              </p>
                            </td>
                          <?php } ?>
                        </tr>
                    <?php }
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
              <h5>Part Time Employee</h5>
            </div>
            <div class="widget-content nopadding">
              <div style="overflow:auto;">
                <table class="table table-bordered data-table" id="tablecb" style="white-space: nowrap;">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone No</th>
                      <th>Supervisor</th>
                      <th>Address</th>
                      <th>Salary</th>
                      <th>Hire Date</th>
                      <th>Job Position</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $emp = $con->query("
                    Select e.name,e.email,e.phoneno,e.address,e.salary,e.hire_date,j.job_title,
                    (case 
                    when supervisor_id is null then 'No Supervisor' 
                    else (select name from employee where emp_id = e.supervisor_id) 
                    end) supervisor 
                    FROM employee e join part_time p on e.emp_id = p.emp_id join job j on j.job_id = e.job_id where e.emp_id != ?
                    order by e.emp_id asc", [$manager]);
                    if ($emp != null) {
                      for ($i = 0; $i < count($emp); $i++) {
                        $hiddenid = $i + 1; // for security purposes
                    ?>
                        <tr class="gradeX">
                          <td style="width:14%;white-space:normal;"><?php echo $emp[$i]['NAME'] ?></td>
                          <td><?php echo $emp[$i]['EMAIL'] ?></td>
                          <td><?php echo $emp[$i]['PHONENO'] ?></td>
                          <td><?php echo $emp[$i]['SUPERVISOR'] ?></td>
                          <?php if ($manager) { ?>
                            <td style="white-space:normal;"><?php echo $emp[$i]['ADDRESS'] ?></td>
                            <td><?php echo $emp[$i]['SALARY'] ?></td>
                            <td><?php echo $emp[$i]['HIRE_DATE'] ?></td>
                            <td><?php echo $emp[$i]['JOB_TITLE'] ?></td>
                            <td>
                              <p>
                                <center>
                                  <form class="tableform" action="register_employee.php" method="post">
                                    <input type="hidden" value="<?php echo $hiddenid ?>" name="row" />
                                    <button class="btn btn-warning" name="parttime">Edit</button>
                                  </form>
                                  <form class="tableform" action="delete_employee.php" method="post">
                                    <input type="hidden" value="<?php echo $hiddenid ?>" name="row" />
                                    <button class="btn btn-danger" name="parttime">Delete</button>
                                  </form>
                              </p>
                            </td>
                          <?php } ?>
                        </tr>
                    <?php }
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.custom.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.uniform.js"></script>
  <script src="js/select2.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/matrix.js"></script>
  <script src="js/matrix.tables.js"></script>
  <script>
    $(document).ready(function() {
      var Width = $('#tablecb').width();
      $("#tablecb_paginate").parent().css({
        "width": Width,
        "margin-left": "0px",
        "padding-left": "0px",
        "margin-right": "0px",
        "padding-right": "0px"
      });
      var Width = $('#tablecb2').width();
      $("#tablecb2_paginate").parent().css({
        "width": Width,
        "margin-left": "0px",
        "padding-left": "0px",
        "margin-right": "0px",
        "padding-right": "0px"
      });
    });
    
    function deleteConfirmation($name){
      return confirm("Do you want to remove " + $name + " ?");
    }
  </script>
</body>

</html>