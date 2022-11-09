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

        $finalBuyAmt = "";
        $finalBuyDate = "";
        $finalSellAmt = "";
        $finalSellDate = "";

        // Calculate
        $minPrice = PHP_INT_MAX;
        $maxPrice = PHP_INT_MAX;
        $maxProfit = 0;
        $buyDate = $filtered_list[0][0];
        $sellDate = $filtered_list[count($filtered_list) - 1][0];
        $priceList = array();

        for($i=0; $i<count($filtered_list); $i++) {
            $priceList[] = $filtered_list[$i][1];
            if ($filtered_list[$i][1] < $minPrice) {
                $minPrice = $filtered_list[$i][1];
                $buyDate = $filtered_list[$i][0];
            }
            else if ($filtered_list[$i][1] - $minPrice > $maxProfit) {
                //$maxProfit = $filtered_list[$i][1] - $minPrice;
                $newProfit = $filtered_list[$i][1] - $minPrice;
                $maxPrice = $filtered_list[$i][1];
                $sellDate = $filtered_list[$i][0];
            }
            if(isset($newProfit) && $newProfit > $maxProfit) {
                $maxProfit = $newProfit;
                $finalBuyAmt = $minPrice;
                $finalBuyDate = $buyDate;
                $finalSellAmt = $maxPrice;
                $finalSellDate = $sellDate;
            }
        }

        //standard deviation
        function standDeviation($arr) { 
            if(is_array($arr) && $arr != false) {
                $num_of_elements = count($arr);
                $variance = 0.0;
                $average = array_sum($arr)/$num_of_elements; 
                foreach($arr as $i) {
                    $variance += pow(($i - $average), 2); 
                }
                $number = (float)sqrt($variance/$num_of_elements);
                return number_format((float)$number, 2, '.', '');
            }
        }

        //Mean
        function calcMean($arr) {
            if(is_array($arr) && $arr != false) {
                $number = array_sum($arr) / count($arr);
                return number_format((float)$number, 2, '.', '');
            } 
        }
        

        echo "<script>";
        echo " $('#opStockAction').html('".$webApp->jsEscape("{$clientName} will be buying {$_POST['stockQty']} qty. {$stockName[0]} shares")."'); ";
        echo " $('#buyDate').val('".$webApp->jsEscape($finalBuyDate)."'); ";
        echo " $('#buyPrice').val('".$webApp->jsEscape($minPrice)."'); ";
        echo " $('#sellDate').val('".$webApp->jsEscape($finalSellDate)."'); ";
        echo " $('#sellPrice').val('".$webApp->jsEscape($maxPrice)."'); ";
        echo " $('#shareProfit').val('".$webApp->jsEscape($maxProfit)."'); ";
        echo " $('#totalProfit').val('".$webApp->jsEscape(($maxProfit * $_POST['stockQty']))."'); ";
        echo " $('#standDeviation').val('".$webApp->jsEscape(standDeviation($priceList))."'); ";
        echo " $('#calcMean').val('".$webApp->jsEscape(calcMean($priceList))."'); ";
        echo " $('#tab-nav-3').trigger('click'); ";
        echo "</script>";

    }

}
