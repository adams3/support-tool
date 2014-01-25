<?php
include "functions.php";

session_start();

if ( $_POST["submit"] == "login" && $_POST["email"] && $_POST["password"]) {
    $user = login($_POST["email"], $_POST["password"]);
    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
    } else {
        header("location:index.php?success=false");
        exit();
    }
}

/*
TODO : Forgot password, bude generovat link na obovu hesla alebo automaticka zmena hesla a poslanie na email
 nadstavba formularov
 config zatial bude robit len advanced, potom sa tam musi vlozit do adresara ktory sa bude volat /md5(customer_ID)/md5(form_ID)/helpdeskForm.js
 je treba tabulka hd_message customer_id + form_id
 *

        //TODO: nastylovat trosku ten clipboard
        //checkboxy nastylovat v gride
        // nahrat to na openshift a vytvorit databazu a nejake test web...
        //napriklad /test na rovnakej domene.
        //!!!!!!!!!!!!!!!!!!!!!!!!!!
        //Pripojit userId a form-id k scriptu pretoze je to potreba ulozit do DB

!!! pri konfiguracii formulara treba vlozit domain
 * upravit vypis a ukladanie sprav podla id zakaznika a formulara
 *
 * urobit nejaky authenticate.php kde bude overovat prihlasenie a vsade si ho includovat.
 *
 * z formularu sa treba vratit spat na vypis

 *
 *  */

if ($_POST["submit"] == "register") {
    $data = $_POST;
    unset($data["submit"]);
    if(register($data)) {
        header("location:index.php?success=registered");
    } else {
        header("location:index.php?success=exists&email=".$data["email"]);
    }
    exit();
}

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    header("location:index.php");
    exit();
}


$uri = $_SERVER["REQUEST_URI"];
$a1 = "";
$a2 = "";
if ($uri == "/main.php") {
    $a1 = "active";
}
if ($uri == "/mails.php") {
    $a2 = "active";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Helpdesk Form Maker</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/navbar.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen" href="/js/jqGrid-4.5/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/css/custom-theme/jquery-ui-1.10.3.custom.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/css/custom-theme/ui.jqgrid.css" />
        <!--<link rel="stylesheet" type="text/css" media="screen" href="/css/custom-theme/jqGrid.overrides.css" />-->

        <!--[if lt IE 9]>
          <script src="../../assets/js/html5shiv.js"></script>
          <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>


        <div id="pager"></div>

        <div class="container">

            <!-- Static navbar -->
            <div class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="main.php">Helpdesk Administration</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $a1; ?>"><a href="/form.php">New Form</a></li>
                        <li class="<?php echo $a1; ?>"><a href="/forms.php">My forms <span class="badge"><?php echo getNumberOfUnread() ?></span></a></li>
                        <li class="<?php echo $a1; ?>"><a href="/mails.php">Customer queries <span class="badge"><?php echo getNumberOfUnread() ?></span></a></li>
                        <li class="<?php echo $a1; ?>"><a href="/reply.php">New message</a></li>
<!--                        <li class="dropdown <?php echo $a2; ?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Helpdesk<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/mails.php">Customer queries</a></li>
                                <li><a href="/reply.php">New message</a></li>-->
                        <!--                                <li class="divider"></li>
                                                        <li class="dropdown-header">Nav header</li>
                                                        <li><a href="#">One more separated link</a></li>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="/logout.php">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">
