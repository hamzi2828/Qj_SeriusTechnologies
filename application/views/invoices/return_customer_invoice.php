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
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="firstpage">
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"><br><br /><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /><strong style="font-size: 28px"><?php echo $invoice ?></strong></span></td>
</tr></table>
</htmlpageheader>
<htmlpageheader name="otherpages" style="display:none"></htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo @$user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="text-align: right">
    <strong>Return Date:</strong> <?php echo date('d-m-Y h:i:s a', strtotime ($stocks[0] -> date_added)) ?> <br/>
    <strong>Print Slip Date:</strong> <?php echo date('d-m-Y') .'@'. date('h:i:s a') ?> <br/>
</div>
<br/>
<br/>
<br/>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Return Customer Invoice </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
        <tr>
            <th> Sr.No </th>
            <th> Medicine </th>
            <th> Quantity </th>
            <th> Paid To Customer </th>
        </tr>
    </thead>
    <tbody>
    <?php
    $counter = 1;
    $net = 0;
    if(count ( $stocks) > 0) {
        foreach ( $stocks as $stock) {
            $net = $net + $stock -> paid_to_customer;
            $medicine = get_medicine ($stock -> medicine_id);
			if ( $medicine -> strength_id > 1 )
				$strength = get_strength ( $medicine -> strength_id ) -> title;
			else
				$strength = '';
			if ( $medicine -> form_id > 1 )
				$form = get_form ( $medicine -> form_id ) -> title;
			else
				$form = '';
            ?>
            <tr>
                <td align="center"> <?php echo $counter++ ?> </td>
                <td align="center"> <?php echo $medicine -> name . ' ' . $strength . ' ' . $form ?> </td>
                <td align="center"> <?php echo $stock -> quantity ?> </td>
                <td align="center"> <?php echo $stock -> paid_to_customer ?> </td>
            </tr>
    <?php
        }
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td align="center"><strong><?php echo $net ?></strong></td>
        </tr>
    </tfoot>
</table>
<div class="signature" style="width: 100%; display: block; float: left; margin-top: 250px">
    <div class="prepared-by" style="width: 25%; float: left; display: inline-block; border-top: 2px solid #000000; margin-right: 25px; text-align: center">
        <strong>Authorized Officer</strong>
    </div>
    <div class="verified-by" style="width: 25%; float: right; display: inline-block; border-top: 2px solid #000000; margin-left: 25px; text-align: center">
        <strong>Verified By</strong>
    </div>
</div>
</body>
</html>