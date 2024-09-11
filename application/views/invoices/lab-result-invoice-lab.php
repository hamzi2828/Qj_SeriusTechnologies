<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
            margin-header: 5mm; /* <any of the usual CSS values for margins> */
            margin-footer: 0;
        }

        body {
            font-family: sans-serif;
            font-size: 8pt;
        }

        p {
            margin: 0pt;
        }


        td {
            vertical-align: top;
        }

        .items td {
            border-bottom: 0.1mm dotted #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            /*border: 0.1mm solid #000000;*/
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0.1mm solid #000000;
            font-weight: 800 !important;
        }

        .items td.cost {
            text-align: center;
        }

        .totals {
            font-weight: 800 !important;
        }

        .parent {
            padding-left: 25px;
        }

        .previous-results {
            text-align: left !important;
        }

        .previous-results tr {
            text-align: left !important;
        }

        .previous-results td {
            text-align: left !important;
        }

        .previous-results td:first-child {
            width: 5px !important;
        }

        .previous-results td:nth-child(2) {
            text-align: left !important;
            width: 105px !important;
        }
    </style>
</head>
<body>
<?php
    $note = '';
    if ( isset( $_REQUEST[ 'parent-id' ] ) and !empty( trim ( $_REQUEST[ 'parent-id' ] ) ) ) {
        $testInfo = get_test_by_id ( $_REQUEST[ 'parent-id' ] );
        $note     = $testInfo -> report_footer;
    }
    $verified = get_result_verification_data ( $_GET[ 'sale-id' ], $_GET[ 'id' ] );
?>
<!--mpdf
<htmlpageheader name="myheader">
<?php if ( isset( $_REQUEST[ 'logo' ] ) and $_REQUEST[ 'logo' ] == 'true' ) : ?>
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"></td>
<td width="50%" style="text-align: right;"><img src="<?php echo base_url ( '/assets/img/receipt-site-name.jpeg' ) ?>" style="height: 40px"><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?></span></td>
</tr></table>
<?php endif; ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:left"><small><b>Note:This is a digitally verified report and does not require manual signature.<br></small></b></div>
<b>Verified By:</b><?php echo @get_user ( $verified -> user_id ) -> name ?> <br/>
<b>Date/Time:</b><?php echo @date_setter ( $verified -> created_at ) ?> &nbsp;&nbsp;&nbsp;&nbsp;
<?php if ( isset( $_REQUEST[ 'logo' ] ) and $_REQUEST[ 'logo' ] == 'true' ) : ?>
<div style="width:100%; display:block; text-align:right"><small><b><?php echo $user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 8pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
<?php else : ?>
<div style="border-top: 1px solid #000000; font-size: 8pt; text-align: center; padding-top: 10mm;"></div>
<?php endif; ?>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br />
<p style="width: 100%; text-align: left; color: #000000; font-size: 11px; position: absolute; z-index: 9999">
    <strong>QJ Diagnostic is established in the memory of the beloved mother of Dr. Jamal Nasir (CEO of Citilab) and
            Zubair Nasir</strong>
