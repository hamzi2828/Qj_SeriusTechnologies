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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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
        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"><br><br /><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /></span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo $user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> IPD Discharge Slip </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" id="print-info" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 30px; border: 0" cellpadding="8" border="0">
    <tbody>
        <tr>
            <td style="width: 30%"> <strong>Patient EMR:</strong> </td>
            <td> <?php echo $patient -> id ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Patient Name:</strong> </td>
            <td> <?php echo $patient -> name ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Admission No:</strong> </td>
            <td> <?php echo $slip -> admission_no ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Doctor:</strong> </td>
            <td> <?php echo get_doctor ($slip -> doctor_id) -> name ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Panel/Pvt:</strong> </td>
            <td> <?php echo $slip -> panel_pvt ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Room/Bed No:</strong> </td>
            <td> <?php echo $slip -> room_bed_no ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Admission Date:</strong> </td>
            <td> <?php echo date_setter ( $slip -> admission_date) ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Discharge Date:</strong> </td>
            <td> <?php echo date_setter ( $slip -> discharge_date) ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Diagnosis:</strong> </td>
            <td> <?php echo $slip -> diagnosis ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Operation Procedure:</strong> </td>
            <td> <?php echo $slip -> operation_procedure ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Rest Advise:</strong> </td>
            <td> <?php echo $slip -> rest_advise ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Days Week:</strong> </td>
            <td> <?php echo $slip -> days_week ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Follow Up Treatment:</strong> </td>
            <td> <?php echo $slip -> follow_up_treatment ?> </td>
        </tr>
        <tr>
            <td style="width: 30%"> <strong>Revisit On:</strong> </td>
            <td> <?php echo $slip -> revisit_on ?> </td>
        </tr>
    </tbody>
</table>

</body>
</html>