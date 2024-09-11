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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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
        
        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"><br><br /><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /></span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo $user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> IPD Consultant Commissioning </strong> </h3>
        </td>
    </tr>
</table>
<br>

<br>
<h3 style="font-weight: 600 !important;text-decoration: underline;"> IPD Services </h3>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Patient EMR</th>
        <th> Patient Name</th>
        <th> Cash/Panel</th>
        <th> Sale ID</th>
        <th> Consultant Name</th>
        <th> Service(s)</th>
        <th> Commission</th>
        <th> Medication</th>
        <th> Lab</th>
        <th> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $net = 0;
        $medicationNet = 0;
        $labNet = 0;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $patient = get_patient ( $sale -> patient_id );
                $net = $net + $sale -> commission;
                $medication = get_ipd_medication_net_price ( $sale -> sale_id );
                $lab = get_ipd_lab_net_price ( $sale -> sale_id );
                $medicationNet = $medicationNet + $medication;
                $labNet = $labNet + $lab;
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $patient -> id ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td><?php echo ( get_panel_by_id ( $patient -> panel_id ) ) ? get_panel_by_id ( $patient -> panel_id ) -> name : 'Cash' ?></td>
                    <td><?php echo $sale -> sale_id ?></td>
                    <td><?php echo @get_doctor ( $sale -> doctor_id ) -> name . '<br>'; ?></td>
                    <td><?php echo @get_ipd_service_by_id ( $sale -> service_id ) -> title ?></td>
                    <td><?php echo number_format ( $sale -> commission, 2 ) ?></td>
                    <td><?php echo number_format ( $medication, 2 ) ?></td>
                    <td><?php echo number_format ( $lab, 2 ) ?></td>
                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="7"></td>
        <td><strong><?php echo number_format ( $net, 2 ) ?></strong></td>
        <td><strong><?php echo number_format ( $medicationNet, 2 ) ?></strong></td>
        <td><strong><?php echo number_format ( $labNet, 2 ) ?></strong></td>
        <td></td>
    </tr>
    </tfoot>
</table>

</body>
</html>