<?php 
session_start();
if(isset($_SESSION['EMP_ID'])){
    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>2r2 Mart</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/matrix-login.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
    <div id="loginbox">
        <form id="loginform" class="form-vertical" method="post" action="loginp.php">
            <div class="control-group normal_text">
                <h3><img src="img/logo2.png" alt="Logo" /> </h3>
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
</body>

</html>