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
<htmlpageheader name="firstpage">
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"><br><br /><br /><b>EMR Number: </b><?php echo $patient_id ?><br /><b>Patient Name: </b><?php echo $patient -> name ?><br /><b>Patient Mobile: </b><?php echo $patient -> mobile ?><br /><b>Patient Age: </b><?php echo $patient -> age ?><br /><br />
<?php if(count($consultants) > 0) { foreach ($consultants as $consultant) if($consultant -> service_id > 0) { echo get_ipd_service_by_id($consultant -> service_id) -> title . ' / ' . get_doctor($consultant -> doctor_id) -> name . '<br>'; } }  ?><br /><br /><br /><br />
</td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /><strong style="font-size: 28px"><?php echo $sale_id ?></strong></span></td>
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
    <strong>Admission No:</strong> <?php echo $_REQUEST['sale_id'] ?> <br>
    <strong>Admission Date:</strong> <?php echo date('Y-m-d', strtotime(@get_ipd_admission_date($_REQUEST['sale_id']) -> admission_date)) ?> <br>
	<?php
	$patient_info = get_patient($patient_id);
	if($patient_info -> panel_id > 0) :
		$panel = get_panel_by_id($patient_info -> panel_id);
		?>
        <div style="text-align: right; width: 100%; display: block; text-align: right">
            <strong>Panel Name:</strong> <?php echo $panel -> name ?>
            <br>
            <strong>Panel Code:</strong> <?php echo $panel -> code ?>
        </div>
	<?php endif ?>
    <strong>Discharged Date:</strong> <?php echo date_setter(@$sale -> date_discharged) ?> <br>
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; border: none" cellpadding="2" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> IPD Consolidated Bill </strong> </h3>
        </td>
    </tr>
