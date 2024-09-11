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
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> IPD General Report (Cash) </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Sale ID# </th>
        <th> Patient EMR# </th>
        <th> Patient Name </th>
        <th> Total IPD Bill </th>
        <th> Total Lab Bill </th>
        <th> Total Medication Bill </th>
        <th> G. Total </th>
    </tr>
    </thead>
    <tbody>
	<?php
	if(count($sales) > 0) {
		$counter = 1;
		$total_ipd = 0;
		$total_lab = 0;
		$total_med = 0;
		$g_total    = 0;
		foreach ($sales as $sale) {
			$total_ipd_services = $this -> IPDModel -> total_ipd_services($sale -> sale_id);
			$total_opd_services = $this -> IPDModel -> total_opd_services($sale -> sale_id);
			$total_lab_services = $this -> IPDModel -> total_lab_services($sale -> sale_id);
			$total_medication 	= $this -> IPDModel -> total_medication($sale -> sale_id);
            $patient            = get_patient($sale -> patient_id);
			$total_ipd          = $total_ipd + $total_ipd_services;
			$total_lab          = $total_lab + $total_lab_services;
			$total_med          = $total_med + $total_medication;
			$total              = $total_ipd_services + $total_lab_services + $total_medication;
			$g_total            = $g_total + $total;
			?>
            <tr class="odd gradeX">
                <td> <?php echo $counter++ ?> </td>
                <td> <?php echo $sale -> sale_id ?> </td>
                <td> <?php echo $sale -> patient_id ?> </td>
                <td> <?php echo $patient -> name ?> </td>
                <td> <?php echo number_format($total_ipd_services, 2) ?> </td>
                <td> <?php echo number_format($total_lab_services, 2) ?> </td>
                <td> <?php echo number_format($total_medication, 2) ?> </td>
                <td> <?php echo number_format($total, 2) ?> </td>
            </tr>
			<?php
		}
		?>
        <tr>
            <td colspan="4"></td>
            <td><strong><?php echo number_format($total_ipd, 2) ?></strong></td>
            <td><strong><?php echo number_format($total_lab, 2) ?></strong></td>
            <td><strong><?php echo number_format($total_med, 2) ?></strong></td>
            <td><strong><?php echo number_format($g_total, 2) ?></strong></td>
        </tr>
    <?php
	}
	?>
    </tbody>
</table>
</body>
</html>