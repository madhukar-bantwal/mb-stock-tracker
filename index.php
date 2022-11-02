<?php

/**
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** System Core */
require_once(dirname(__FILE__) . '/system/auto-load.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>

    <title><?php echo PROJECT_NAME; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/ico"/>
    <link rel="stylesheet" href="theme/css/style.css?v=<?php echo PROJECT_VERSION; ?>" type="text/css" media="screen"/>

</head>
<body>

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container px-4">
            <div class="navbar-brand w-100 text-center"><?php echo PROJECT_NAME; ?></div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container main-div">
        <div class="card">
        <div class="card-body box-min-h400">

            <ul class="nav nav-tabs" id="myTab" role="tablist" style="display: none;">
            <li class="nav-item"><a class="nav-link active" id="tab-nav-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">tab 1</a></li>
            <li class="nav-item"><a class="nav-link" id="tab-nav-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">tab 2</a></li>
            <li class="nav-item"><a class="nav-link" id="tab-nav-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">tab 3</a></li>
            </ul>

            <div class="tab-content mb-4" id="myTabContent">

                <h5 class="card-title mt-3 mb-4 text-center">Stock Profit & Loss Estimator</h5>

                <!-- Tab 1 : Start -->
                <div class="tab-pane show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
                <form id="form-upload" name="form-upload" method="post" action="javascript:void(null);" class="form-material">
                <input type="hidden" name="cmd" value="upload_file"/>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Enter your Name <req>*</req></label>
                            <div class="col-md-12">
                            <input type="text" name="clientName" id="clientName" value="Joe" placeholder="" maxlength="30" class="form-control border-input js-characters js-capitalize" autocomplete="none" onload="$this.focus();">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Stock Historic Pricing in CSV Format  <req>*</req>
                            </label>
                            <div class="col-md-12">
                            <input type="file" class="form-control-file" accept=".csv" id="clientFile" name="clientFile">
                            <div class="small mt-2">
                                <a href="uploads/sample-file.csv" class="text-secondary">Download Sample Format</a>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3 px-3">
                        <div class="col-md-5 form-group text-center px-4">
                            <a href="javascript:void(0);" id="btn1" class="btn btn-info btn-block" onClick="uploadFile();">Upload File <i class="mdi mdi-cloud-upload"></i></a>
                        </div>
                    </div>
                
                </form>
                </div>

                <!-- Tab 2 : Start -->
                <div class="tab-pane" id="tab-2" role="tabpanel" aria-labelledby="tab-2">
                <form id="form-stocks" name="form-stocks" method="post" action="javascript:void(null);" class="form-material">
                <input type="hidden" name="cmd" value="stock_estimate"/>
                <input type="hidden" name="clientName" id="hidClientName" value=""/>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Select Stock <req>*</req></label>
                            <div class="col-md-12">
                            <select name="stockSelected" id="stockSelected" class="form-control border-input select2">
                                <option value="">-- Select --</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Stock Quantity <req>*</req></label>
                            <div class="col-md-12">
                            <input type="tel" name="stockQty" id="stockQty" value="200" placeholder="" maxlength="5" class="form-control border-input js-numeric" autocomplete="none">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">From Date <req>*</req></label>
                            <div class="col-md-12">
                            <input type="text" name="fromDate" id="fromDate" placeholder="" class="form-control border-input date" autocomplete="none">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Upto Date <req>*</req></label>
                            <div class="col-md-12">
                            <input type="text" name="uptoDate" id="uptoDate" placeholder="" class="form-control border-input date" autocomplete="none">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4 px-3">
                        <div class="col-md-5 form-group text-center px-4">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" id="btn2" class="btn btn-info btn-block" onClick="estimateStock();">Proceed <i class="mdi mdi-arrow-right"></i></a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-secondary btn-block" onClick="cancelBtn();">Cancel </a>
                            </div>
                        </div>
                        </div>
                    </div>

                </form>
                </div>

                <!-- Tab 3 : Start -->
                <div class="tab-pane" id="tab-3" role="tabpanel" aria-labelledby="tab-3">

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Action</label>
                            <div class="col-md-12">
                            <textarea class="form-control border-input readonly" id="opStockAction" rows="2" readonly="true"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <div class="row">
                            <div class="col-md-6 form-group">
                                    <label class="col-md-12 text-dark">Buy Date</label>
                                    <div class="col-md-12">
                                    <input type="text" id="buyDate" class="form-control border-input readonly" autocomplete="none" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-md-12 text-dark">Buy Price <i class="mdi mdi-currency-inr"></i></label>
                                    <div class="col-md-12">
                                    <input type="text" id="buyPrice" class="form-control border-input readonly" autocomplete="none" readonly="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <div class="row">
                            <div class="col-md-6 form-group">
                                    <label class="col-md-12 text-dark">Sell Date</label>
                                    <div class="col-md-12">
                                    <input type="text" id="sellDate" class="form-control border-input readonly" autocomplete="none" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-md-12 text-dark">Sell Price <i class="mdi mdi-currency-inr"></i></label>
                                    <div class="col-md-12">
                                    <input type="text" id="sellPrice" class="form-control border-input readonly" autocomplete="none" readonly="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Per Share Profit <i class="mdi mdi-currency-inr"></i></label>
                            <div class="col-md-12">
                            <input type="text" id="shareProfit" class="form-control border-input readonly" autocomplete="none" readonly="true">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 form-group">
                            <label class="col-md-12 text-dark">Trade Profit <i class="mdi mdi-currency-inr"></i></label>
                            <div class="col-md-12">
                            <input type="text" id="totalProfit" class="form-control border-input readonly" autocomplete="none" readonly="true">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3 px-3">
                        <div class="col-md-5 form-group text-center px-4">
                            <a href="javascript:void(0);" id="btn1" class="btn btn-secondary btn-block" onClick="goBack();"><i class="mdi mdi-arrow-left"></i> Go Back</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </div>
        
        <div class="footer">
            &copy; <?php echo date('Y') . " " . DEVELOPER; ?>
        </div>

    </div>


    <div id="dy-result"></div>

    <!-- JavaScript -->
    <script src="theme/js/jquery.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/propper.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/base-bs.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/loader.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/select2.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/moment.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/datepicker.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/sweetalert2.js?v=<?php echo PROJECT_VERSION; ?>"></script>
    <script src="theme/js/app-layout.js?v=<?php echo PROJECT_VERSION; ?>"></script>

    <!-- Custom Scripts -->
    <script type="text/javascript">

        function uploadFile() {
            let clientName = $('#clientName').val();
            if(clientName && clientName != "") {
                postRequest('form-upload','btn1');
            } else {
                Swal.fire('','Please enter valid Name');
            }
        }

        function cancelBtn() {
            $('#tab-nav-1').trigger('click');
        }

        function goBack() {
            $('#tab-nav-2').trigger('click');
        }

        function estimateStock() {
            let clientName = $('#hidClientName').val();
            let stockSelected = $('#stockSelected').val();
            let stockQty = $('#stockQty').val();
            let fromDate = $('#fromDate').val();
            let uptoDate = $('#uptoDate').val();

            if(!clientName || clientName == "") {
                Swal.fire('','Invalid Request, Please start again!');
            }
            else if(!stockSelected || stockSelected == "") {
                Swal.fire('','Select Stock');
            }
            else if(!stockQty || stockQty == "") {
                Swal.fire('','Enter Quantity');
            }
            else if(!fromDate || fromDate == "") {
                Swal.fire('','Select From Date');
            }
            else if(!uptoDate || uptoDate == "") {
                Swal.fire('','Select Upto Date');
            } else {
                postRequest('form-stocks','btn2');
            }

        }

        //Custom
        $(document).ready(function() {
        
            $('.select2').select2({ width: '100%' });

        // From Date
        $("#fromDate").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            locale: {
            format: 'DD-MM-YYYY', // Format
            },
            autoUpdateInput: false,
        }, function(chosen_date) {
            $('#fromDate').val(chosen_date.format('DD-MM-YYYY'));
        });

        $('input[name="fromDate"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });

        //Upto Date
        $("#uptoDate").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            locale: {
            format: 'DD-MM-YYYY', // Format
        },
            autoUpdateInput: false,
        }, function(chosen_date) {
            $('#uptoDate').val(chosen_date.format('DD-MM-YYYY'));
        });

        $('input[name="uptoDate"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });
        
        });

    </script>

</body>
</html>