</p>
<br />
<table width="100%">
    <tr>
        <?php
            $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $_GET[ 'id' ] ) . ',' . encode ( $_GET[ 'sale-id' ] ) . ',' . encode ( $_GET[ 'parent-id' ] ) . ',' . $_GET[ 'machine' ] . ',' . encode ( @$online_report_info -> password );
            
            if ( empty( $airline ) ) {
                ?>
                <td width="50%" style="color:#000; ">
                    <b>Invoice ID: </b><?php echo $_GET[ 'sale-id' ] ?><br />
                    <b>MR Number: </b><?php echo $patient_id ?><br />
                    <b>Name: </b><?php echo $patient -> prefix . ' ' . $patient -> name ?><br />
                    <?php
                        if ( !empty( trim ( $patient -> father_name ) ) && !empty( trim ( $patient -> relationship ) ) )
                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                        if ( !empty( trim ( $patient -> passport ) ) )
                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                        if ( !empty( trim ( $patient -> cnic ) ) )
                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                    ?>
                    <b>Gender: </b>
                    <?php
                        if ( $patient -> gender == '1' )
                            echo 'Male';
                        else if ( $patient -> gender == '0' )
                            echo 'Female';
                        else if ( $patient -> gender == '2' )
                            echo 'MC';
                        else if ( $patient -> gender == '3' )
                            echo 'FC';
                    ?>
                    <br />
                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?><br />
                    <?php
                        if ( $patient -> panel_id > 0 ) {
                            ?>
                            <b>Panel: </b><?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?><br />
                            <?php
                        }
                        if ( $sale -> reference_id > 0 ) {
                            ?>
                            <b>Referred By: </b><?php echo get_doctor ( $sale -> reference_id ) -> name ?><br />
                            <?php
                        }
                    ?>
                </td>
                <td width="50%" style="text-align: right;">
                    <img src="https://quickchart.io/qr?text=<?php echo $barcodeValue ?>&size=120" />
                </td>
                <?php
            }
            else {
                ?>
                <td width="30%" style="color:#000; ">
                    <span style="font-size: 14px"><b>Invoice ID: </b><?php echo $_GET[ 'sale-id' ] ?></span><br />
                    <b>MR Number: </b><?php echo $patient_id ?><br />
                    <b>Name: </b><?php echo $patient -> prefix . ' ' . $patient -> name ?><br />
                    <?php
                        if ( !empty( trim ( $patient -> father_name ) ) && !empty( trim ( $patient -> relationship ) ) )
                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                        if ( !empty( trim ( $patient -> passport ) ) )
                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                        if ( !empty( trim ( $patient -> cnic ) ) )
                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                    ?>
                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?><br />
                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?><br />
                    <?php
                        if ( $patient -> panel_id > 0 ) {
                            ?>
                            <b>Panel: </b><?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?><br />
                            <?php
                        }
                        if ( $sale -> reference_id > 0 ) {
                            ?>
                            <b>Referred By: </b><?php echo get_doctor ( $sale -> reference_id ) -> name ?><br />
                            <?php
                        }
                    ?>
                </td>
                <td width="30%" style="color:#000; ">
                    <b>Flight No: </b><?php echo $airline -> flight_no ?><br />
                    <b>Ticket No: </b><?php echo $airline -> ticket_no ?><br />
                    <b>Destination: </b><?php echo $airline -> destination ?><br />
                    <b>Flight Date: </b><?php echo date_setter ( $airline -> flight_date ) ?><br />
                    <b>PNR: </b><?php echo $airline -> pnr ?><br />
                    <b>Airline: </b><?php echo @get_airlines_by_id ( $airline -> airline_id ) -> title ?><br />
                    <b>Nationality: </b><?php echo $patient -> nationality ?><br />
                    <b>Referred By: </b><?php echo $airline -> ref_by ?><br />
                </td>
                <td width="15%" style="color:#000; ">
                    <?php if ( $airline -> show_picture == '1' ) : ?>
                        <img src="<?php echo $patient -> picture; ?>" style="height: 100px">
                    <?php endif; ?>
                </td>
                <td width="25%" style="text-align: right;">
                    <img src="https://quickchart.io/qr?text=<?php echo $barcodeValue ?>&size=120" />
                </td>
                <?php
            }
        ?>
    </tr>
</table>

<div style="text-align: right; float:left; width: 100%; display: block">
    <strong>Sample Date:</strong> <?php echo date_setter ( $sale -> date_sale ) ?>
    <br />
    <strong>Date/Time:</strong> <?php echo date ( 'd-m-Y' ) . ' ' . date ( 'g:i a' ) ?>
    <br />
    <br />
