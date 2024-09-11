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
<div style="text-align: right">
    <p style="font-size: 18px">
        <strong>Invoice No:</strong> <?php echo @$_REQUEST[ 'invoice' ] ?>
    </p> <br/>
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Store Stock Invoice </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Supplier </th>
        <th> Item Name </th>
<!--        <th> Invoice </th>-->
        <th> Batch </th>
        <th> Quantity </th>
        <th> Price </th>
        <th> Discount </th>
        <th> Net Price </th>
        <th> Date Added </th>
    </tr>
    </thead>
    <tbody>
	<?php
	if(count($stocks) > 0) {
		$counter = 1;
		$total = 0;
		foreach ($stocks as $stock) {
			$supplier   = get_supplier($stock -> supplier_id);
			$item       = get_store($stock -> store_id);
			$total      = $total + $stock -> net_price;
			?>
            <tr class="odd gradeX">
                <td> <?php echo $counter++ ?> </td>
                <td><?php echo @$supplier -> title ?></td>
                <td><?php echo $item -> item ?></td>
<!--                <td>--><?php //echo $stock -> invoice ?><!--</td>-->
                <td><?php echo $stock -> batch ?></td>
                <td><?php echo $stock -> quantity ?></td>
                <td><?php echo number_format ( $stock -> price, 2 ) ?></td>
                <td><?php echo $stock -> discount ?></td>
                <td><?php echo number_format($stock -> net_price, 2) ?></td>
                <td><?php echo date_setter($stock -> date_added) ?></td>
            </tr>
			<?php
		}
		?>
        <tr>
            <td colspan="7" class="text-right" align="right">
                <strong>Total:</strong>
            </td>
            <td>
                <strong><?php echo number_format($total, 2) ?></strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="7" class="text-right" align="right">
                <strong>Bill Discount (%):</strong>
            </td>
            <td>
                <strong><?php echo number_format($stock_info -> discount, 2) ?></strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="7" class="text-right" align="right">
                <strong>Net Bill:</strong>
            </td>
            <td>
                <strong><?php echo number_format($stock_info -> total, 2) ?></strong>
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