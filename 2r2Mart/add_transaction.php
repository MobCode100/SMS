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

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <SCRIPT language="javascript">
    function addRow(tableID) {

      var table = document.getElementById(tableID);

      var rowCount = table.rows.length;
      var row = table.insertRow(rowCount);

      var colCount = table.rows[0].cells.length;

      for(var i=0; i<colCount; i++) {

        var newcell	= row.insertCell(i);

        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch(newcell.childNodes[0].type) {
          case "text":
              newcell.childNodes[0].value = "";
              break;
          case "checkbox":
              newcell.childNodes[0].checked = false;
              break;
          case "select-one":
              newcell.childNodes[0].selectedIndex = 0;
              break;
        }
      }
    }

    function deleteRow(tableID) {
      try {
      var table = document.getElementById(tableID);
      var rowCount = table.rows.length;

      for(var i=0; i<rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[0].childNodes[0];
        if(null != chkbox && true == chkbox.checked) {
          if(rowCount <= 1) {
            alert("Cannot delete all the rows.");
            break;
          }
          table.deleteRow(i);
          rowCount--;
          i--;
        }


      }
      }catch(e) {
        alert(e);
      }
    }

  </SCRIPT>
  </head>
  <body>

  <!--Header-part-->
  <div id="header">
    <h1><a href="dashboard.html">2r2 Mart</a></h1>
  </div>
  <!--close-Header-part-->

  <!--top-Header-menu-->
  <?php include("topheadermenu.html"); ?>


  <!--sidebar-menu-->
  <?php include("sidebar.html"); ?>
  <!--close-left-menu-stats-sidebar-->

  <div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Transaction</a> </div>
    <h1>Transaction</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Stock In</h5>
          </div>
          <div class="widget-content nopadding">
            <form form class="" action="index.html" method="post">

              <div class="control-group">
                  <INPUT type="button" value="Add Row" onclick="addRow('dataTable')" />
                  <INPUT  type="button" value="Delete Row" onclick="deleteRow('dataTable')" />
              </div>
              <TABLE id="dataTable" >
            		<TR>
            			<TD><INPUT type="checkbox" name="chk"/></TD>
            			<p></p>
            			<TD>
            				Product:
            				<SELECT name="product">
            					<OPTION value=" ">Choose a Product 1</OPTION>
                      <OPTION value=" ">Choose a Product 2</OPTION>
                      <OPTION value=" ">Choose a Product 3</OPTION>

            				</SELECT>

            			</TD><p></p>
            			<TD>Quantity: <INPUT type="text" name="txt"/></TD>
            		</TR>
            	</TABLE>



              <div align="right" class="form-actions">
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div></div>
  
  </body>
  </html>
