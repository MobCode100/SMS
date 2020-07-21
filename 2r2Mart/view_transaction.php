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
  <link rel="stylesheet" href="css/uniform.css" />
  <link rel="stylesheet" href="css/select2.css" />
  <link rel="stylesheet" href="css/matrix-style.css" />
  <link rel="stylesheet" href="css/matrix-media.css" />
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <link href="modalStyle.css" rel="stylesheet">
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
            <div class="widget-title"> <span class="icon"><i class="icon-truck"></i></span>
              <h5>Transactions</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table" style="font-size:medium">
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
                        <td><?php echo $i + 1 ?></td>
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
                              <form class="tableform" id="<?php echo $i + 1 ?>" action="delete_transaction.php" method="post">
                                <input type="hidden" value="<?php echo $trns[$i]['TRANSACTION_ID']; ?>" name="id" />
                                <input type="hidden" name="delete" />
                              </form>
                              <button class="btn btn-danger" onclick="confirm(<?php echo $i + 1 ?>,'<?php echo $trns[$i]['P_NAME'] ?>',<?php echo $trns[$i]['QUANTITY']  ?>)">Delete</button>
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

  <div id="myAlert" class="modal hide fade" style="font-size:15px">
    <div class="modal-header" style="border-radius:6px 6px 0 0">
      <button data-dismiss="modal" class="close" type="button">×</button>
      <h3 style="font-size:15px">Delete confirmation</h3>
    </div>
    <div class="modal-body">
      <p id="deletedialog"></p>
    </div>
    <div class="modal-footer"> <a data-dismiss="modal" id="confirmButton" class="btn btn-primary">Confirm</a> <a data-dismiss="modal" class="btn">Cancel</a> </div>
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
    });

    function confirm(id, name, quantity) {
      $('#deletedialog').html('Are you sure you want to delete this record? <br>No: ' + id + '<br>' + 'Name: ' + name + '<br>' + 'Quantity: ' + quantity);
      $("#confirmButton").click(function() {
        $("#" + id).trigger("submit");
      });
      $('#myAlert').modal('show');
    }
  </script>
</body>

</html>