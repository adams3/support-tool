<?php
$configFile = "config/configure.json";

$json = json_decode(file_get_contents($configFile), true);
session_start();

if ($_SESSION["login"] != $json["admin"]["login"]) {

    if ($json["admin"]["login"] == $_POST["login"] && $json["admin"]["password"] == $_POST["password"]) {
        $_SESSION["login"] = $_POST["login"];
        $_SESSION["password"] = md5($_POST["password"]);
    } else {
        if ($_POST) {
            header("location:index.php?success=false");
        } else {
            header("location:index.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">


        <title>Support Form Maker</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/navbar.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="../../assets/js/html5shiv.js"></script>
          <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="container">

            <!-- Static navbar -->
            <div class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="#">Support Form Admin</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Form Maker</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Helpdesk <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Reply to customers</a></li>
                                <li><a href="#">Write new</a></li>
                                <li><a href="#">Customer list</a></li>
                                <!--                                <li class="divider"></li>
                                                                <li class="dropdown-header">Nav header</li>
                                                                <li><a href="#"></a></li>
                                                                <li><a href="#">One more separated link</a></li>-->
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="/logout.php">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>

            <!-- Main component for a primary marketing message or call to action -->
            <div class="jumbotron">
                <h1>Edit Your Form</h1>
                <!--<p>
                    <a class="btn btn-lg btn-primary" href="#">View navbar docs &raquo;</a>
                </p>-->
            </div>
            <div class="well well-new">
                <form id="supportForm" class="form-horizontal" name="config-form" role="form" action="save-form.php" method="post">
                    <div class="add mt15">
                        <div class=" no-pl">

                        </div>
                    </div>
                    <div id="rows">
                        <div class="row well well-new-2">
                            <div class="col-sm-6 no-pl">
                                <label for="formActionInput">Form action</label>
                                <input name="form-action" type="text" class="form-control input-new" id="formActionInput" placeholder="Message us">
                            </div>
                            <div class="col-sm-6 no-pl">
                                <label for="sendFormTo">Send form to</label>
                                <input name="send-to" type="text" class="form-control input-new" id="sendFormTo" placeholder="example@me.com">
                            </div>
                        </div>
                        <div class="row well well-new-2">
                            <div class="col-sm-6 no-pl">
                                <label for="directUrl">URL where to direct the form</label>
                                <input name="url" type="text" class="form-control input-new" id="directUrl" placeholder="http://www.example.com/submit.php">
                            </div>

                            <div class="col-sm-6 no-pl">
                                <label for="phone">Phone no.</label>
                                <input name="phone" type="text" class="form-control input-new" id="phone" placeholder="+421 902 308 767">
                            </div>
                            <div class="col-sm-6 no-pl">
                                <label for="skype">Skype name</label>
                                <input name="skype" type="text" class="form-control input-new" id="skype" placeholder="Skype nickname">
                            </div>
                        </div>
                        <div class="row well well-new-2">
                            <div class="col-sm-2 no-pl">
                                <label>Name</label>
                            </div>
                            <div class=" col-sm-2 no-pl">
                                <label>Label</label>
                            </div>
                            <div class=" col-sm-2 no-pl">
                                <label>Type</label>
                            </div>
                            <div class="col-sm-2 no-pl">
                                <label>Placeholder</label>
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label>ID</label>
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label>Class</label>
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label>Required</label>
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label>Action</label>
                            </div>
                        </div>
                        <div id="0" class="row well well-new-2 display-none">
                            <div class="col-sm-2 no-pl">
                                <label class="sr-only" for="nameInput">Name</label>
                                <input name="name" type="name" class="form-control input-new" id="nameInput" placeholder="Name">
                            </div>
                            <div class=" col-sm-2 no-pl">
                                <label class="sr-only" for="labelInput">Label</label>
                                <input name="label" type="text" class="form-control input-new" id="labelInput" placeholder="Label">
                            </div>
                            <div class=" col-sm-2 no-pl">
                                <select name="type" class="form-control input-new">
                                    <option>text</option>
                                    <option>email</option>
                                    <option>checkbox</option>
                                    <option>textarea</option>
                                    <option>password</option>
                                </select>
                            </div>
                            <div class="col-sm-2 no-pl">
                                <label class="sr-only" for="exampleInputPassword2">Placeholder</label>
                                <input name="placeholder" type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="Placeholder">
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label class="sr-only" for="exampleInputPassword2">ID</label>
                                <input name="ID" type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="ID">
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label class="sr-only" for="exampleInputPassword2">Class</label>
                                <input name="class" type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="Class">
                            </div>
                            <div class="checkbox col-sm-1">
                                <label>
                                    <input name="required"type="checkbox" class=""> Required
                                </label>
                            </div>
                            <div class="col-sm-1 no-pl">
                                <button class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="add mt15">
                        <div class=" col-md-12 no-pl">
                            <button id="addNew" type="submit" class="btn btn-success">Add new input</button>
                        </div>
                    </div>

                    <div class="separator mt15"/></div>

                    <div class="center mt15">
                        <div class=" col-md-12 no-pl">
                            <button id="submitForm" type="submit" class="btn btn-primary">Submit form</button>
                        </div>
                    </div>
                </form>



<!--                <div  id="sp-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Message us</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" action="submit.php" id="sp-support-form">
                                                    <input type="hidden" value="' + location.href + '" name="loc">
                                                    <input type="hidden" name="nav" value="' + navigator.appName + '">
                                                    <div class="form-group">
                                                        <label for="sp-f-e">Label</label>
                                                        <input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required>
                                                        <label for="sp-f-e">Type</label>
                                                        <input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required>
                                                        <label for="sp-f-e">Placeholder</label>
                                                        <input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required>
                                                        <label for="sp-f-e">Class</label>
                                                        <input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required>
                                                        <label for="sp-f-e">Id</label>
                                                        <input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required>
                                                        <label for="sp-f-e">Required true/false</label>
                                                        <input type="email" class="form-control" id="sp-f-e" placeholder="Enter email" name="mail" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="sp-f-m">Message</label>
                                                        <textarea id="sp-f-m" class="form-control" name="message" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-lg btn-primary">Submit message</button>
                                                    <a class="btn btn-lg btn-default" href="skype:' + skype + '?call">Call the Skype</a>
                                                    <a href="tel:' + tel + '" class="btn btn-lg btn-default">Call ' + tel + '</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->


            </div> <!-- /container -->

    <script src="js/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/custom.js"></script>
</body>
</html>
