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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Employee Information </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td align="right">
            <img src="<?php echo $employee -> picture ?>" style="width: 100px; box-shadow: 0 0 1px 1px #000000">
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong style="font-size: 18px">Code# <?php echo $employee -> code ?></strong>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
        <tr>
            <td colspan="2" align="left">
                <h2>Personal Information</h2>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 0">
                <strong>Name:</strong>
                <?php echo $employee -> name ?>
            </td>
            <td style="border: 0">
                <strong>Father Name:</strong>
                <?php echo $employee -> father_name ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Mother Name:</strong>
                <?php echo $employee -> mother_name ?>
            </td>
            <td style="border: 0">
                <strong>Gender:</strong>
                <?php echo $employee -> gender == '1' ? 'Male' : 'Female' ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Date of Birth:</strong>
                <?php echo date('d/m/Y', strtotime($employee -> dob)) ?>
            </td>
            <td style="border: 0">
                <strong>Place of Birth:</strong>
                <?php echo $employee -> birth_place ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Martial Status:</strong>
                <?php echo ucfirst($employee -> martial_status) ?>
            </td>
            <td style="border: 0">
                <strong>Religion:</strong>
                <?php echo ucfirst($employee -> religion) ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Nationality:</strong>
                <?php echo $employee -> nationality ?>
            </td>
            <td style="border: 0">
                <strong>CNIC:</strong>
                <?php echo $employee -> cnic ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Tel(Land Line):</strong>
                <?php echo $employee -> residence_mobile ?>
            </td>
            <td style="border: 0">
                <strong>Mobile#1:</strong>
                <?php echo $employee -> mobile ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Mobile#2:</strong>
                <?php echo $employee -> mobile_2 ?>
            </td>
            <td style="border: 0">
                <strong>Email Address:</strong>
                <?php echo $employee -> email ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0" colspan="2">
                <strong>Residential Address:</strong>
                <?php echo $employee -> permanent_address ?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
        <tr>
            <td colspan="2" align="left">
                <h2>Employment Details</h2>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 0">
                <strong>Employee Post/Designation:</strong>
                <?php echo $employee -> department_id > 0 ? get_department($employee -> department_id) -> name : '' ?>
            </td>
            <td style="border: 0">
                <strong>Hiring Date:</strong>
                <?php echo date('d/m/Y', strtotime($employee -> hiring_date)) ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Contract Date:</strong>
                <?php echo date('d/m/Y', strtotime($employee -> contract_date)) ?>
            </td>
            <td style="border: 0">
                <strong>Basic Pay:</strong>
                <?php echo $employee -> basic_pay ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Medical Allowance:</strong>
                <?php echo $employee -> medical_allowance ?>
            </td>
            <td style="border: 0">
                <strong>Transport Allowance:</strong>
                <?php echo $employee -> transport_allowance ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Accommodation Allowance:</strong>
                <?php echo $employee -> rent_allowance ?>
            </td>
            <td style="border: 0">
                <strong>Mobile Allowance:</strong>
                <?php echo $employee -> mobile_allowance ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Food Allowance:</strong>
                <?php echo $employee -> food_allowance ?>
            </td>
            <td style="border: 0">
                <strong>Other Allowance:</strong>
                <?php echo $employee -> other_allowance ?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
        <tr>
            <td colspan="2" align="left">
                <h2>Bank Details</h2>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 0">
                <strong>Bank Name:</strong>
                <?php echo @$bank -> bank_info ?>
            </td>
            <td style="border: 0">
                <strong>Swift/Br. Code:</strong>
                <?php echo @$bank -> swift_code ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Account Number:</strong>
                <?php echo @$bank -> acc_number ?>
            </td>
            <td style="border: 0">
                <strong>N.T.N No:</strong>
                <?php echo @$bank -> ntn_number ?>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
        <tr>
            <td colspan="2" align="left">
                <h2>Last Employment Details</h2>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 0">
                <strong>Company Name:</strong>
                <?php echo @$history -> company ?>
            </td>
            <td style="border: 0">
                <strong>Address:</strong>
                <?php echo @$history -> address ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Contact No:</strong>
                <?php echo @$history -> contact ?>
            </td>
            <td style="border: 0">
                <strong>Post/Designation:</strong>
                <?php echo @$history -> designation ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Duration of Job:</strong>
                <?php echo @$history -> duration ?>
            </td>
            <td style="border: 0">
                <strong>Salary Package:</strong>
                <?php echo @$history -> salary ?>
            </td>
        </tr>
        <tr>
            <td style="border: 0">
                <strong>Salary Package:</strong>
                <?php echo @$history -> benefits ?>
            </td>
            <td style="border: 0">
                <strong>Reason for Leaving Job:</strong>
                <?php echo @$history -> leaving_reason ?>
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>