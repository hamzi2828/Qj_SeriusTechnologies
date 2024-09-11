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
            <h3> <strong> Consultancy Share Report </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Doctor </th>
        <th> Patient EMR </th>
        <th> Patient </th>
        <th> Department </th>
        <th> Hospital Charges </th>
        <th> Discount </th>
        <th> Net Bill </th>
        <th> Hospital Commission </th>
        <th> Doctor Commission </th>
        <th> Date Added </th>
    </tr>
    </thead>
    <tbody>
	<?php
	if(count($filter_doctors) > 0) {
		$doc_counter = 1;
		foreach ($filter_doctors as $doctor) {
			$consultancies = get_doctor_consultancies($doctor -> id);
			?>
            <tr style="background: #BCE8F1">
                <td> <?php echo $doc_counter++ ?> </td>
                <td> <?php echo $doctor -> name ?> </td>
                <td colspan="10"><?php echo $doctor -> qualification ?></td>
            </tr>
			<?php
			if (count($consultancies) > 0) {
				$counter = 1;
				$hosp_commission = 0;
				$doc_commission = 0;
				$net = 0;
				foreach ($consultancies as $consultancy) {
					$specialization = get_specialization_by_id($consultancy -> specialization_id);
					$doctor = get_doctor($consultancy -> doctor_id);
					$patient = get_patient($consultancy -> patient_id);
					if ($doctor -> charges_type == 'fix') {
						$commission = $doctor -> doctor_share;
						$hospital_commission = $consultancy -> net_bill - $doctor -> doctor_share;
					}
					else {
						$commission = ($consultancy -> net_bill / 100) * $doctor -> doctor_share;
						$hospital_commission = $consultancy -> net_bill - $commission;
					}
					$net = $net + $consultancy -> net_bill;
					$hosp_commission = $hosp_commission + $hospital_commission;
					$doc_commission = $doc_commission + $commission;
					?>
                    <tr class="odd gradeX">
                        <td> </td>
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $patient -> name ?></td>
                        <td><?php echo $specialization -> title ?></td>
                        <td><?php echo $consultancy -> charges ?></td>
                        <td><?php echo $consultancy -> discount ?></td>
                        <td><?php echo $consultancy -> net_bill ?></td>
                        <td><?php echo $hospital_commission ?></td>
                        <td><?php echo $commission ?></td>
                        <td><?php echo date_setter($consultancy -> date_added) ?></td>
                    </tr>
					<?php
				}
				?>
                <tr>
                    <td colspan="7"></td>
                    <td>
                        <strong><?php echo $net ?></strong>
                    </td>
                    <td>
                        <strong><?php echo $hosp_commission ?></strong>
                    </td>
                    <td>
                        <strong><?php echo $doc_commission ?></strong>
                    </td>
                    <td></td>
                </tr>
				<?php
			}
		}
	}
	?>
    </tbody>
</table>
</body>
</html>