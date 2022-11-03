<?php

/**
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PROJECT_NAME') OR exit();

// Get Name
if(isset($_POST['clientName']) && $_POST['clientName'] != "") {
    $clientName = $webApp->strDecrypt($_POST['clientName'], $_SESSION['SessionKey']);
}

// Get Stock Selected
if(isset($_POST['stockSelected']) && $_POST['stockSelected'] != "") {
    $stockSelected = $webApp->strDecrypt($_POST['stockSelected'], $_SESSION['SessionKey']);
    if($stockSelected) {
        $stockSelected = json_decode($stockSelected, true);
        $stockName = array_keys($stockSelected);
        $stockData = $stockSelected[$stockName[0]];
    }
}

if(isset($_POST['fromDate']) && $_POST['fromDate'] != "") {
    $fromDateFormat = DateTime::createFromFormat('d-m-Y', $_POST['fromDate']);
    //$fromDate = $fromDateFormat->format('Y-m-d');
}

if(isset($_POST['uptoDate']) && $_POST['uptoDate'] != "") {
    $uptoDateFormat = DateTime::createFromFormat('d-m-Y', $_POST['uptoDate'] );
    //$uptoDate = $uptoDateFormat->format('Y-m-d');
}

// Start

if(!isset($clientName) || $clientName == false || $clientName == NULL || $clientName == "") {
    echo "<script> Swal.fire('','Invalid Request, Please refresh & start again!'); </script>";
}
elseif(!isset($_POST['stockSelected']) || $_POST['stockSelected'] == "") {
    echo "<script> Swal.fire('','Please select stock'); </script>";
}
elseif(!isset($stockSelected) || $stockSelected == false || !is_array($stockSelected)) {
    echo "<script> Swal.fire('','Invalid Request, Please refresh & start again!'); </script>";
}
elseif(!isset($_POST['stockQty']) || $_POST['stockQty'] == NULL || $_POST['stockQty'] == "" || !is_numeric($_POST['stockQty'])) {
    echo "<script> Swal.fire('','Enter valid stock quantity'); </script>";
}
elseif(!isset($_POST['fromDate']) || $_POST['fromDate'] == "" || $webApp->check_date_exists($_POST['fromDate']) == false) {
    echo "<script> Swal.fire('','Enter valid from date'); </script>";
}
elseif(!isset($_POST['uptoDate']) || $_POST['uptoDate'] == "" || $webApp->check_date_exists($_POST['uptoDate']) == false) {
    echo "<script> Swal.fire('','Enter valid upto date'); </script>";
}
elseif(!isset($stockName[0]) || $stockName[0] == NULL || $stockName[0] == "") {
    echo "<script> Swal.fire('','Invalid Request, Please refresh & start again! [E1]'); </script>";
}
elseif(!isset($stockData) || !is_array($stockData) || count($stockData) < "1") {
    echo "<script> Swal.fire('','Invalid Request, Please refresh & start again! [E2]'); </script>";
}
elseif($fromDateFormat > $uptoDateFormat) {
    echo "<script> Swal.fire('','Upto date should be greater than From date'); </script>";
}
else {

    $rangeStart = strtotime($fromDateFormat->format('Y-m-d'));
    $rangeEnd = strtotime($uptoDateFormat->format('Y-m-d'));

    //Filter with Date Range
    $filtered_list = array_filter($stockData, function($var) use ($rangeStart, $rangeEnd) {  
        $stockDate = strtotime($var[0]);
        return $stockDate <= $rangeEnd && $stockDate >= $rangeStart;
    });

    if(!is_array($filtered_list) || count($filtered_list) < "1") {
        echo "<script> Swal.fire('','No records between selected date range'); </script>";
    }
    elseif(count($filtered_list) < "2") {
        echo "<script> Swal.fire('','No multiple records available for selected date range'); </script>";
    } 
    else {

        // Calculate
        $profit = 0;
        $max = 0;
        $min = PHP_INT_MAX;

        foreach($filtered_list as $record) {
            if($record[1] < $min) {
                $min = $record[1];
                $buyDate = $record[0];
            } else {
                $profit = max($profit, $record[1] - $min);
                $max = $record[1];
                $sellDate = $record[0];
            }
        }
    
        echo "<script>";
        echo " $('#opStockAction').html('".$webApp->jsEscape("{$clientName} will be buying {$_POST['stockQty']} qty. {$stockName[0]} shares")."'); ";
        echo " $('#buyDate').val('".$webApp->jsEscape($buyDate)."'); ";
        echo " $('#buyPrice').val('".$webApp->jsEscape($min)."'); ";
        echo " $('#sellDate').val('".$webApp->jsEscape($sellDate)."'); ";
        echo " $('#sellPrice').val('".$webApp->jsEscape($max)."'); ";
        echo " $('#shareProfit').val('".$webApp->jsEscape($profit)."'); ";
        echo " $('#totalProfit').val('".$webApp->jsEscape(($profit * $_POST['stockQty']))."'); ";
        echo " $('#tab-nav-3').trigger('click'); ";
        echo "</script>";

    }

}
