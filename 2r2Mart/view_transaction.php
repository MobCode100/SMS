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
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <style>
    .tableform {
      display: inline
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
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">View Transaction</a> </div>
      <h1>View Transaction</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Transactions</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Staff Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                  <?php
                  require("Connection.php");
                  $con = new Connection();
                  $trns = $con->query("SELECT t.transaction_id,e.name, p.name p_name, t.quantity,to_char(t.date_time,'DD-MM-YYYY HH:MI:SS AM') time
                    from transaction t join employee e on t.emp_id = e.emp_id join product p on p.product_id = t.product_id", []);
                  if ($trns != null) {
                    for ($i = 0; $i < count($trns); $i++) {
                  ?>
                      <tr class="gradeX">
                        <td><?php echo $i+1 ?></td>
                        <td><?php echo $trns[$i]['P_NAME'] ?></td>
                        <td><?php echo $trns[$i]['QUANTITY']  ?></td>
                        <td><?php echo $trns[$i]['TIME'] ?></td>
                        <td><?php echo $trns[$i]['NAME'] ?></td>
                        <td>
                          <p>
                            <center>
                              <form class="tableform" action="add_transaction.php" method="post">
                                <input type="hidden" value="<?php echo $trns[$i]['TRANSACTION_ID']; ?>" name="id" />
                                <button class="btn btn-warning" name="edit">Edit</button>
                              </form>
                              <form class="tableform" action="delete_transaction.php" method="post" onsubmit="return deleteConfirmation()">
                                <input type="hidden" value="<?php echo $trns[$i]['TRANSACTION_ID']; ?>" name="id" />
                                <button class="btn btn-danger" name="delete">Delete</button>
                              </form>
                          </p>
                        </td>
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

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.custom.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.uniform.js"></script>
  <script src="js/select2.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/matrix.js"></script>
  <script src="js/matrix.tables.js"></script>
  <script>
    function deleteConfirmation($name) {
      return confirm("Are you sure to delete?");
    }
  </script>
</body>

</html>