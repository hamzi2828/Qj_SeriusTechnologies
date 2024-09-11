<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        p {
            margin: 0pt;
        }

        table.items {
            border: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
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
    </style>
</head>
<body>
<?php
    $sale_info = get_lab_sale ( $sale_id );
    if ( $sale_info -> total < 0 ) {
        $text = 'ID#';
    }
    else {
        $text = 'ID#';
    } ?>
<!--mpdf
<htmlpageheader name="myheader">
<?php if ( isset( $_GET[ 'logo' ] ) and $_GET[ 'logo' ] == 'true' ) : ?>
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"></td>
<td width="50%" style="text-align: right;"><img src="<?php echo base_url ( '/assets/img/receipt-site-name.jpeg' ) ?>" style="height: 40px"><br /><span style="font-size: 8pt;"><?php echo hospital_address ?></span><br /><span style="font-family:dejavusanscondensed; font-size: 8pt;">&#9742;</span> <span style="font-size: 8pt;"><?php echo hospital_phone ?></span> <br /></td>
</tr></table>
<?php endif; ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:50%; display:block; text-align:left; float:left">
<?php
    $balance = $sale_info -> total - $sale_info -> paid_amount;
    if ( !empty( $online_report_info ) and $sale_info -> show_online_report == '1' and $balance < 1 ) :
        ?>
<small><b>Get you online report at: <u><?php echo online_report_url ?></u> </b><br></small>
<small><b>Invoice No: <?php echo $online_report_info -> sale_id ?> </b><br></small>
<small><b>Password: <?php echo $online_report_info -> password ?> </b><br></small>
<?php endif; ?>
</div>
<div style="width:50%; display:block; text-align:right; float:right"><small>Created By: <b><?php echo $user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: left; padding-top: 3mm;width:100%; display:block; float:left ">
<span style="color: #FF0000">Please bring this receipt to collect reports.</span><br/>
<span style="color: #FF0000">For any queries related to test results, please contact <?php echo site_name ?> within 48 hours for free review of results.</span>
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<table width="100%" style="font-size: 8pt;">
    <tr>
        <td width="60%">
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
            <b>Mobile: </b><?php echo $patient -> mobile ?><br />
            <b>Age: </b><?php echo get_patient_dob ( $patient ) ?><br />
            <b>Gender: </b>
            <?php
                $sale_info = get_lab_sale ( $sale_id );
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
            <b>Type: </b><?php echo ucfirst ( $patient -> type );
                if ( $patient -> panel_id > 0 )
                    echo ' / ' . get_panel_by_id ( $patient -> panel_id ) -> name ?><br />
            <b>Mode: </b><?php echo str_replace ( '-', ' ', ucwords ( $sale_info -> payment_method ) ) ?>
            <?php
                if ( $sale_info -> reference_id > 0 ) {
                    ?>
                    <br /><b>Referred By: </b><?php echo get_doctor ( $sale_info -> reference_id ) -> name ?>
                    <?php
                }
            ?>
        </td>
        <td width="40%" style="text-align: right">
            <span style="font-size: 12pt"><b><?php echo $text . ' ' . $sale_id ?></b><br /></span>
            <strong>Sampling
                    Date:</strong> <?php echo date ( 'd-m-Y g:i a', strtotime ( $sales[ 0 ] -> date_added ) ) ?>
            <br />
            <strong>Receipt Date:</strong> <?php echo date ( 'd-m-Y' ) . ' ' . date ( 'g:i a' ) ?> <br /> <br />
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3>
                <?php
                    if ( $sale_info -> total < 0 ) {
                        ?>
                        <strong> Refund Invoice </strong>
                    <?php } else { ?>
                        <strong> Sale Invoice </strong>
                    <?php } ?>
            </h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%">Sr. No.</td>
        <td>Code</td>
        <td>Test Name</td>
        <td>Type</td>
        <td>Reporting Date</td>
        <?php if ( $patient -> panel_id < 1 ) : ?>
            <td>Price</td>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        $description  = '';
        $array        = array ();
        $net          = 0;
        $netSalePrice = 0;
        if ( count ( $sales ) > 0 ) {
            $counter   = 1;
            $sale_info = get_lab_sale ( $sale_id );
            foreach ( $sales as $sale ) {
                $test        = get_test_by_id ( $sale -> test_id );
                $details     = get_test_procedure_info ( $sale -> test_id );
                $description = $sale -> remarks;
                
                if ( !empty( $details ) && !empty( trim ( $details -> protocol ) ) )
                    $style = 'color: #FF0000; font-weight: bold';
                else
                    $style = '';
                
                $netSalePrice = $netSalePrice + $sale -> price;
                
                if ( $sale -> parent_id != '' and $sale -> parent_id > 0 )
                    array_push ( $array, $sale -> parent_id );
                
                if ( !in_array ( $sale -> parent_id, $array ) ) {
                    $net = $net + $sale -> price;
                    ?>
                    <tr <?php if ( $sale -> parent_id != '' and $sale -> parent_id > 0 )
                        echo 'parent' ?>>
                        <td align="center" style="<?php echo $style ?>"><?php echo $counter++ ?></td>
                        <td align="center" style="<?php echo $style ?>"><?php echo $test -> code ?></td>
                        <td align="center" style="<?php echo $style ?>"><?php echo $test -> name ?></td>
                        <td align="center" style="<?php echo $style ?>"><?php echo ucfirst ( $test -> type ) ?></td>
                        <td align="center" style="<?php echo $style ?>">
                            <?php
                                if ( !empty( trim ( $sale -> report_collection_date_time ) ) && $sale -> report_collection_date_time !== '1970-01-01 05:00:00' )
                                    echo date ( 'd-m-Y h:i:s A', strtotime ( $sale -> report_collection_date_time ) );
                                else
                                    echo '-';
                            ?>
                        </td>
                        <?php if ( $patient -> panel_id < 1 ) : ?>
                            <td align="center"
                                style="<?php echo $style ?>"><?php echo number_format ( $sale -> price, 2 ) ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            }
            ?>
            <?php
            if ( $patient -> panel_id < 1 ) :
                if ( $sale_info -> total > 0 ) {
                    ?>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Gross Total</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo number_format ( $netSalePrice, 2 ); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Discount(%)</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo $sale_info -> discount; ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Discount(Flat)</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo $sale_info -> flat_discount; ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Net Total</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo number_format ( $sale_info -> total, 2 ); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Paid Amount</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo number_format ( $sale_info -> paid_amount, 2 ); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right; color: #ff0000">
                            <strong>Balance</strong>
                        </td>
                        <td style="text-align: center; color: #ff0000">
                            <h4><?php echo number_format ( $sale_info -> total - $sale_info -> paid_amount, 2 ); ?></h4>
                        </td>
                    </tr>
                    <?php
                }
                else { ?>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Total</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo abs ( $net ); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Discount(%)</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo $sale_info -> discount; ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Refund Amount</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo abs ( $sale_info -> total ); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4" style="text-align: right">
                            <strong>Balance</strong>
                        </td>
                        <td style="text-align: center">
                            <h4><?php echo number_format ( $sale_info -> total - $sale_info -> paid_amount, 2 ); ?></h4>
                        </td>
                    </tr>
                    <?php
                }
            endif;
        }
    ?>
    </tbody>
</table>
<p style="width: 100%; float: left; margin-top: 15px; font-size: 8pt;">
    <?php if ( !empty( trim ( $description ) ) )
        echo '<strong>Remarks: </strong>' . $description; ?>
</p>
<strong style="margin-bottom: 10px">Specimen</strong>
<ul style="list-style-type: decimal; padding-left: 20px; font-size: 8pt;">
    <?php
        if ( count ( $specimens ) > 0 ) {
            foreach ( $specimens as $specimen ) {
                $sample = get_sample_by_id ( $specimen -> sample_id );
                ?>
                <li style="margin-bottom: 5px"><?php echo $sample -> name ?></li>
                <?php
            }
        }
    ?>
</ul>
<br /> <br />
<?php echo $sale_info -> comments ?>
</body>
</html>