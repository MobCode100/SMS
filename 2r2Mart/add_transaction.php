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
require("Connection.php");
$con = new Connection();
$page_title = "Transaction";
$action = "insert_transaction.php";
$product = '0';
$quantity = 0;
if (isset($_POST['edit'])) {
  $tid = $_POST['id'];
  $page_title = "Edit Transaction";
  $action = "edit_transaction.php";
  $data = $con->query("SELECT * FROM TRANSACTION WHERE transaction_id = ?", [$tid]);
  if ($data != null) {
    $product = $data[0]['PRODUCT_ID'];
    $quantity = $data[0]['QUANTITY'];
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
  <link rel="stylesheet" href="css/uniform.css" />
  <link rel="stylesheet" href="css/select2.css" />
  <link rel="stylesheet" href="css/matrix-style.css" />
  <link rel="stylesheet" href="css/matrix-media.css" />
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
  <link href="modalStyle.css" rel="stylesheet">
</head>

<body>
  <!--top-Header-menu-->
  <?php include("topheadermenu.php"); ?>
  <!--sidebar-menu-->

  <?php include("sidebar.php"); ?>

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current"><?php echo $page_title ?></a> </div>
      <h1><?php echo $page_title ?></h1>
    </div>

    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span9" id="formT">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-plus"></i> </span>
              <h5>Stock In</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="<?php echo $action ?>" method="post" class="form-horizontal" onsubmit="return Submit()">
                <?php if (isset($_POST['edit'])) {
                  if ($data != null) { ?>
                    <input type="hidden" name="tid" value="<?php echo $tid; ?>" />
                    <input type="hidden" name="old_product" value="<?php echo $product; ?>" />
                    <input type="hidden" name="old_quantity" value="<?php echo $quantity; ?>" />
                <?php }
                } ?>
                <div class="control-group">
                  <label class="control-label">Product</label>
                  <div class="controls">
                    <select class="span5" name="product" id="select_p">
                      <option value="0">Select a product</option>
                      <?php
                      $products = $con->query("select * from product", []);
                      if ($products != null) {
                        for ($i = 0; $i < count($products); $i++) {
                      ?>
                          <option value="<?php echo $products[$i]['PRODUCT_ID'] ?>"><?php echo $products[$i]['NAME'] ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Quantity</label>
                  <div class="controls">
                    <input type="number" min="1" max="99999" placeholder="Quantity" name="quantity" value="<?php echo $quantity ?>" class="span5" required>
                  </div>
                </div>
                <div class="form-actions" align="right">
                  <button type="submit" name="sBut" class="btn btn-success">Submit</button>
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
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.custom.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.uniform.js"></script>
  <script src="js/select2.min.js"></script>
  <script src="js/matrix.js"></script>
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
    $(document).ready(function() {
      $("#select_p").val('<?php echo $product ?>');
    });

    function Submit() {
      console.log(document.getElementById('select_p').value);
      var val = document.getElementById('select_p').value
      if (val == 0) {
        $('#error_text').html('<button class="close" data-dismiss="modal">×</button><strong>Error!</strong> &nbsp;Please select a product');
        $('#myModalError').modal('show');
        return false;
      } else {
        return true;
      }
    }
    var Width = $('#formT').width();
    $("#formT").css("margin-left", "calc((100% - " + Width + "px)/2)");
  </script>
  <script src="js/matrix.form_common.js"></script>
</body>

</html>