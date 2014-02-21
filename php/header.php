<?php
include "functions.php";

/*

        //TODO: nastylovat trosku ten clipboard
        //checkboxy nastylovat v gride

 * dokoncit delete form a porozmyslat nad aktivnym formularom.
 * delete user? asi iba si dam deleted k userovi ktore sa bude nastavovat v db
 * user change password
 * selectbox, radio button ?
 * spravy-> flags checkboxy
 *
 * required nejako nefunguje na openshift asi js chyba pozriet

 *
 *  */


$uri = $_SERVER["REQUEST_URI"];
$a1 = "";
$a2 = "";
$a3 = "";
$a4 = "";
if ($uri == "/form.php") {
    $a1 = "active";
}
if ($uri == "/forms.php") {
    $a2 = "active";
}
if ($uri == "/mails.php") {
    $a3 = "active";
}
if ($uri == "/reply.php") {
    $a4 = "active";
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
        <link href="/stylesheets/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="/stylesheets/css/navbar.css" >
        <link rel="stylesheet" href="/stylesheets/css/custom.css" >
        <link rel="stylesheet" type="text/css" media="screen" href="/js/jqGrid-4.5/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/stylesheets/css/custom-theme/jquery-ui-1.10.3.custom.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="/stylesheets/css/custom-theme/ui.jqgrid.css" />
        <!--<link rel="stylesheet" type="text/css" media="screen" href="/stylesheets/css/custom-theme/jqGrid.overrides.css" />-->

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
                        <li class="<?php echo $a2; ?>"><a href="/forms.php">My forms <span class="badge"><?php echo getNumberOfForms($_SESSION["user_id"]) ?></span></a></li>
                        <li class="<?php echo $a3; ?>"><a href="/mails.php">Customer queries <span class="badge"><?php echo getNumberOfUnread($_SESSION["user_id"]) ?></span></a></li>
                        <li class="<?php echo $a4; ?>"><a href="/reply.php">New message</a></li>
                        <li><a href="#" onclick="TogetherJS(this); return false;">Collaborate</a></li>
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
