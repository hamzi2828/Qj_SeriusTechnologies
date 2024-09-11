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
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /><span style="font-weight: bold; font-size: 25pt;"><?php echo $consultancy_id ?></span><br><br><strong>Patient EMR: </strong><?php echo @get_patient($consultancy -> patient_id) -> id ?><br><strong>Patient Name: </strong><?php echo @get_patient($consultancy -> patient_id) -> name ?></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo $user -> name ?><br><b><?php echo date_setter($consultancy -> date_added) ?></b></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br/>
<?php
$patient_info = @get_patient($consultancy -> patient_id);
if(@$patient_info -> panel_id > 0) :
$panel = @get_panel_by_id(@$patient_info -> panel_id);
?>
<div style="text-align: right; width: 100%; display: block; text-align: right">
    <br>
    <strong>Panel Name:</strong> <?php echo $panel -> name ?>
    <br>
    <strong>Panel Code:</strong> <?php echo $panel -> code ?>
</div>
<?php endif ?>
<div style="text-align: right; width: 100%; display: block; text-align: right">
    <br>
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<table width="100%">
    <tr>
        <td align="center">
            <strong>Consultation (Patient Copy)</strong>
        </td>
    </tr>
</table>
<br/>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%;font-weight:bold">Sr. No.</td>
        <td style="font-weight:bold">Description</td>
        <td style="font-weight:bold">Charges</td>
        <td style="font-weight:bold">Discount(%)</td>
        <td style="font-weight:bold">Net</td>
        <td style="font-weight:bold">Date</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
        <tr>
            <td align="center"><?php echo 1 ?></td>
            <td align="center">
                <strong>Referred to:</strong> <br>
                <?php echo get_doctor($consultancy -> doctor_id) -> name; ?><br>
                <?php echo get_doctor($consultancy -> doctor_id) -> qualification; ?><br>
                <?php echo get_specialization_by_id($consultancy -> specialization_id) -> title; ?>
            </td>
            <td align="center">
                <?php
//                if ( $consultancy -> refunded == '1') {
//                    $reason = explode ('#', $consultancy -> refund_reason);
//                    print_data ( $reason);
//                    $parentConsultancy = get_consultancy_by_id (@$reason[1]);
//                    echo $parentConsultancy -> charges;
//                }
//                else
                    echo $consultancy -> charges;
                ?>
            </td>
            <td align="center"><?php echo $consultancy -> discount ?>%</td>
            <td align="center"><?php echo $consultancy -> net_bill ?></td>
            <td align="center"><?php echo date_setter($consultancy -> date_added) ?></td>
        </tr>
    </tbody>
</table>
<br />
<p style="text-align: right">
    <small>
        <b><?php echo $user -> name ?></b>
        <br><b><?php echo date_setter($consultancy -> date_added) ?></b>
    </small>
</p>
<br /><br /><br />
<img src="<?php echo base_url('/assets/img/cut-here.png') ?>">
<br /><br /><br /><br />
<table width="100%"><tr>
        <td width="50%" style="color:#000; ">
            <img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px">
        </td>
        <td width="50%" style="text-align: right;">
            <span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br />
            <?php echo hospital_address ?><br />
            <span style="font-family:dejavusanscondensed;">&#9742;</span>
            <?php echo hospital_phone ?> <br /> <br />
            <span style="font-weight: bold; font-size: 25pt;">
                <?php echo $consultancy_id ?>
            </span><br><br>
            <strong>Patient EMR: </strong>
            <?php echo @get_patient($consultancy -> patient_id) -> id ?><br>
            <strong>Patient Name: </strong>
            <?php echo @get_patient($consultancy -> patient_id) -> name ?>
        </td>
    </tr>
</table>
<?php
    if ( @$patient_info -> panel_id > 0 ) :
        $panel = get_panel_by_id (@$patient_info -> panel_id);
        ?>
        <div style="text-align: right; width: 100%; display: block; text-align: right">
            <br>
            <strong>Panel Name:</strong> <?php echo $panel -> name ?>
            <br>
            <strong>Panel Code:</strong> <?php echo $panel -> code ?>
        </div>
    <?php endif ?>
<div style="text-align: right; width: 100%; display: block; text-align: right">
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<table width="100%">
    <tr>
        <td align="center">
            <strong>Consultation (Doctor Copy)</strong>
        </td>
    </tr>
</table>
<br/>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%;font-weight:bold">Sr. No.</td>
        <td style="font-weight:bold">Description</td>
        <td style="font-weight:bold">Charges</td>
        <td style="font-weight:bold">Discount(%)</td>
        <td style="font-weight:bold">Net</td>
        <td style="font-weight:bold">Date</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
        <tr>
            <td align="center"><?php echo 1 ?></td>
            <td align="center">
                <strong>Referred to:</strong> <br>
                <?php echo get_doctor($consultancy -> doctor_id) -> name; ?><br>
                <?php echo get_doctor($consultancy -> doctor_id) -> qualification; ?><br>
                <?php echo get_specialization_by_id($consultancy -> specialization_id) -> title; ?>
            </td>
            <td align="center"><?php echo $consultancy -> charges ?></td>
            <td align="center"><?php echo $consultancy -> discount ?>%</td>
            <td align="center"><?php echo $consultancy -> net_bill ?></td>
            <td align="center"><?php echo date_setter($consultancy -> date_added) ?></td>
        </tr>
    </tbody>
</table>
</body>
</html>