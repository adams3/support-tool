<?php
$configFile = "config/configure.json";

$json = json_decode(file_get_contents($configFile), true);
session_start();

if ($_SESSION["login"] == $json["login"]) {
    header("location:main.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign in form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/signin.css" rel="stylesheet" media="screen">
    <link href="css/custom.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <div class="container">



    <form name="form1" class="form-signin" method="post" action="main.php">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php
    if($_GET["success"]=="false"){
        echo "<div class='has-error'>Log in was not successful</div>";
    }
?>

        <input name="login" type="text" class="form-control" placeholder="Email address" autofocus>
        <input name="password" type="password" class="form-control" placeholder="Password">
        <label class="checkbox">
          <input name="remember" type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

    <script src="js/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
