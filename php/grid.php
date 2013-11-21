<?php

include 'database.php';

// to the url parameter are added 4 parameters as described in colModel
// we should get these parameters to construct the needed query
// Since we specify in the options of the grid that we will use a GET method
// we should use the appropriate command to obtain the parameters.
// In our case this is $_GET. If we specify that we want to use post
// we should use $_POST. Maybe the better way is to use $_REQUEST, which
// contain both the GET and POST variables. For more information refer to php documentation.
// Get the requested page. By default grid sets this to 1.
$page = $_GET['page'];

// get how many rows we want to have into the grid - rowNum parameter in the grid
$limit = $_GET['rows'];

// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel
$sidx = $_GET['sidx'];

// sorting order - at first time sortorder
$sord = $_GET['sord'];

// if we not pass at first time index use the first column for the index or what you want
if (!$sidx)
    $sidx = 1;

// calculate the number of rows for the query. We need this for paging the result
//$result = mysql_query("SELECT COUNT(*) AS count FROM invheader");
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


//$s .= "<rows>";
//$s .= "<page>" . $page . "</page>";
//$s .= "<total>" . $total_pages . "</total>";
//$s .= "<records>" . $count . "</records>";
//
//// be sure to put text data in CDATA
//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
//    $s .= "<row id='" . $row['invid'] . "'>";
//    $s .= "<cell>" . $row['invid'] . "</cell>";
//    $s .= "<cell>" . $row['invdate'] . "</cell>";
//    $s .= "<cell>" . $row['amount'] . "</cell>";
//    $s .= "<cell>" . $row['tax'] . "</cell>";
//    $s .= "<cell>" . $row['total'] . "</cell>";
//    $s .= "<cell><![CDATA[" . $row['note'] . "]]></cell>";
//    $s .= "</row>";
//}
//$s .= "</rows>";
//$json = '"{"name":"askdj","surname":"sakdj","number":"sakdj","message":"dsakjd"}"';

$rowsArr = array();
foreach ($rows as $i => $row) {
    $rowsArr[$i]["id"] = $i;
    $rowsArr[$i]["cell"][] = $row["id"];
    $rowsArr[$i]["cell"][] = date("d.m.Y H:i:s", strtotime($row["date_create"]));
    $rowsArr[$i]["cell"][] = $row["read"];
    $rowsArr[$i]["cell"][] = $row["flag"];
    $rowsArr[$i]["cell"][] = $row["replied"];
}


//$rowsArr[2]["id"] = 2;
//$rowsArr[2]["cell"][] = 1;
//$rowsArr[2]["cell"][] = 2;
//$rowsArr[2]["cell"][] = 3;
//$rowsArr[2]["cell"][] = 4;


// najst na nete jak parsot array prave pre jqgrid json
// ako ma vyzerat json pre jqgrid.. How to.
//xml necem
// skusit najst dibi s jqgridem nekde rozchodene
// je treba pouzit dibi? asi ano


$resultArr = array();
$resultArr ["page"] = $page;
$resultArr ["total"] = $total_pages;
$resultArr ["records"] = $count;
$resultArr ["rows"] = $rowsArr;

function fix_keys($array) {
    foreach ($array as $k => $val) {
        if (is_array($val)) {
            $array[$k] = fix_keys($val); //recurse
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
//echo $count;
echo $js;

//$js = '{
//  "page": "1",
//  "records": "10",
//  "total": "2",
//  "rows": [
//      {
//          "id": 3,
//          "cell": [
//              1,
//              "teaasdfasdf",
//              "2010-09-28T21:49:21",
//              "2010-09-28T21:49:21"
//          ]
//      },
//      {
//          "id": 1,
//          "cell": [
//              1,
//              "teaasdfasdf",
//              "2010-09-28T21:49:21",
//              "2010-09-28T21:49:21"
//          ]
//      }
//  ]
//}';
?>



