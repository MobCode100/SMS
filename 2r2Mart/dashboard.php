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
</head>

<body>
  <!--top-Header-menu-->
  <?php include("topheadermenu.php"); ?>


  <!--sidebar-menu-->

  <?php include("sidebar.php"); ?>

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Dashboard</a> </div>
      <h1>Dashboard</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">

          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-shopping-cart"></i></span>
              <h5>All Product</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  require("Connection.php");
                  $con = new Connection();
                  $all_product = $con->query("select p.name,p.description,p.price,p.quantity,s.name supplier
                  from product p join supplier s on s.supplier_id = p.supplier_id", []);
                  if ($all_product != null) {
                    for ($i = 0; $i < count($all_product); $i++) {
                  ?>
                      <tr class="gradeX">
                        <td><?php echo $all_product[$i]['NAME'] ?></td>
                        <td><?php echo $all_product[$i]['DESCRIPTION'] ?></td>
                        <td><?php echo $all_product[$i]['PRICE'] ?></td>
                        <td><?php echo $all_product[$i]['QUANTITY'] ?></td>
                        <td><?php echo $all_product[$i]['SUPPLIER'] ?></td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-warning-sign"></i></span>
              <h5>Low Stock Product</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($all_product != null) {
                    for ($i = 0; $i < count($all_product); $i++) {
                      if ($all_product[$i]['QUANTITY'] <= 50) {
                  ?>
                        <tr class="gradeX">
                          <td><?php echo $all_product[$i]['NAME'] ?></td>
                          <td><?php echo $all_product[$i]['DESCRIPTION'] ?></td>
                          <td><?php echo $all_product[$i]['PRICE'] ?></td>
                          <td><?php echo $all_product[$i]['QUANTITY'] ?></td>
                          <td><?php echo $all_product[$i]['SUPPLIER'] ?></td>
                        </tr>
                  <?php
                      }
                    }
                  }
                  ?>
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
</body>

</html>