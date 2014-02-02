<?php
include "functions.php";

$json = array();
$data = array();

if($_POST) {

    $data["id"] = (int) $_POST["formId"];
    unset($_POST["formId"]);

    $json["form"] = $_POST;
    $data["config"] = json_encode($json);
    $data["user_id"] = $_SESSION["user_id"];

    $formId = saveFormConfig($data);

    if(!$formId) {
        $data["config"] = "error";
    }

//$data["config"]["new"] = "true";

    $jsonArr = $data["config"];


    //nacpat new do formulara!!!!!!!!!!!!!!!!!


//    $jsonArr->formId = $formId;

//    var_dump($formId);die;


//    if($formId == $data["id"]) {
//        $jsonArr->new = "true";
//    } else {
//        $jsonArr->new = "false";
//    }


}

header('Content-Type: application/json');
echo $jsonArr;
?>
