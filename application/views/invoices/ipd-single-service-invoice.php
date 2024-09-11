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
<td width="50%" style="color:#000; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /><span style="font-weight: bold; font-size: 25pt;"><?php echo $sale_id ?></span><br><br><strong>Patient EMR: </strong><?php echo get_patient( $sale -> patient_id) -> id ?><br><strong>Patient Name: </strong><?php echo get_patient( $sale -> patient_id) -> name ?></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo $user -> name ?><br><b><?php echo date_setter( $sale -> date_added) ?></b></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br/>
<?php
$patient_info = get_patient( $sale -> patient_id);
if($patient_info -> panel_id > 0) :
	$panel = get_panel_by_id($patient_info -> panel_id);
	?>
    <div style="text-align: right; width: 100%; display: block; text-align: right">
        <br>
        <strong>Panel Name:</strong> <?php echo $panel -> name ?>
        <br>
        <strong>Panel Code:</strong> <?php echo $panel -> code ?>
    </div>
<?php endif ?>
<div style="text-align: right; width: 100%; display: block; text-align: right"><br>
    <strong>Receipt Date:</strong> <?php echo date_setter($sale -> date_added) ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> IPD Sale Invoice </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%;font-weight:bold">Sr. No.</td>
        <td style="font-weight:bold">Code</td>
        <td style="font-weight:bold">Doctor</td>
        <td style="font-weight:bold">Service</td>
        <td style="font-weight:bold">Price</td>
        <td style="font-weight:bold">Net</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
    if(!empty( $sale)) :
        $counter    = 1;
        $service = get_ipd_service_by_id($sale -> service_id);
        ?>
        <tr>
            <td align="center"><?php echo $counter++ ?></td>
            <td align="center"><?php echo $service -> code ?></td>
            <td align="center">
                <?php
                if($sale -> doctor_id > 0)
                    echo get_doctor($sale -> doctor_id) -> name.'<br>';
                else
                    echo '-'.'<br>';
                ?>
            </td>
            <td align="center"><?php echo $service -> title ?></td>
            <td align="center"><?php echo $sale -> price ?></td>
            <td align="center"><?php echo $sale -> net_price ?></td>
        </tr>
        <tr>
            <td colspan="5" align="right">
                <strong>Total:</strong>
            </td>
            <td align="center">
                <strong><?php echo $sale -> net_price; ?></strong>
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>