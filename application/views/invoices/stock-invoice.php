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
        .parent {
            padding-left: 25px;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"><br><br /><br /><b>Supplier Name: </b><?php echo $supplier -> title ?><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br />Stock Invoice ID#<?php echo $invoice ?></span></td>
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
<div style="text-align: right">
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Stock Invoice </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 30px" cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td>Sr. No</td>
        <td>Invoice No.</td>
        <td>Medicine</td>
        <td>Batch</td>
        <td>Expiry</td>
        <td>Quantity</td>
        <td>Cost/Unit</td>
        <td>Sale/Unit</td>
        <td>Price</td>
        <td>Discount</td>
        <td>S.Tax</td>
        <td>Net Price</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
    if(count($stock) > 0) {
        $counter = 1;
        $total_price = 0;
        $total_net_price = 0;
		$grand_total = get_stock_grand_total($this -> uri -> segment(3));
        foreach ($stock as $item) {
            $medicine           = get_medicine($item -> medicine_id);
            $total_price        = $total_price + $item -> price;
            $total_net_price    = $total_net_price + $item -> net_price;
            $strength_id        = $medicine -> strength_id;
            if(!empty(trim($strength_id)) and $strength_id > 1)
                $strength = get_strength($strength_id) -> title;
            else
	            $strength = '';
            ?>
            <tr>
                <td align="center"><?php echo $counter++ ?></td>
                <td align="center"><?php echo $item -> supplier_invoice ?></td>
                <td align="center">
                    <?php echo $medicine -> name ?>
                    <?php if(!empty(trim($strength))) : ?>
                    (<?php echo $strength ?>)
                    <?php endif; ?>
                </td>
                <td align="center"><?php echo $item -> batch ?></td>
                <td align="center"><?php echo date_setter($item -> expiry_date) ?></td>
                <td align="center"><?php echo $item -> quantity ?></td>
                <td align="center"><?php echo $item -> tp_unit ?></td>
                <td align="center"><?php echo $item -> sale_unit ?></td>
                <td align="center"><?php echo $item -> price ?></td>
                <td align="center"><?php echo $item -> discount ?></td>
                <td align="center"><?php echo $item -> sales_tax ?></td>
                <td align="center"><?php echo $item -> net_price ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="8"></td>
            <td align="center"><strong><?php echo $total_price ?></strong></td>
            <td></td>
            <td></td>
            <td align="center"><strong><?php if(@$grand_total -> grand_total > 0) echo @$grand_total -> grand_total; else echo $total_net_price; ?></strong></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
</body>
</html>