</table>
<table width="100%" style="font-size: 9pt; margin-top: 0; border: none; page-break-inside:avoid" cellpadding="0" border="0">
    <tbody>
    <!-- IPD SERVICES -->
    <?php
	$net_ipd = 0;
    if(count($ipd_associated_services) > 0) {
        $counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">IPD Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2"
                       border="1">
                    <tbody>
                    <?php
                    foreach ($ipd_associated_services as $ipd_associated_service) {
                        $ipd_service = get_ipd_service_by_id($ipd_associated_service -> service_id);
						$net_ipd = $net_ipd + $ipd_associated_service -> net_price;
						?>
                        <tr>
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td> <?php echo $ipd_service -> title ?> </td>
                            <td align="center">
                                <?php
                                if($ipd_associated_service -> doctor_id > 0)
                                    echo get_doctor($ipd_associated_service -> doctor_id) -> name;
                                else
                                    echo '-';
                                ?>
                            </td>
                            <td align="center">
								<?php
								if(!empty(trim($ipd_associated_service -> charge_per)))
                                    echo $ipd_associated_service -> charge_per_value . ' ' . $ipd_associated_service -> charge_per;
								else
								    echo '-';
								?>
                            </td>
                            <td align="right"> <?php echo number_format($ipd_associated_service -> net_price, 2) ?> </td>
                        </tr>
						<?php
					}
                    ?>
                    <tr>
                        <td colspan="4"></td>
                        <td align="right"><strong> <?php echo number_format ($net_ipd, 2) ?> </strong></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
    ?>
    <!-- OPD SERVICES -->
	<?php
	if(count($opd_associated_services) > 0) {
		$counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">OPD Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2"
                       border="1">
                    <tbody>
					<?php
					foreach ($opd_associated_services as $opd_associated_service) {
						$opd_service = get_service_by_id($opd_associated_service -> service_id);
						?>
                        <tr>
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td> <?php echo $opd_service -> title ?> </td>
                            <td align="right"> <?php echo number_format($opd_associated_service -> net_price, 2) ?> </td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
	?>

    <!-- LAB SERVICES -->
	<?php
	if(count($ipd_lab_tests) > 0) {
		$counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">Diagnostic/Treatment Test Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2" border="1">
                    <tbody>
                    <tr>
                        <td align="center"> <?php echo $counter++ ?> </td>
                        <td> Sum of all tests </td>
                        <td align="right"> <?php echo number_format($ipd_lab_tests, 2) ?> </td>
                    </tr>
                    <?php
					?>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
	?>

    <!-- MEDICATION -->
	<?php
	if(count($medication) > 0) {
		$counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">Pharmacy Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2"
                       border="1">
                    <tbody>
                    <tr>
                        <td align="center"> <?php echo $counter++ ?> </td>
                        <td> Sum of all medication </td>
                        <td align="right"> <?php echo number_format($medication, 2) ?> </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
	?>

    <!-- XRAY -->
	<?php
	if(count($xray) > 0) {
		$counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">X-Ray Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2"
                       border="1">
                    <tbody>
					<?php
					foreach ($xray as $item) {
						$ipd_service = get_ipd_service_by_id($item -> service_id);
						?>
                        <tr>
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td> <?php echo $ipd_service -> title ?> </td>
                            <td align="center">
								<?php
								if(!empty(trim($item -> charge_per)))
									echo $item -> charge_per_value . ' ' . $item -> charge_per;
								else
									echo '-';
								?>
                            </td>
                            <td align="right"> <?php echo number_format($item -> net_price, 2) ?> </td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
	?>

    <!-- ULTRASOUND -->
	<?php
	if(count($ultrasound) > 0) {
		$counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">Ultrasound Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2"
                       border="1">
                    <tbody>
					<?php
					foreach ($ultrasound as $item) {
						$ipd_service = get_ipd_service_by_id($item -> service_id);
						?>
                        <tr>
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td> <?php echo $ipd_service -> title ?> </td>
                            <td align="center">
								<?php
								if(!empty(trim($item -> charge_per)))
									echo $item -> charge_per_value . ' ' . $item -> charge_per;
								else
									echo '-';
								?>
                            </td>
                            <td align="right"> <?php echo number_format($item -> net_price, 2) ?> </td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
	?>

    <!-- ECG -->
	<?php
	if(count($ecg) > 0) {
		$counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">ECG Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2"
                       border="1">
                    <tbody>
					<?php
					foreach ($ecg as $item) {
						$ipd_service = get_ipd_service_by_id($item -> service_id);
						?>
                        <tr>
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td> <?php echo $ipd_service -> title ?> </td>
                            <td align="center">
								<?php
								if(!empty(trim($item -> charge_per)))
									echo $item -> charge_per_value . ' ' . $item -> charge_per;
								else
									echo '-';
								?>
                            </td>
                            <td align="right"> <?php echo number_format($item -> net_price, 2) ?> </td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
	?>

    <!-- ECHO -->
	<?php
	if(count($echo) > 0) {
		$counter = 1;
		?>
        <tr>
            <td>
                <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                       cellpadding="0" border="0">
                    <tr style="margin-left: 0">
                        <td style="margin-left: 0">
                            <strong style="font-size: 14px; float: left; width: 100%">ECHO Charges</strong>
                        </td>
                    </tr>
                </table>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;" cellpadding="2"
                       border="1">
                    <tbody>
					<?php
					foreach ($echo as $item) {
						$ipd_service = get_ipd_service_by_id($item -> service_id);
						?>
                        <tr>
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td> <?php echo $ipd_service -> title ?> </td>
                            <td align="center">
								<?php
								if(!empty(trim($item -> charge_per)))
									echo $item -> charge_per_value . ' ' . $item -> charge_per;
								else
									echo '-';
								?>
                            </td>
                            <td align="right"> <?php echo number_format($item -> net_price, 2) ?> </td>
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
            </td>
        </tr>
		<?php
	}
	?>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 9pt; margin-top: 30px; border: none" cellpadding="0" border="0">
    <tbody>
        <?php $to_be_paid = $sale_billing -> net_total - $sale_billing -> initial_deposit - $count_payment; ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>Total Amount: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format($sale_billing -> total, 2) ?>
            </td>
        </tr>
        <?php if($sale_billing -> discount > 0) : ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>Discount: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format($sale_billing -> discount, 2) ?>
            </td>
        </tr>
        <?php endif; ?>
        <tr style="width: 100%; display: block; float: left; border: none;">
            <td colspan="2" align="right" style="border: none">
                <strong>Net Amount: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format($sale_billing -> net_total, 2) ?>
            </td>
        </tr>
        <tr style="width: 100%; display: block; float: left; border: none">
            <td colspan="2" align="right" style="border: none">
                <strong>Deposit: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format($sale_billing -> initial_deposit) ?>
            </td>
        </tr>
        <tr style="width: 100%; display: block; float: left; border: none">
            <td colspan="2" align="right" style="border: none">
                <strong>Payments: </strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format($count_payment) ?>
            </td>
        </tr>
        <tr style="width: 100%; display: block; float: left; border: none">
            <td colspan="2" align="right" style="border: none">
                <strong> Final Payment:</strong>
            </td>
            <td align="right" style="border: none">
                <?php echo number_format($to_be_paid, 2) ?>
            </td>
        </tr>
    </tbody>
</table>
<div class="signature" style="width: 100%; display: block; float: left; margin-top: 50px">
    <div class="prepared-by" style="width: 25%; float: left; display: inline-block; border-top: 2px solid #000000; margin-right: 25px; text-align: center">
        <strong>Authorized Officer</strong>
    </div>
    <div class="verified-by" style="width: 25%; float: left; display: inline-block; border-top: 2px solid #000000; margin-left: 25px; text-align: center">
        <strong>Verified By</strong>
    </div>
</div>

</body>
</html>