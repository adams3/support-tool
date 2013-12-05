<?php

include 'database.php';

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
if (!$sidx)
    $sidx = 1;

$result = dibi::query('SELECT COUNT(*) AS count FROM `hd_message`');
$count = $result->fetchSingle();


// calculate the total pages for the query
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}

// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages) {
    $page = $total_pages;
}

// calculate the starting position of the rows
$start = $limit * $page - $limit;

// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
if ($start < 0)
    $start = 0;

// the actual query for the grid data
$SQL = "SELECT * FROM hd_message ORDER BY $sidx $sord LIMIT $start , $limit";


try {
    $result = dibi::query($SQL);
    $rows = $result->fetchAll();
} catch (DibiException $e) {
    var_dump($e);
};

$rowsArr = array();
foreach ($rows as $i => $row) {
    $rowsArr[$i]["id"] = $i;
    $rowsArr[$i]["cell"][] = $row["id"];
    $rowsArr[$i]["cell"][] = date("d.m.Y H:i:s", strtotime($row["date_create"]));
    $message = (array) json_decode($row["message"]);
    $formatedMessage = "";
    foreach($message as $key => $input) {
        $formatedMessage .= $key . " : " . $input . "\n" ;
    }
    $rowsArr[$i]["cell"][] = $formatedMessage;

    $rowsArr[$i]["cell"][] = $row["read"];
    $rowsArr[$i]["cell"][] = $row["flag"];
    $rowsArr[$i]["cell"][] = $row["replied"];
}

$resultArr = array();
$resultArr ["page"] = $page;
$resultArr ["total"] = $total_pages;
$resultArr ["records"] = $count;
$resultArr ["rows"] = $rowsArr;

function fix_keys($array) {
    foreach ($array as $k => $val) {
        if (is_array($val)) {
            $array[$k] = fix_keys($val); //recursion
        }
        if (is_numeric($k)) {
            $numberCheck = true;
        }
    }
    if ($numberCheck === true) {
        return array_values($array);
    } else {
        return $array;
    }
}

$arrrr = fix_keys($resultArr);

$js = json_encode($arrrr, JSON_PRETTY_PRINT);
echo $js;

?>



