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
</head>

<body>
  <!--top-Header-menu-->
  <?php include("topheadermenu.php"); ?>

  <!--sidebar-menu-->
  <?php include("sidebar.php"); ?>
  <!--close-left-menu-stats-sidebar-->

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Change Password</a> </div>
      <!-- <h1>Change Password</h1> -->
    </div>



    <div class="container-fluid">

      <div align="center" class="control-group normal_text">
        <h3><img src="img/password.png" alt="Logo" width="250" height="350" style="border-radius: 6px;" /> </h3>
      </div>
      <div class="row-fluid">

        <div class="span12">
          <h5>In order to protect your account, make sure your password:</h5>
          <h5>1. Is longer than 7 characters.</h5>
          <h5>1. Does not match or significantly contain your name, e.g. 'maslan123'</h5>
          <div class="widget-box">

            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
              <h5>Password-info</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="password.php" method="post" class="form-horizontal" onsubmit="return validate()">

                <div class="control-group">
                  <label class="control-label">Current Password :</label>
                  <div class="controls">
                    <input type="password" class="span11" required name="currentPassword" />
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">New Password :</label>
                  <div class="controls">
                    <input type="password" class="span11" required name="newPassword" />
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Re-enter New Password :</label>
                  <div class="controls">
                    <input type="password" class="span11" required name="confirmPassword" />
                  </div>
                </div>


                <div align="center" class="form-actions">
                  <button type="submit" name="submit" class="btn btn-success">Change Password</button>
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
    function validate() {
      var nP = $('input[name ="newPassword"]').val();
      var cP = $('input[name ="confirmPassword"]').val()
      if (nP.length > 7) {
        var name = '<?php echo $_SESSION['NAME'] ?>';
        name = name.split(/\s+/);
        var matchname = false;
        var nPL = nP.toLowerCase();
        for (var i = 0; i < name.length; i++) {
          name[i] = name[i].toLowerCase();
          if (nPL.search(name[i]) != -1) {
            matchname = true;
            break;
          }
        }
        if (!matchname) {
          if (nP === cP) {
            return true;
          } else {
            alert("New passwords do not match!");
            return false;
          }
        } else {
          alert("Name found in new password!");
          return false;
        }
      } else {
        alert("Password must be longer than 7 characters!");
        return false;
      }
    }
  </script>
</body>

</html>