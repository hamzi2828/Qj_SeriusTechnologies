<?php header('Content-Type: application/pdf'); ?>
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
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /></span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="width: 100%; display: block; float: left">
    <p style="text-align: right; float: right; display: inline-block; width: 50%;">
        <strong>Receipt Date:</strong> <?php echo date('Y-m-d') ?>
    </p>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Internal Issuance General Report (Medicine) </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Sale ID</th>
        <th> Issued By</th>
        <th> Department</th>
        <th> Medicine</th>
        <th> TP/Unit</th>
        <th> Quantity</th>
        <th> App Amount</th>
        <th> Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $issuance ) > 0 ) {
            $counter = 1;
            $total_tp = 0;
            $sum_app_amount = 0;
            foreach ( $issuance as $item ) {
                $total_app = 0;
                $user = get_user ( $item -> user_id );
                $department = get_department ( $item -> department_id );
                
                $medicines = explode ( ',', $item -> medicines );
                $stocks = explode ( ',', $item -> stocks );
                $quantities = explode ( ',', $item -> quantities );
                $returns = explode ( ',', $item -> returns );
                
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td> <?php echo $item -> sale_id ?> </td>
                    <td> <?php echo $user -> name ?> </td>
                    <td> <?php echo $department -> name ?> </td>
                    <td>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine_id ) {
                                    $medicine = get_medicine ( $medicine_id );
                                    if ( $medicine -> strength_id > 1 )
                                        $strength = get_strength ( $medicine -> strength_id ) -> title;
                                    else
                                        $strength = '';
                                    if ( $medicine -> form_id > 1 )
                                        $form = get_form ( $medicine -> form_id ) -> title;
                                    else
                                        $form = '';
                                    echo $medicine -> name . ' (' . $strength . ' ' . $form . ')' . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $stocks ) > 0 ) {
                                foreach ( $stocks as $key => $stock ) {
                                    $medicineStock = get_stock_by_id ( $stock );
                                    echo number_format ( $medicineStock -> tp_unit, 2 ) . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $quantities ) > 0 ) {
                                foreach ( $quantities as $quantity ) {
                                    echo $quantity . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    
                    <td>
                        <?php
                            if ( count ( $stocks ) > 0 ) {
                                foreach ( $stocks as $key => $stock ) {
                                    $medicineStock = get_stock_by_id ( $stock );
                                    $total_app = $total_app + ( $medicineStock -> tp_unit * $quantities[ $key ] );
                                    $total_tp = $total_tp + $medicineStock -> tp_unit;
                                }
                                $sum_app_amount = $sum_app_amount + $total_app;
                            }
                            echo number_format ( $total_app, 2 )
                        ?>
                    </td>
                    <td> <?php echo date_setter ( $item -> date_added ) ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="5"></td>
                <td>
                    <strong><?php echo number_format ( $total_tp, 2 ) ?></strong>
                </td>
                <td></td>
                <td>
                    <strong><?php echo number_format ( $sum_app_amount, 2 ) ?></strong>
                </td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>