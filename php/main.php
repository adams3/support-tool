<?php
$configFile = "config/configure.json";

$json = json_decode(file_get_contents($configFile), true);
session_start();

if ($_SESSION["login"] != $json["login"]) {

    if ($json["login"] == $_POST["login"] && $json["password"] == $_POST["login"]) {
        $_SESSION["login"] = $_POST["login"];
        $_SESSION["password"] = md5($_POST["password"]);
    } else {
        if($_POST){
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

                
                        <li><a href="#">Link</a></li>
                        <li><a href="#">Link</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="./">Default</a></li>
                        <li><a href="../navbar-static-top/">Static top</a></li>
                        <li><a href="../navbar-fixed-top/">Fixed top</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>

            <!-- Main component for a primary marketing message or call to action -->
            <div class="jumbotron">
                <h1>Edit Your Form</h1>
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
                                        Urobit to draggable aby sa mohlo menit poradie tych inputov,
                                        Nazov celeho formulara,
                                        Info o clientovi,
                                        Submit button
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



<!--                <p>
                    <a class="btn btn-lg btn-primary" href="#">View navbar docs &raquo;</a>
                </p>-->
            </div>
            <div class="well well-new">
                <form id="supportForm" class="form-horizontal" role="form">
                    <div id="rows">
                        <div id="1" class="row well well-new-2">
                            <div class="col-sm-2 no-pl">
                                <label class="sr-only" for="nameInput">Name</label>
                                <input type="name" class="form-control input-new" id="nameInput" placeholder="Name">
                            </div>
                            <div class=" col-sm-2 no-pl">
                                <label class="sr-only" for="labelInput">Label</label>
                                <input type="text" class="form-control input-new" id="labelInput" placeholder="Label">
                            </div>
                            <div class=" col-sm-2 no-pl">
                                <select class="form-control input-new">
                                    <option>text</option>
                                    <option>email</option>
                                    <option>checkbox</option>
                                    <option>texteare</option>
                                    <option>password</option>
                                </select>
                            </div>
                            <div class="col-sm-2 no-pl">
                                <label class="sr-only" for="exampleInputPassword2">Placeholder</label>
                                <input type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="Placeholder">
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label class="sr-only" for="exampleInputPassword2">ID</label>
                                <input type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="ID">
                            </div>
                            <div class="col-sm-1 no-pl">
                                <label class="sr-only" for="exampleInputPassword2">Class</label>
                                <input type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="Class">
                            </div>
                            <div class="checkbox col-sm-1">
                                <label>
                                    <input type="checkbox" class=""> Required
                                </label>
                            </div>
                            <div class="col-sm-1 no-pl">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="add">
                        <div class=" col-md-12 no-pl">
                            <button id="addNew" type="submit" class="btn btn-success">Add new input</button>
                        </div>
                    </div>
                </form>
            </div>
                <h1>Navbar example</h1>
                <p>This example is a quick exercise to illustrate how the default, static navbar and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
                <p>
                    <a class="btn btn-lg btn-primary" href="#">View navbar docs &raquo;</a>
                </p>
            </div>

        </div> <!-- /container -->

        <script src="js/jquery-1.10.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script src="js/custom.js"></script>
    </body>
</html>
