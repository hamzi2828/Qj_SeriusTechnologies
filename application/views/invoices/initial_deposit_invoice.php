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
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0;
            border-right: 0;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0;
            background-color: #FFFFFF;
            border: 0;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0;
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
            <h3> <strong> Initial Deposit Slip </strong> </h3>
        </td>
    </tr>
</table>
<br>
<div class="slip" style="width: 100%; display: block; float: left; margin-bottom: 15px !important;">
    <div class="patient_emr" style="width: 75%; float: left; text-align: right">EMR No:</div>
    <div class="patient_emr" style="width: 22%; float: right; text-align: left; border-bottom: 1px solid #000000"><?php echo $slip -> patient_id ?></div>
</div>
<br><br>
<div class="slip" style="width: 50%; float: left; margin-top: 15px; margin-right: 15px; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 30%; float: left; text-align: left">
        Patient Name:
    </div>
    <div class="patient_emr" style="width: 68%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo get_patient($slip -> patient_id) -> name ?>
    </div>
</div>
<div class="slip" style="width: 23%; float: left; margin-right: 15px">
    <div class="patient_name" style="width: 25%; float: left; text-align: left">
        Age:
    </div>
    <div class="patient_emr" style="width: 73%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo get_patient($slip -> patient_id) -> age ?>
    </div>
</div>
<div class="slip" style="width: 23%; float: left; margin-right: 15px; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 25%; float: left; text-align: left">
        Gender:
    </div>
    <div class="patient_emr" style="width: 73%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo get_patient($slip -> patient_id) -> gender == '1' ? 'Male' : 'Female' ?>
    </div>
</div>
<br><br>
<div class="slip" style="width: 50%; float: left; margin-right: 15px; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 25%; float: left; text-align: left">
        Panel/PVT:
    </div>
    <div class="patient_emr" style="width: 73%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo $slip -> panel_pvt ?>
    </div>
</div>
<div class="slip" style="width: 48%; float: right; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 30%; float: left; text-align: left">
        Room/Bed No:
    </div>
    <div class="patient_emr" style="width: 68%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo @$slip -> room_no ?>/<?php echo @$slip -> bed_no ?>
    </div>
</div><br>
<div class="slip" style="width: 50%; float: left; margin-right: 15px; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 25%; float: left; text-align: left">
        Payment:
    </div>
    <div class="patient_emr" style="width: 73%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo $sale_billing -> initial_deposit ?>
    </div>
</div>
<div class="slip" style="width: 48%; float: right; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 30%; float: left; text-align: left">
        Admission No:
    </div>
    <div class="patient_emr" style="width: 68%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo $slip -> admission_no ?>
    </div>
</div><br>
<div class="slip" style="width: 48%; float: left; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 35%; float: left; text-align: left">
        Date of Payment:
    </div>
    <div class="patient_emr" style="width: 62%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo date ( 'm/d/Y g:i a', strtotime ( $slip -> date_added ) ); ?>
    </div>
</div>
<div class="slip" style="width: 48%; float: right; margin-bottom: 15px !important;">
    <div class="patient_name" style="width: 30%; float: left; text-align: left">
        Contact No:
    </div>
    <div class="patient_emr" style="width: 68%; float: right; text-align: left; border-bottom: 1px solid #000000">
        <?php echo $slip -> contact_no ?>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="slip" style="width: 100%; float: left; margin-top: 100px !important;">
    <div style="width: 50%; float: right; display: inline-block">
        <div style="width: 250px; border-top: 1px solid #000000; text-align: center; float: right">
            Admission & Discharge
        </div>
    </div>
</div>
</body>
</html>