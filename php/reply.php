<?php
include 'database.php';
require_once 'header.php';

$id = $_GET["id"];
$SQL = "SELECT * FROM hd_message WHERE id = $id";


try {
    $result = dibi::query($SQL);
    $row = $result->fetchAll();
} catch (DibiException $e) {
    var_dump($e);
};

$row = $row[0];

var_dump($row["id"]);


// TODO zmenit formular a vyplnit mailto addCC Bcc atd a spravu dat a napojit na mailgun



?>


<div class="well well-new">

    <form id="supportForm" class="form-horizontal" name="config-form" role="form" action="save-form.php" method="post">
        <div class="center">
            <div class=" col-md-12 no-pl">
                <input id="reset" type="reset" class="btn btn-danger" value="Reset Form To Default Values">
                <button id="setBack" class="btn btn-primary display-none" >Go back</button>
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
                <!--                        </div>
                                        <div class="row well well-new-2">-->
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
            <br>
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
                    <label>Id</label>
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
            <div id="row0" class="row-copy row well well-new-2 display-none">
                <div class="col-sm-2 no-pl">
                    <label class="sr-only" for="nameInput">Name</label>
                    <input name="name" type="name" class="form-control input-new" id="nameInput" placeholder="Name" data-hd-type="name">
                </div>
                <div class=" col-sm-2 no-pl">
                    <label class="sr-only" for="labelInput">Label</label>
                    <input name="label" type="text" class="form-control input-new" id="labelInput" placeholder="Label" data-hd-type="label">
                </div>
                <div class=" col-sm-2 no-pl">
                    <select name="type" class="form-control input-new" data-hd-type="type">
                        <option value="text">text</option>
                        <option value="email">email</option>
                        <option value="checkbox">checkbox</option>
                        <option value="textarea">textarea</option>
                        <option value="password">password</option>
                    </select>
                </div>
                <div class="col-sm-2 no-pl">
                    <label class="sr-only" for="exampleInputPassword2">Placeholder</label>
                    <input name="placeholder" type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="Placeholder" data-hd-type="placeholder">
                </div>
                <div class="col-sm-1 no-pl">
                    <label class="sr-only" for="exampleInputPassword2">ID</label>
                    <input name="id" type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="Id" data-hd-type="id">
                </div>
                <div class="col-sm-1 no-pl">
                    <label class="sr-only" for="exampleInputPassword2">Class</label>
                    <input name="class" type="text" class="form-control input-new" id="exampleInputPassword2" placeholder="Class" data-hd-type="class">
                </div>
                <div class="checkbox col-sm-1">
                    <label>
                        <input name="required"type="checkbox" class="" data-hd-type="required"> Required
                    </label>
                </div>
                <div class="col-sm-1 no-pl">
                    <button class="btn btn-danger remove remove-row">Remove</button>
                </div>
            </div>
        </div>
        <div class="add mt15">
            <div class=" col-md-12 no-pl">
                <button id="addNewRow" type="submit" class="btn btn-success">Add new input</button>
            </div>
        </div>

        <br>
        <div class="separator mt15"/></div>
<br>

<div id="buttons">
    <div class="row well well-new-2">
        <div class="col-sm-2 no-pl">
            <label>Text</label>
        </div>
        <div class=" col-sm-2 no-pl">
            <label>Type</label>
        </div>
        <div class=" col-sm-2 no-pl">
            <label>Color</label>
        </div>
        <div class="col-sm-2 no-pl">
            <label>Action</label>
        </div>
    </div>
    <div id="button0" class="button-copy row well well-new-2 display-none">
        <div class="col-sm-2 no-pl">
            <label class="sr-only" for="nameInput">Label</label>
            <input name="label" type="name" class="form-control input-new" id="nameInput" placeholder="Label" data-hd-type="label">
        </div>
        <div class=" col-sm-2 no-pl">
            <select name="type" class="form-control input-new" data-hd-type="type">
                <option value="submit">submit</option>
                <option value="skype">skype</option>
                <option value="mobile">mobile phone</option>
            </select>
        </div>
        <div class="col-sm-2 no-pl">
            <select name="color" class="form-control input-new" data-hd-type="color">
                <option value="default">default</option>
                <option value="red">red</option>
                <option value="blue">blue</option>
            </select>
        </div>
        <div class="col-sm-1 no-pl">
            <button class="btn btn-danger remove remove-button">Remove</button>
        </div>
    </div>
</div>

<div class="add mt15">
    <div class=" col-md-12 no-pl">
        <button id="addNewButton" type="submit" class="btn btn-success">Add new input</button>
    </div>
</div>

<br>
<div class="separator mt15"/></div>

<div class="center mt15">
    <div class=" col-md-12 no-pl">
        <button id="submitForm" type="submit" class="btn btn-primary">Submit & show form</button>
    </div>
</div>
</form>
</div> <!-- /container -->


<?php
require_once 'footer.php';
?>