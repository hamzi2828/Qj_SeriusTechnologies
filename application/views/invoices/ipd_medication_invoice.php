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
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"> <br><br><br>
		</td>
		<td width="50%" style="text-align: right;">
			<span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br />
			<?php echo hospital_address ?><br />
			<span style="font-family:dejavusanscondensed;">&#9742;</span>
			<?php echo hospital_phone ?> <br />
		</td>
	</tr>
</table>
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
    <strong>Patient EMR#</strong> <?php echo @$medicines[0] -> patient_id ?> <br>
    <strong>Patient Name#</strong> <?php echo @get_patient($medicines[0] -> patient_id) -> name ?> <br>
    <strong>Admission No#</strong> <?php echo @$medicines[0] -> sale_id ?> <br>
    <strong>Receipt Date#</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> IPD Medication </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Sale ID </th>
        <th> Patient </th>
        <th> Medicine </th>
        <th> Price </th>
        <th> Quantity </th>
        <th> Net Price </th>
        <th> Date Added </th>
    </tr>
    </thead>
    <tbody>
	<?php
	if(count($medicines) > 0) {
	    $counter = 1;
	    $price = 0;
	    $net_price = 0;
	    foreach ($medicines as $medicine) {
			$price = $price + $medicine -> price;
			$net_price = $net_price + $medicine -> net_price;
			$medicine_info      = get_medicine($medicine -> medicine_id);
			$generic            = get_generic($medicine_info -> generic_id);
			$form               = get_form($medicine_info -> form_id);
			$strength           = get_strength($medicine_info -> strength_id);
			?>
            <tr>
                <td> <?php echo $counter++; ?> </td>
                <td> <?php echo $medicine -> sale_id ?> </td>
                <td> <?php echo get_patient($medicine -> patient_id) -> name ?> </td>
                <td>
                    <?php echo $medicine_info -> name ?>
                    (<?php echo $generic -> title . ' ' . $form -> title . ' ' . $strength -> title ?>)
                </td>
                <td> <?php echo number_format($medicine -> price, 2) ?> </td>
                <td> <?php echo $medicine -> quantity ?> </td>
                <td> <?php echo number_format($medicine -> net_price, 2) ?> </td>
                <td> <?php echo date_setter($medicine -> date_added) ?> </td>
            </tr>
			<?php
		}
	    ?>
        <tr>
            <td colspan="5" align="right">
                <strong> <?php echo number_format($price, 2) ?> </strong>
            </td>
            <td align="right"></td>
            <td>
                <strong> <?php echo number_format($net_price, 2) ?> </strong>
            </td>
            <td align="right"></td>
        </tr>
    <?php
	}
	?>
    </tbody>
</table>
</body>
</html>