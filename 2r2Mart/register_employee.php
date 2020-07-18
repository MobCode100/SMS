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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>2r2 Mart</title>
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

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $("#jobPosition").change(function() {
        if ($(this).val() == "employee") {
          $("#employeeType").show();
        } else {
          $("#employeeType").hide();
        }
      });
    });

    $(function() {
      $("#timeType").change(function() {
        if ($(this).val() == "fullTime") {
          $("#Allowance").show();
        } else {
          $("#Allowance").hide();
        }
      });
    });

    $(function() {
      $("#timeType").change(function() {
        if ($(this).val() == "partTime") {
          $("#hourlySalary").show();
        } else {
          $("#hourlySalary").hide();
        }
      });
    });
  </script>
</head>

<body>
  <!--top-Header-menu-->
  <?php include 'topheadermenu.php'; ?>


  <!--sidebar-menu-->
  <?php include 'sidebar.php'; ?>
  <!--close-left-menu-stats-sidebar-->

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Register Employee</a> </div>
      <h1>Register Employee</h1>
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
              <form name="form1" action="registerprocess.php" method="POST" class="form-horizontal" onsubmit="return validateEmail(document.form1.email.value)" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>>

                <div class="control-group">
                  <label class="control-label">Name :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="empname" required/>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Email :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="email"required/>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Address :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="address"required/>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Phone Number :</label>
                  <div class="controls ">
                    <input type="text" class="span5" name="phoneNO"required/>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Password :</label>
                  <div class="controls ">
                    <input type="password" class="span5" name="password"required/>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Salary :</label>
                  <div class="controls ">
                    <input type="text" class="span5" name="salary"required/>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Hire Date :</label>
                  <div class="controls">
                    <input type="date" class="" name="hiredate"required/>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Job Position</label>
                  <div class="controls">
                    <select id="jobPosition" class="span5 " name="jobPosition" onchange='CheckPosition(this.value);'>
                      <option value=" ">Choose job position</option>
                      <option value="manager">Manager</option>
                      <option value="employee">Employee</option>
                    </select>
                  </div>
                </div>
                <div class="control-group" id="employeeType" style="display: none">
                  <label class="control-label">Employee Type</label>
                  <div class="controls">
                    <select id="timeType" class="span5 " name="employeeType" required>
                      <option value=" ">Choose employee type</option>
                      <option value="fullTime">Full Time</option>
                      <option value="partTime">Part Time</option>
                    </select>
                  </div>
                </div>

                <div class="control-group" id="Allowance" style="display: none">
                  <label class="control-label">Allowance :</label>
                  <div class="controls">
                    <input type="text" name="allowance" class="span5" placeholder="Allowance"/>
                  </div>
                </div>

                <div class="control-group" id="hourlySalary" style="display: none">
                  <label class="control-label">Hourly Rate :</label>
                  <div class="controls">
                    <input type="text" name="hourlyrate" class="span5" placeholder="Hourly Rate"/>
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
    function validateEmail(email) {
        var re = /^(([^\s"().,:;<>@\[\\\]])+(\.[^\s"().,:;<>@\[\\\]]+)*|(".+"))@(\[(([0-9]{1,2}|(25[0-5]|[0-2][0-4][0-9]))\.){3}([0-9]{1,2}|(25[0-4]|[0-2][0-4][0-9]))\]|([a-zA-Z\-0-9]+\.)+([a-zA-Z]{2,}))$/;
        if (re.test(email) == false)
        {
          alert("Please insert correct Email");
        }

        return re.test(email);

    }
  </script>
</body>
</html>