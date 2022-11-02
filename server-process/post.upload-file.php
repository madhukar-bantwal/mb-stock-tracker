<?php

/**
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PROJECT_NAME') OR exit();

// File Configs
$allowed_ext = ['csv'];
$allowed_mimes = ['text/csv','application/vnd.ms-excel'];
$allowed_size = "2097152"; //Bytes // - 2097152 = 2MB // 550000 = 550KB // 350000 = 350 KB  500000 = 500 KB
$Extension = "";

if(isset($_FILES['clientFile']) && !empty($_FILES['clientFile']) && $_FILES['clientFile']['error'] == 0) {

    $dataName = $_FILES['clientFile']['name'];
    $dataSize = $_FILES['clientFile']['size'];
    $dataTmpName  = $_FILES['clientFile']['tmp_name'];
    $dataType = $_FILES['clientFile']['type'];
    $dataTmp = explode('.', $dataName);
    $Extension = strtolower(end($dataTmp));

    $csvData = array_map('str_getcsv', file($_FILES['clientFile']['tmp_name']));

}

// Start

if(!isset($_POST['clientName']) || $_POST['clientName'] == "" || strlen($_POST['clientName']) > "30") {
    echo "<script> Swal.fire('','Please enter valid Name'); </script>";
}
elseif(!isset($_FILES['clientFile']['name']) || empty($_FILES['clientFile']['name']) || $_FILES['clientFile']['tmp_name'] == NULL) {
    echo "<script> Swal.fire('','Please select valid CSV File'); </script>";
}
elseif($_FILES['clientFile']['error'] != 0 || !is_uploaded_file($_FILES['clientFile']['tmp_name'])) {
    echo "<script> Swal.fire('','File not uploaded [E01]'); </script>";
}
elseif(!isset($dataType) || !in_array($Extension, $allowed_ext) || !in_array($dataType, $allowed_mimes)) {
    echo "<script> Swal.fire('','Unsupported file format'); </script>";
}
elseif(!isset($dataSize) || !empty($_FILES['clientFile']['name']) && $dataSize > $allowed_size) {
    echo "<script> Swal.fire('','Maximum file size set to 2MB'); </script>";
}
elseif(!isset($csvData) || $csvData == false || !is_array($csvData) || count($csvData) < "2") {
    echo "<script> Swal.fire('','Upload valid file'); </script>";
}
else {

    $StockList = array();

    foreach($csvData as $key => $stock) {
        
        if($key == 0) { continue; } // Skip header
        $lineNum = $key + 1; // CSV Line Number

        if(!isset($stock[1]) || $stock[1] == "" || $webApp->valid_date($stock[1], "d-m-Y") == false) {
            echo "<script> Swal.fire('','Invalid Date at Line {$lineNum}'); </script>";
            exit();
        }
        elseif(!isset($stock[2]) || $stock[2] == "") {
            echo "<script> Swal.fire('','Invalid Stock Name at Line {$lineNum}'); </script>";
            exit();
        }
        elseif(!isset($stock[3]) || $stock[3] == "" || !is_numeric($stock[3])) {
            echo "<script> Swal.fire('','Invalid Stock Name at Line {$lineNum}'); </script>";
            exit();
        }
        else {

            //Sort Stock-wise
            $stockCode = $webApp->strSafeInput($stock[2]);
            $StockList[$stockCode][] = array(
                $stock[1],
                $stock[3]
            );

        }

    }

    //Process List
    if(count($StockList) < "1") {
        echo "<script> Swal.fire('','No stocks available in uploaded file'); </script>";
        exit();
    } else {

        $htmlOp = "<option value=''>-- Select --</option>";

        foreach($StockList as $stockCode => $value) {
            $jsonString = json_encode(array($stockCode => $value));
            $safeString = $webApp->strEncrypt($jsonString, $_SESSION['SessionKey']);
            $htmlOp .= "<option value='{$safeString}'>{$stockCode}</option>";
        }

        echo "<script>";
        echo " $('#hidClientName').val('".$webApp->strEncrypt($_POST['clientName'], $_SESSION['SessionKey'])."'); ";
        echo " $('#stockSelected').html('".$webApp->jsEscape($htmlOp)."'); ";
        echo " $('#tab-nav-2').trigger('click'); ";
        echo "</script>";

    }
    

}