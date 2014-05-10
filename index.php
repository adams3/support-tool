<?php

/**
 * Application bootstrap. Index of the whole document. Sign in form
 *
 * @author Adam Studenic
 *
 */

session_start();
if (isset($_SESSION["user_id"]) && isset($_SESSION["email"])) {
    header("location:main.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign in form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="/stylesheets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/stylesheets/css/signin.css" rel="stylesheet" media="screen">
        <link href="/stylesheets/css/custom.css" rel="stylesheet" media="screen">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="../../assets/js/html5shiv.js"></script>
          <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">

            <form id="formLogIn" name="formLogIn" class="form-signin" method="post" action="main.php">
                <h2 class="form-signin-heading">Log in</h2>
                <?php
                    if (isset($_GET["success"]) && $_GET["success"] == "false") {
                        echo "<div class='alert alert-danger'>Log in was not successful</div>";
                    } elseif (isset($_GET["success"]) && $_GET["success"] == "true") {
                        echo "<div class='alert alert-success'>Logout was successful</div>";
                    } elseif (isset($_GET["success"]) && $_GET["success"] == "registered") {
                        echo "<div class='alert alert-success'>Registration was successful.</div>";
                    } elseif (isset($_GET["success"]) && $_GET["success"] == "changedPassword") {
                        echo "<div class='alert alert-success'>Password was changed successfully. You should expect an email with new password to this address: \"" . $_GET["email"] . "\"</div>";
                    } elseif (isset($_GET["success"]) && $_GET["success"] == "exists") {
                        echo "<div class='alert alert-danger'>Email \"" . $_GET["email"] . "\" already exists in our system. Log in please.<br><a href='#' class='forgotPassword'>Forgot password?</a></div>";
                    } elseif (isset($_GET["success"]) && $_GET["success"] == "not-exists") {
                        echo "<div class='alert alert-danger'>Email \"" . $_GET["email"] . "\" does not exists in our system. Sign up please.<br><a href='#' class='notRegistered'>Sign up</a></div>";
                    }
                ?>
                <input name="email" type="email" class="form-control" placeholder="Email address" autofocus required>
                <input name="password" type="password" class="form-control" placeholder="Password" required>
                <label class="checkbox">
                    <input name="remember" type="checkbox" value="remember-me"> Remember Me
                </label>
                <input name="submit" type="text" value="login" class="display-none">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
                <button class="notRegistered btn btn-lg btn-info btn-block" >Not Registered?</button>
                <button class="forgotPassword btn btn-lg btn-default btn-block" >Forgot Password?</button>

            </form>

            <form id="formSignUp" name="formSignUp" class="form-signin display-none" method="post" action="main.php">
                <h2 class="form-signin-heading">Sign up</h2>
                <input name="name" type="text" class="form-control top" placeholder="Name" required>
                <input name="surname" type="text" class="form-control bottom" placeholder="Surname" required>
                <input name="email" type="email" class="form-control top" placeholder="Email address" required>
                <input name="password" type="password" class="form-control bottom" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
                <button class="btn btn-lg btn-info btn-block backToLogin" >Back to Log In</button>
                <input name="submit" type="text" value="register" class="display-none">
            </form>

            <form id="formForgotPassword" name="formForgotPassword" class="form-signin display-none" method="post" action="main.php">
                <h2 class="form-signin-heading">Forgot password?</h2>
                <input name="email" type="email" class="form-control mb10" placeholder="Email address" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Reset password</button>
                <button class="btn btn-lg btn-info btn-block backToLogin" >Back to Log In</button>
                <input name="submit" type="text" value="forgotPassword" class="display-none">
            </form>

<?php
require_once 'footer.php';
?>