</div>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 15px; border: 0"
       cellpadding="8" border="0">
    <thead>
    <tr style="background: #f5f5f5;">
        <th align="left">Test Name</th>
        <th align="left">
            Results
        </th>
        <?php if ( count ( $tests ) > 0 && $tests[ 0 ] -> hide_previous_results != '1' ) : ?>
            <th colspan="2" align="center">
                Previous Results
            </th>
        <?php endif ?>
        <th align="left">Units</th>
        <th align="left">Reference Ranges</th>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $test_info  = get_test_by_id ( $test -> test_id );
                $unit       = get_test_unit_id_by_id ( $test -> test_id );
                $ranges     = get_reference_ranges_by_test_id ( $test -> test_id );
                $isParent   = check_if_test_has_sub_tests ( $test -> test_id );
                $isChild    = check_if_test_is_child ( $test -> test_id );
                $testIDS    = get_child_tests_ids ( $test -> test_id );
                $sampleInfo = get_test_sample_info ( $test -> test_id );
                $result_id  = $_REQUEST[ 'id' ];
                if ( !empty( $testIDS -> ids ) )
                    $subTests = get_lab_test_results_by_ids ( $test -> sale_id, $testIDS -> ids, $result_id );
                else
                    $subTests = array ();
                
                $previous_results = get_previous_test_results ( $test -> sale_id, $test -> test_id );
                
                if ( !empty( $sampleInfo ) and $test_info -> parent_id < 1 ) {
                    $section_id = $sampleInfo -> section_id;
                    $section    = get_section_by_id ( $section_id );
                    if ( !empty( $section ) ) {
                        ?>
                        <tr>
                            <td colspan="2">
                                <h3 style="color: #ff0000"> <?php echo $section -> name ?> </h3>
                            </td>
                            <?php
                                if ( $tests[ 0 ] -> hide_previous_results != '1' ) :
                                    if ( count ( $previous_results ) > 0 ) {
                                        foreach ( $previous_results as $key => $previous_result ) {
                                            ?>
                                            <td align="center">
                                                <?php echo date ( 'd-m-Y', strtotime ( $previous_result -> date_added ) ) ?>
                                            </td>
                                            <?php
                                        }
                                    }
                                    $td = 2 - count ( $previous_results );
                                    for ( $loop = 1; $loop <= $td; $loop++ ) {
                                        echo '<td></td>';
                                    }
                                endif;
                            ?>
                            <td colspan="2"></td>
                        </tr>
                        <?php
                    }
                }
                else {
                    ?>
                    <tr>
                        <td colspan="2"></td>
                        <?php
                            if ( $tests[ 0 ] -> hide_previous_results != '1' ) :
                                if ( count ( $previous_results ) > 0 ) {
                                    foreach ( $previous_results as $key => $previous_result ) {
                                        ?>
                                        <td align="center">
                                            <?php echo date ( 'd-m-Y', strtotime ( $previous_result -> date_added ) ) ?>
                                        </td>
                                        <?php
                                    }
                                }
                                $td = 2 - count ( $previous_results );
                                for ( $loop = 1; $loop <= $td; $loop++ ) {
                                    echo '<td></td>';
                                }
                            endif;
                        ?>
                        <td colspan="2"></td>
                    </tr>
                    <?php
                }
                
                ?>
                <tr>
                    <td align="left" <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent )
                        echo '';
                    else if ( $test_info -> parent_id < 1 )
                        echo ''; ?>>
                    <span <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent )
                        echo 'style="font-weight: 900; font-size: 12px"' . $test_info -> name;
                    else if ( $test_info -> parent_id < 1 )
                        echo 'style="font-weight: 900; font-size: 10px"'; ?>>
                        <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent or $test_info -> parent_id < 1 )
                            echo '<strong>' . $test_info -> name . '</strong>';
                        else echo $test_info -> name ?>
                    </span>
                    </td>
                    
                    <td align="left" style="<?php if ( $test -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo $test -> result; ?>
                    </td>
                    
                    <?php
                        if ( $tests[ 0 ] -> hide_previous_results != '1' ) :
                            if ( count ( $previous_results ) > 0 ) {
                                foreach ( $previous_results as $previous_result ) {
                                    ?>
                                    <td align="center">
                                        <?php echo @$previous_result -> result; ?>
                                    </td>
                                    <?php
                                }
                                $td = 2 - count ( $previous_results );
                                for ( $loop = 1; $loop <= $td; $loop++ ) {
                                    echo '<td></td>';
                                }
                            }
                            else {
                                echo '<td colspan="2" align="center">-</td>';
                            }
                        endif;
                    ?>
                    
                    <td align="left" <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent )
                        echo '';
                    else if ( $test_info -> parent_id < 1 )
                        echo ''; ?>><?php echo @get_unit_by_id ( $unit ) ?></td>
                    <td align="left" <?php if ( ( isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) or $isParent )
                        echo '';
                    else if ( $test_info -> parent_id < 1 )
                        echo ''; ?>>
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ' . $range -> start_range . '-' . $range -> end_range . '<br/>';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
                
                if ( count ( $subTests ) > 0 ) {
                    foreach ( $subTests as $key => $subTest ) {
                        $sub_test_info = get_test_by_id ( $subTest -> test_id );
                        $sub_unit      = @get_test_unit_id_by_id ( $subTest -> test_id );
                        $sub_ranges    = get_reference_ranges_by_test_id ( $subTest -> test_id );
                        if ( !empty( trim ( $subTest -> result ) ) ) {
                            ?>
                            <tr>
                                <td align="left" style="padding-left: 15px">
                                    <?php
                                        if ( $subTest -> test_id == 935 or $subTest -> test_id == 951 )
                                            echo '<strong style="font-size: 14px">' . $sub_test_info -> name . '</strong>';
                                        else
                                            echo $sub_test_info -> name;
                                    ?>
                                </td>
                                <td align="left" style="<?php if ( $subTest -> abnormal == '1' )
                                    echo 'color: #FF0000; font-weight: bold' ?>">
                                    <?php echo @$subTest -> result; ?>
                                </td>
                                <?php
                                    if ( $tests[ 0 ] -> hide_previous_results != '1' ) :
                                        if ( count ( $previous_results ) > 0 ) {
                                            foreach ( $previous_results as $previous_result ) {
                                                $previousResultTestIDS = get_child_tests_ids ( $previous_result -> test_id );
                                                $previousSubTests      = get_lab_test_results_by_ids ( $previous_result -> sale_id, $previousResultTestIDS -> ids, $previous_result -> id );
                                                ?>
                                                <td align="center">
                                                    <?php echo @$previousSubTests[ $key ] -> result; ?>
                                                </td>
                                                <?php
                                            }
                                            $td = 2 - count ( $previous_results );
                                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                                echo '<td></td>';
                                            }
                                        }
                                        else {
                                            echo '<td colspan="2" align="center">-</td>';
                                        }
                                    endif;
                                ?>
                                <td align="left"><?php echo @get_unit_by_id ( $sub_unit ) ?></td>
                                <td align="left">
                                    <?php
                                        if ( count ( $sub_ranges ) > 0 ) {
                                            foreach ( $sub_ranges as $sub_range ) {
                                                if ( !empty( trim ( $sub_range -> gender ) ) )
                                                    echo '<b>' . ucwords ( str_replace ( 'f', 'F', $sub_range -> gender ) ) . '</b>: ' . $sub_range -> start_range . '-' . $sub_range -> end_range . '<br/>';
                                            }
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
        }
    ?>
    </tbody>
</table>
<div class="remarks">
    <h3>Remarks:</h3>
    <?php
        $machine = get_test_parameters ( @$_GET[ 'parent-id' ] );
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $test_info = get_test_by_id ( $test -> test_id );
                ?>
                <span>
                    <?php
                        if ( count ( $remarks ) > 0 ) {
                            foreach ( $remarks as $remark ) {
                                $remarkInfo = get_remarks_by_id ( $remark -> remarks_id );
                                echo $remarkInfo -> remarks . '<br/>';
                            }
                        }
                    ?>
                    <?php echo !empty( trim ( $test -> remarks ) ) ? $test -> remarks : '' ?>
                </span>
                <br />
                
                <?php
            }
        }
        if ( !empty( $machine ) and !empty( trim ( $machine -> machine_name ) ) )
            echo '<br/><small><b>Performed On: ' . $machine -> machine_name . '</b></small>';
    ?>
</div>
<?php
    if ( !empty( trim ( $note ) ) )
        echo '<span style="font-size: 12px">' . $note . '</span>';
?>
</body>
</html>