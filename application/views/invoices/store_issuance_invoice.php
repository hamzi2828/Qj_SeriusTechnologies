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
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; width: 150px; float: right; margin-bottom: 130px">
Received By:
</div><br><br><br><br>
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
<div style="text-align: right">
    <strong>Issuance ID:</strong> <?php echo @$sales[0] -> sale_id ?>
</div>
<div style="text-align: right">
    <strong>Department:</strong> <?php echo get_department ( @$sales[ 0 ] -> department_id ) -> name ?>
</div>
<div style="text-align: right">
    <strong>Issued By:</strong> <?php echo get_user ( @$sales[ 0 ] -> sold_by ) -> name ?>
</div>
<div style="text-align: right">
    <strong>Issued To:</strong> <?php echo get_user ( @$sales[ 0 ] -> sold_to ) -> name ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Store Issuance Note </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Item </th>
        <th> Quantity </th>
        <th> TP </th>
        <th> Total </th>
        <th> Date Added </th>
    </tr>
    </thead>
    <tbody>
	<?php
        $net = 0;
	if(count($sales) > 0) {
		$counter = 1;
		foreach ($sales as $sale) {
			$item           = get_store($sale -> store_id);
			$stock = get_store_stock ($sale -> stock_id);
            $net = $net + ( $sale -> quantity * $stock -> price);
			?>
            <tr class="odd gradeX">
                <td align="center"> <?php echo $counter++ ?> </td>
                <td align="center"><?php echo $item -> item ?></td>
                <td align="center"><?php echo $sale -> quantity ?></td>
                <td align="center"><?php echo number_format ( $stock -> price, 2) ?></td>
                <td align="center"><?php echo number_format ( $sale -> quantity * $stock -> price, 2) ?></td>
                <td align="center"><?php echo date_setter($sale -> date_added) ?></td>
            </tr>
			<?php
		}
	}
	?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" align="right">
                <strong>Total:</strong>
            </td>
            <td>
                <strong><?php echo number_format ( $net, 2) ?></strong>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>
</body>
</html>