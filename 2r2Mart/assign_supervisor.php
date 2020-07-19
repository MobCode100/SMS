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
<?php
require("Connection.php");
$con = new Connection();
$con1 = new Connection();
$con2 = new Connection();
if(isset($_POST['Save'])){
$changed = $_POST['supername'];
$result_explode = explode('|', $changed);
//echo "Sup: ". $result_explode[0]."<br />";
//echo "Emp: ". $result_explode[1]."<br />";
$result = $con->query("SELECT * FROM EMPLOYEE WHERE NAME = ? ",[$result_explode[0]]);

if($result != null)
{
  $result1 = $con1->query("UPDATE EMPLOYEE SET SUPERVISOR_ID = ?  WHERE EMP_ID = ? ",[$result[0]['EMP_ID'],$result_explode[1]]);
  echo "<script Language = 'javascript'>
          alert ('Supervisor have been updated' ) ;
          window.location('assign_supervisor.php')</script>" ;
}
else {
    echo "<script Language = 'javascript'>
            alert ('Invalid username/password!' ) ;
            window.location('assign_supervisor.php') </script>" ;
  }
}
if(isset($_POST['Delete'])){
$changed = $_POST['supername'];
$result_explode = explode('|', $changed);
//echo "Sup: ". $result_explode[0]."<br />";
//echo "Emp: ". $result_explode[1]."<br />";
$result = $con->query("SELECT * FROM EMPLOYEE WHERE NAME = ? ",[$result_explode[0]]);

if($result != null)
{
  $result1 = $con1->query("UPDATE EMPLOYEE SET SUPERVISOR_ID = ?  WHERE EMP_ID = ? ",[null,$result_explode[1]]);
  echo "<script Language = 'javascript'>
          alert ('Supervisor have been updated' ) ;
          window.location('assign_supervisor.php')</script>" ;
}
else {
    echo "<script Language = 'javascript'>
            alert ('Invalid username/password!' ) ;
            window.location('assign_supervisor.php') </script>" ;
  }
}

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
</head>

<body>
  <!--top-Header-menu-->
  <?php include("topheadermenu.php"); ?>
  <!--sidebar-menu-->

  <?php include("sidebar.php"); ?>
  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Current Employee</a> </div>
      <h1>Current Employee</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-user"></i></span>
              <h5>Current Employee</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th><font size="2px">Name</font></th>
                    <th><font size="2px">Email</font></th>
                    <th><font size="2px">Phone No</font></th>
                    <th><font size="2px">Job Position</font></th>
                    <th><font size="2px">Current Supervisor</font></th>
                    <th><font size="2px">Assign/Edit Supervisor</font></th>
                  </tr>
                </thead>
                <?php
                $result = $con->query("SELECT * FROM EMPLOYEE",[]);
                for($i=0 ; $i<count($result); $i++)
                { ?>
                <tbody>
                  <tr class="gradeX">
                    <td><font size="2px"><?php echo $result[$i]['NAME'];?></font></td>
                    <td><font size="2px"><?php echo $result[$i]['EMAIL'];?></font> </td>
                    <td><font size="2px"><?php echo $result[$i]['PHONENO'];?></font></td>
                    <?php
                    if($result[$i]['JOB_ID'] == 1)
                    {
                      $job = "MANAGER";
                    }
                    else {
                      $job = "EMPLOYEE";
                    }    ?>
                    <td><font size="2px"><?php echo $job;?></font></td>
                    <?php
                    if($result[$i]['SUPERVISOR_ID'] == null)
                    {
                      ?> <td><font size="2px"><?php echo "Not Yet Assigned";?></font></td>
                  <?php  }
                    else {
                      $result2 = $con->query("SELECT * FROM EMPLOYEE WHERE EMP_ID = ?",[$result[$i]['SUPERVISOR_ID'],]);
                      for($k=0 ; $k<count($result2); $k++)
                      {
                      $s_name = $result2[$k]['NAME'];}
                      ?>  <td><font size="2px"><?php echo $s_name;?></font></td>
                    <?php }
                    ?>
                    <form action="assign_supervisor.php" method="post">
                    <td><p><center><div class="control-group">

                      <div class="controls">
                        <select name="supername">
                          <?php
                          $super = $con ->query("SELECT * FROM EMPLOYEE WHERE JOB_ID =?",[3,]);
                          for($j=0 ; $j<count($super); $j++){
                          $name = $super[$j]['NAME'];
                          $id =  $result[$i]['EMP_ID'];?>
                          <option name="supername" value="<?php echo $name."|".$id;?>"><?php echo $super[$j]['NAME'];?></option>
                        <?php }?>
                        </select>
                      </div>
                    </div>
                    <?php
                    $emp_id = $result[$i]['EMP_ID'];
                    ?>
                    <input type="hidden" name="changed_super" value="$emp_id">
                    <div class="row-fluid">
                      <div class="center">
                      <button type="submit" name="Save" class="btn btn-success">Save</button>
                      <button type="submit" name="Delete" class="btn btn-danger">No Supervisor</button></p>
                    </div>
                  </div>
                        </td></form>
                  </tr>
                <?php }?>
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
