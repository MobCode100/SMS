<?php
include 'functions.php';
session_start();
if (isset($_SESSION['EMP_ID'])) {
    header('Location: dashboard.php');
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
    <link rel="stylesheet" href="css/matrix-login.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="modalStyle.css" rel="stylesheet">
</head>

<body>
    <div id="loginbox">
        <form id="loginform" class="form-vertical" method="post" action="loginp.php">
            <div class="control-group normal_text">
                <h3><img src="img/logo2.png" alt="Logo" style="width: 33%;" /> </h3>
                <h3 style="font-family: 'Fredoka One', cursive;font-weight:100;font-size:27px">2r2 Mart's Inventory System</h3>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"> </i></span><input name="u_email" type="text" placeholder="Email" required />
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span><input name="u_pass" type="password" placeholder="Password" required />
                    </div>
                </div>
            </div>
            <div>
                <center>
                    <span class="none"><button type="submit" name="login" class="btn btn-large btn-success" /> Login</button></span>
                </center>
            </div>
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/matrix.login.js"></script>
    <script src="js/bootstrap.min.js"></script>
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