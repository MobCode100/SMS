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
require 'Connection.php';
$con = new Connection();
$job_title = $con->query('SELECT * from JOB order by job_id asc', []);
$howmanyjob = count($job_title);
$logged_in = $_SESSION['EMP_ID']; // employee id yang login
$name = '';
$email = '';
$phoneno = '';
$address = '';
$salary = '';
$hire_date = '';
$allowance = '';
$hourly_rate = '';
$job = '[null,""]';
$edit = false;
if (isset($_POST['fulltime'])) {
  $edit = true;
  $emp_list = $con->query(
    'Select e.emp_id,e.name,e.email,e.phoneno,e.address,e.salary,e.hire_date,j.job_id,f.allowance
    FROM employee e join full_time f on e.emp_id = f.emp_id join job j on j.job_id = e.job_id where e.emp_id != ?
    order by e.emp_id asc',
    [$logged_in]
  );

  if ($emp_list != null) {
    $index = $_POST['row'] - 1;
    $emp_id = $emp_list[$index]['EMP_ID'];
    $name = $emp_list[$index]['NAME'];
    $email = $emp_list[$index]['EMAIL'];
    $phoneno = $emp_list[$index]['PHONENO'];
    $address = $emp_list[$index]['ADDRESS'];
    $salary = $emp_list[$index]['SALARY'];
    $hire_date = $emp_list[$index]['HIRE_DATE'];
    $allowance = $emp_list[$index]['ALLOWANCE'];
    $job = $emp_list[$index]['JOB_ID'];
  }
} elseif (isset($_POST['parttime'])) {
  $edit = true;
  $emp_list = $con->query(
    'Select e.emp_id,e.name,e.email,e.phoneno,e.address,e.salary,e.hire_date,j.job_id,p.hourly_rate
    FROM employee e join part_time p on e.emp_id = p.emp_id join job j on j.job_id = e.job_id where e.emp_id != ?
    order by e.emp_id asc',
    [$logged_in]
  );

  if ($emp_list != null) {
    $index = $_POST['row'] - 1;
    $emp_id = $emp_list[$index]['EMP_ID'];
    $name = $emp_list[$index]['NAME'];
    $email = $emp_list[$index]['EMAIL'];
    $phoneno = $emp_list[$index]['PHONENO'];
    $address = $emp_list[$index]['ADDRESS'];
    $salary = $emp_list[$index]['SALARY'];
    $hire_date = $emp_list[$index]['HIRE_DATE'];
    $hourly_rate = $emp_list[$index]['HOURLY_RATE'];
    $job = $emp_list[$index]['JOB_ID'];
  }
}

