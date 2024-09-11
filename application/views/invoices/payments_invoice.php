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
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0;
            border-right: 0;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0;
            background-color: #FFFFFF;
            border: 0;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0;
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
            <h3> <strong> Payments Slip </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th>Sr. No</th>
        <th>Amount</th>
        <th>Type</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="center">1</td>
        <td align="center"><?php echo $sale_billing -> initial_deposit ?></td>
        <td align="center">Cash</td>
        <td align="center">Initial Deposit</td>
    </tr>
    <?php
    if(count($payments) > 0) {
        $counter = 2;
        foreach ($payments as $payment) {
            ?>
            <tr>
                <td align="center"><?php echo $counter++ ?></td>
                <td align="center"><?php echo $payment -> amount ?></td>
                <td align="center"><?php echo $payment -> type ?></td>
                <td align="center"><?php echo $payment -> description ?></td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
</body>
</html>