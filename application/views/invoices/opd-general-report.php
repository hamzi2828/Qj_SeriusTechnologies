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
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<?php if(isset($_REQUEST['start_time']) and !empty(trim($_REQUEST['start_time'])) and isset($_REQUEST['end_time']) and !empty(trim($_REQUEST['end_time']))) : ?>
    <div style="text-align: right">
        <strong>Search Criteria:</strong>
		<?php echo date('d-m-Y', strtotime(@$_REQUEST['start_date'])) ?>
		<?php echo (isset($_REQUEST['start_time']) and !empty(@$_REQUEST['start_time'])) ? date('H:i:s', strtotime(@$_REQUEST['start_time'])) : '' ?> @
		<?php echo date('d-m-Y', strtotime(@$_REQUEST['end_date'])) ?>
		<?php echo (isset($_REQUEST['end_time']) and !empty(@$_REQUEST['end_time'])) ? date('H:i:s', strtotime(@$_REQUEST['end_time'])) : '' ?>
    </div>
<?php endif; ?>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> OPD General Report (Cash) </strong> </h3>
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
            <th> Doctor(s) </th>
            <th> Service(s) </th>
            <th> Price </th>
            <th> Discount/Service </th>
            <th> Total </th>
            <th> Net Discount </th>
            <th> Net Price </th>
            <th> Date Added </th>
        </tr>
        </thead>
        <tbody>
		<?php
		if(count($sales) > 0) {
			$counter = 1;
			$total = 0;
			foreach ($sales as $sale) {
				$patient = get_patient($sale -> patient_id);
				$sale_info = get_opd_sale($sale -> sale_id);
				$total = $total + $sale_info -> net;
				?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $sale -> sale_id ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td>
                        <?php
                        $doctors = explode(',', $sale -> doctors);
                        if (count($doctors) > 0) {
                            foreach ($doctors as $doctor) {
                                if($doctor > 0)
                                    echo get_doctor($doctor) -> name . '<br>';
                                else
                                    echo '-'.'<br>';
                            }
                        }
                        ?>
                    </td>
                    <td>
						<?php
						$services = explode(',', $sale -> services);
						if(count($services) > 0) {
							foreach ($services as $service) {
								echo get_service_by_id($service) -> title . '<br>';
							}
						}
						?>
                    </td>
                    <td>
						<?php
						$prices = explode(',', $sale -> prices);
						if(count($prices) > 0) {
							foreach ($prices as $price) {
								echo $price . '<br>';
							}
						}
						?>
                    </td>
                    <td>
						<?php
						$discounts = explode(',', $sale -> discounts);
						if(count($discounts) > 0) {
							foreach ($discounts as $discount) {
								echo $discount . '<br>';
							}
						}
						?>
                    </td>
                    <td><?php echo $sale -> net_price ?></td>
                    <td><?php echo $sale_info -> discount.'%' ?></td>
                    <td><?php echo $sale_info -> net ?></td>
                    <td><?php echo date_setter($sale -> date_added) ?></td>
                </tr>
				<?php
			}
			?>
            <tr>
                <td colspan="8"></td>
                <td>
                    <strong><?php echo $total ?></strong>
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