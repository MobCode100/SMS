<?php
require 'functions.php'; // Satu file yang simpan macam2 functions kita
session_start();
/*
  Function preload ni akan restrict user daripada access page
  Since kita ada 2 jenis user sahaja, values accepted:
  'all' maksudnya semua users/jobs boleh access page ni
  1 maksudnya job_id = 1 = MANAGER sahaja yang boleh access
*/
preload(1);
$logged_in = $_SESSION['EMP_ID']; // employee id yang login
?>
<?php
require("Connection.php");
$con = new Connection();
$result = $con->query("SELECT * FROM EMPLOYEE WHERE EMP_ID != ? AND JOB_ID =? order by emp_id asc", [$logged_in, 2]);
$super = $con->query("SELECT * FROM EMPLOYEE WHERE JOB_ID = ? order by emp_id asc", [3]);
if (isset($_POST['Save'])) {
  if (isset($_POST['supername']) && isset($_POST['selected'])) {
    $indexEmp =  $_POST['selected'];
    $indexSup = $_POST['supername'];
    if ($indexSup > -1 && $indexSup < count($super)) {
      $result1 = $con->query("UPDATE EMPLOYEE SET SUPERVISOR_ID = ?  WHERE EMP_ID = ? ", [$super[$indexSup]['EMP_ID'], $result[$indexEmp]['EMP_ID']]);
      $_SESSION['t'] = 0;
      $_SESSION['message'] = 'Supervisor updated successfully';
    } else {
      $_SESSION['t'] = 1;
      $_SESSION['message'] = 'No supervisor has been selected';
    }
  } else {
    $_SESSION['t'] = 1;
    $_SESSION['message'] = 'No supervisor has been selected';
  }
  header('Location: assign_supervisor.php');
  exit;
}
if (isset($_POST['Delete'])) {
  if (isset($_POST['selected'])) {
    $indexEmp =  $_POST['selected'];
    $result1 = $con->query("UPDATE EMPLOYEE SET SUPERVISOR_ID = null  WHERE EMP_ID = ? ", [$result[$indexEmp]['EMP_ID']]);
    $_SESSION['t'] = 0;
    $_SESSION['message'] = 'Supervisor updated successfully';
  } else{
    $_SESSION['t'] = 1;
    $_SESSION['message'] = 'No employee has been selected';
  }
  header('Location: assign_supervisor.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>2r2 Mart</title>
  <link rel="icon" href="img/logo2.png">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
  <link rel="stylesheet" href="css/uniform.css" />
  <link rel="stylesheet" href="css/select2.css" />
  <link rel="stylesheet" href="css/matrix-style.css" />
  <link rel="stylesheet" href="css/matrix-media.css" />
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="modalStyle.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <style>
    .tableform {
      display: inline
    }
  </style>
</head>

<body>
  <!--top-Header-menu-->
  <?php include 'topheadermenu.php'; ?>
  <!--sidebar-menu-->

  <?php include 'sidebar.php'; ?>

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Assign Supervisor</a> </div>
      <h1>Assign Supervisor</h1>
    </div>

    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-group"></i></span>
              <h5>Employees</h5>
            </div>
            <div class="widget-content nopadding">
              <div style="overflow:auto;">
                <table class="table table-bordered data-table" id="tablecb" style="white-space: nowrap;font-size:medium">
                  <thead>
                    <tr>
                    <tr>
                      <th>
                        <font size="2px">Name</font>
                      </th>
                      <th>
                        <font size="2px">Email</font>
                      </th>
                      <th>
                        <font size="2px">Phone No</font>
                      </th>
                      <th>
                        <font size="2px">Job Position</font>
                      </th>
                      <th>
                        <font size="2px">Current Supervisor</font>
                      </th>
                      <th>
                        <font size="2px">Assign/Edit Supervisor</font>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result != null) {
                      for ($i = 0; $i < count($result); ++$i) {
                    ?>
                        <tr class="gradeX">
                          <td>
                            <?php echo $result[$i]['NAME']; ?>
                          </td>
                          <td>
                            <?php echo $result[$i]['EMAIL']; ?>
                          </td>
                          <td>
                            <?php echo $result[$i]['PHONENO']; ?>
                          </td>
                          <?php
                          if ($result[$i]['JOB_ID'] == 1) {
                            $job = "MANAGER";
                          } else {
                            $job = "EMPLOYEE";
                          }    ?>
                          <td>
                            <?php echo $job; ?>
                          </td>
                          <?php
                          if ($result[$i]['SUPERVISOR_ID'] == null) {
                          ?> <td>
                              <?php echo "Not Yet Assigned"; ?>
                            </td>
                          <?php  } else {
                            $result2 = $con->query("SELECT * FROM EMPLOYEE WHERE EMP_ID = ?", [$result[$i]['SUPERVISOR_ID']]);
                            for ($k = 0; $k < count($result2); $k++) {
                              $s_name = $result2[$k]['NAME'];
                            }
                          ?> <td>
                              <?php echo $s_name; ?>
                            </td>
                          <?php }
                          ?>
                          <form action="assign_supervisor.php" method="post">
                            <td>
                              <p>
                                <center>
                                  <div class="control-group">

                                    <div class="controls">
                                      <select name="supername">
                                        <?php
                                        if ($super != null) {
                                          for ($j = 0; $j < count($super); $j++) {
                                            $name = $super[$j]['NAME']; ?>
                                            <option value="<?php echo $j; ?>"><?php echo $name ?></option>
                                        <?php }
                                        } ?>
                                      </select>
                                    </div>
                                  </div>
                                  <?php
                                  ?>
                                  <input type="hidden" name="selected" value="<?php echo $i ?>" />
                                  <p>
                                    <center>
                                      <button type="submit" name="Save" class="btn btn-success">Save</button>
                                      <button type="submit" name="Delete" class="btn btn-danger">No Supervisor</button>
                                  </p>
                              </p>
                            </td>
                          </form>
                        </tr>
                    <?php
                      }
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
  </script>
  <?php if (isset($_SESSION['message'])) {
    if ($_SESSION['t'] == 1) {
      $id = "myModalError";
  ?>
      <div id="myModalError" class="modal hide fade">
        <div class="modal-header" style="color: #b94a48;background-color: #f2dede;border-color: #eed3d7; border-radius:6px;font-size:15px">
          <button class="close" data-dismiss="modal">×</button>
          <strong>Error!</strong> &nbsp;<?php echo $_SESSION['message'] ?>
        </div>
      </div>
    <?php } else {
      $id = "myModalSuccess";
    ?>
      <div id="myModalSuccess" class="modal hide fade">
        <div class="modal-header" style="color: #468847;background-color: #dff0d8;border-color: #d6e9c6; border-radius:6px;font-size:15px">
          <button class="close" data-dismiss="modal">×</button>
          <strong>Success!</strong> &nbsp;<?php echo $_SESSION['message'] ?>
        </div>
      </div>
    <?php } ?>
    <script>
      $(document).ready(function() {
        $('#<?php echo $id; ?>').modal('show');
      });
    </script>
  <?php clearMessage();
  } ?>
</body>

</html>