if ($job !== '[null,""]') {
  for ($i = 0; $i < $howmanyjob; ++$i) {
    if ($job == $job_title[$i]['JOB_ID']) {
      $job = "[$i,\"" . $job_title[$i]['JOB_TITLE'] . '"]';
    }
  }
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
  <link rel="stylesheet" href="css/colorpicker.css" />
  <link rel="stylesheet" href="css/datepicker.css" />
  <link rel="stylesheet" href="css/uniform.css" />
  <link rel="stylesheet" href="css/select2.css" />
  <link rel="stylesheet" href="css/matrix-style.css" />
  <link rel="stylesheet" href="css/matrix-media.css" />
  <link rel="stylesheet" href="css/bootstrap-wysihtml5.css" />
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <link href="modalStyle.css" rel="stylesheet">
</head>

<body>
  <!--top-Header-menu-->
  <?php include 'topheadermenu.php'; ?>


  <!--sidebar-menu-->
  <?php include 'sidebar.php'; ?>
  <!--close-left-menu-stats-sidebar-->

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current"><?php if ($edit) {
                                                                                                                                                            echo 'Edit Employee';
                                                                                                                                                          } else {
                                                                                                                                                            echo 'Register Employee';
                                                                                                                                                          } ?></a> </div>
      <h1><?php if ($edit) {
            echo 'Edit Employee';
          } else {
            echo 'Register Employee';
          } ?></h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
              <h5>Employee Info</h5>
            </div>
            <div class="widget-content nopadding">
              <form name="form1" action="
                                          <?php if ($edit) {
                                            echo 'edit_employee.php';
                                          } else {
                                            echo 'registerprocess.php';
                                          } ?>
                                        " method="POST" class="form-horizontal" onsubmit="return validateEmail(document.form1.email.value)" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>>
                <div class="control-group">
                  <label class="control-label">Name :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="empname" value="<?php echo $name; ?>" required />
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Email :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="email" value="<?php echo $email; ?>" required />
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Address :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="address" value="<?php echo $address; ?>" required />
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Phone Number :</label>
                  <div class="controls ">
                    <input type="text" class="span5" name="phoneNO" value="<?php echo $phoneno; ?>" required />
                  </div>
                </div>
                <?php if (!$edit) {
                ?>
                  <div class="control-group">
                    <label class="control-label">Password :</label>
                    <div class="controls ">
                      <input type="password" class="span5" name="password" required />
                    </div>
                  </div>
                <?php
                } ?>

                <div class="control-group">
                  <label class="control-label">Salary :</label>
                  <div class="controls ">
                    <input type="text" class="span5 money" name="salary" value="<?php echo $salary; ?>" required />
                  </div>
                </div>
                <?php if ($edit) {
                ?>
                  <input type="hidden" name="empid" value="<?php echo $emp_id; ?>" />
                <?php
                }  ?>
                <div class="control-group">
                  <label class="control-label">Hire Date :</label>
                  <div class="controls">
                    <input type="date" class="" name="hiredate" value="<?php echo date_format(date_create($hire_date), 'Y-m-d'); ?>" required />
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Job Position</label>
                  <div class="controls">
                    <select id="jobPosition" class="span5 " name="jobPosition" required>
                      <option value='[null,""]'>Choose job position</option>
                      <?php if ($job_title != null) {
                        for ($i = 0; $i < $howmanyjob; ++$i) {
                      ?>
                          <option value='<?php echo "[$i,\"" . $job_title[$i]['JOB_TITLE'] . '"]'; ?>'><?php echo ucfirst(strtolower($job_title[$i]['JOB_TITLE'])); ?></option>
                      <?php
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="control-group" id="employeeType" style="display: none">
                  <label class="control-label">Employee Type</label>
                  <div class="controls">
                    <select id="timeType" class="span5 " name="employeeType" required>
                      <option value=" ">Choose employee type</option>
                      <option value="fullTime" <?php if (isset($_POST['fulltime'])) {
                                                  echo 'selected';
                                                } ?>>Full Time</option>
                      <option value="partTime" <?php if (isset($_POST['parttime'])) {
                                                  echo 'selected';
                                                } ?>>Part Time</option>
                    </select>
                  </div>
                </div>

                <div class="control-group" id="Allowance" style="display: none">
                  <label class="control-label">Allowance :</label>
                  <div class="controls">
                    <input type="text" name="allowance" value="<?php echo $allowance; ?>" class="span5 money" placeholder="Allowance" />
                  </div>
                </div>

                <div class="control-group" id="hourlySalary" style="display: none">
                  <label class="control-label">Hourly Rate :</label>
                  <div class="controls">
                    <input type="text" name="hourlyrate" class="span5 money" value="<?php echo $hourly_rate; ?>" placeholder="Hourly Rate" />
                  </div>
                </div>

                <div align="right" class="form-actions">
                  <button type="submit" name="submit" class="btn btn-success">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="myModalError" class="modal hide fade">
    <div class="modal-header" id="error_text" style="color: #b94a48;background-color: #f2dede;border-color: #eed3d7; border-radius:6px;font-size:15px">
      <button class="close" data-dismiss="modal">×</button>
      <strong>Error!</strong> &nbsp;
    </div>
  </div>
  <div id="myModalSuccess" class="modal hide fade">
    <div class="modal-header" id="success_text" style="color: #468847;background-color: #dff0d8;border-color: #d6e9c6; border-radius:6px;font-size:15px">
      <button class="close" data-dismiss="modal">×</button>
      <strong>Success!</strong> &nbsp;
    </div>
  </div>
  <!--Footer-part-->
  <!--end-Footer-part-->
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.custom.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-colorpicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/masked.js"></script>
  <script src="js/jquery.uniform.js"></script>
  <script src="js/select2.min.js"></script>
  <script src="js/matrix.js"></script>
  <script src="js/wysihtml5-0.3.0.js"></script>
  <script src="js/jquery.peity.min.js"></script>
  <script src="js/bootstrap-wysihtml5.js"></script>
  <script>
    <?php
    if (isset($_SESSION['t'])) {
      if ($_SESSION['t'] == 1) {
        echo "$('#error_text').html('<button class=\"close\" data-dismiss=\"modal\">×</button><strong>Error!</strong> &nbsp;" . $_SESSION['message'] . "');";
        echo "$('#myModalError').modal('show');";
      } else {
        echo "$('#success_text').html('<button class=\"close\" data-dismiss=\"modal\">×</button><strong>Success!</strong> &nbsp;" . $_SESSION['message'] . "');";
        echo "$('#myModalSuccess').modal('show');";
      }
      clearMessage();
    }
    ?>

    function validateEmail(email) {
      var re = /^(([^\s"().,:;<>@\[\\\]])+(\.[^\s"().,:;<>@\[\\\]]+)*|(".+"))@(\[(([0-9]{1,2}|(25[0-5]|[0-2][0-4][0-9]))\.){3}([0-9]{1,2}|(25[0-4]|[0-2][0-4][0-9]))\]|([a-zA-Z\-0-9]+\.)+([a-zA-Z]{2,}))$/;
      if (re.test(email) == false) {
        $('#error_text').html('<button class="close" data-dismiss="modal">×</button><strong>Error!</strong> &nbsp;Please insert correct Email');
        $('#myModalError').modal('show');
      }

      return re.test(email);

    }
  </script>
  <script type="text/javascript">
    $(function() {
      $("#jobPosition").change(function() {
        var array = JSON.parse($(this).val());
        if (array[1].toLowerCase() == "staff") {
          $("#employeeType").show();
          $("#Allowance").hide();
          $('#timeType').trigger("change");
        } else {
          $("#employeeType").hide();
          $("#hourlySalary").hide();
          if (array[1].toLowerCase() != "") {
            $("#Allowance").show();
          } else {
            $("#Allowance").hide();
          }
        }
      });
    });

    $(function() {
      $("#timeType").change(function() {
        if ($(this).val() == "fullTime") {
          $("#hourlySalary").hide();
          $("#Allowance").show();
        } else if ($(this).val() == "partTime") {
          $("#Allowance").hide();
          $("#hourlySalary").show();
        } else {
          $("#Allowance").hide();
          $("#hourlySalary").hide();
        }
      });
    });
    $(document).ready(function() {
      $("#jobPosition").val('<?php echo $job; ?>');
      $("#jobPosition").trigger("change");
    });

    $('.money').bind('input propertychange', function() {
      var value = $(this).val().toString()
      var splitted = value.split('.');
      var count = 0;
      var countDec = 0;
      var max = 8;
      var len = splitted[1] ? splitted[1].length : 0;
      for (var i = 0; i < len; i++) {
        var char = splitted[1].substring(i, i + 1).trim();
        if (char.length > 0) {
          if (!isNaN(char)) {
            countDec++;
          }
        }
      }
      if (countDec > 2) {
        max = 7;
      }
      for (var i = 0; i < splitted[0].length; i++) {
        var char = splitted[0].substring(i, i + 1).trim();
        if (char.length > 0) {
          if (!isNaN(char)) {
            count++;
          }
        }
      }
      if (count > max) {
        var currentpos = $('.money:focus')[0].selectionStart;
        var newpos = currentpos - 1;
        $(this).val(value.substring(0, newpos) + value.substring(currentpos));
        $('.money:focus')[0].setSelectionRange(newpos, newpos);
      }
    });
  </script>
</body>

</html>