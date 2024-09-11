<?php header ( 'Content-Type: application/pdf' ); ?>
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
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px" style="width: 120px"></td>
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
            <h3><strong> Face Sheet </strong></h3>
        </td>
    </tr>
</table>
<br>
<?php if ( !empty( trim ( $patient -> picture ) ) ) : ?>
    <table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
        <tr>
            <td style="width: 100%;text-align: right">
                <img src="<?php echo $patient -> picture ?>" style="width: 100px; display: block;">
            </td>
        </tr>
    </table>
<?php endif ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%;text-align: right">
            <strong>Registration Date:</strong> <?php echo date_setter ( $patient -> date_registered ) ?>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <tr>
        <td style="width: 25%"><strong>Patient EMR:</strong></td>
        <td><strong><?php echo $patient -> id ?></strong></td>
    </tr>
    <tr>
        <td style="width: 25%"> Patient Name:</td>
        <td> <?php echo $patient -> prefix . ' ' . $patient -> name ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Guardian Name:</td>
        <td> <?php echo $patient -> relationship . ' ' . $patient -> father_name ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Martial Status:</td>
        <td> <?php echo ucfirst ( $patient -> martial_status ) ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Blood Group:</td>
        <td> <?php echo $patient -> blood_group ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Gender:</td>
        <td>
            <?php
                if ( $patient -> gender == '1' )
                    echo 'Male';
                else if ( $patient -> gender == '0' )
                    echo 'Female';
                else if ( $patient -> gender == '2' )
                    echo 'MC';
                else if ( $patient -> gender == '3' )
                    echo 'FC';
            ?>
        </td>
    </tr>
    <tr>
        <td style="width: 25%"> Date of Birth:</td>
        <td> <?php echo ( $patient -> dob != '0000-00-00' and $patient -> dob != '1970-01-01' ) ? date ( 'd-m-Y', strtotime ( $patient -> dob ) ) : '' ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> CNIC:</td>
        <td> <?php echo $patient -> cnic ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Passport:</td>
        <td> <?php echo $patient -> passport ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Country:</td>
        <td> <?php echo $patient -> country ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Mobile Number:</td>
        <td> <?php echo $patient -> mobile ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Email:</td>
        <td> <?php echo $patient -> email ?> </td>
    </tr>
    <?php if ( $patient -> type != 'cash' ) : ?>
        <tr>
            <td style="width: 25%"> Panel:</td>
            <td> <?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( $patient -> doctor_id > 0 ) : ?>
        <tr>
            <td style="width: 25%"> Doctor:</td>
            <td> <?php echo get_doctor ( $patient -> doctor_id ) -> name ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( $patient -> service_id > 0 ) : ?>
        <tr>
            <td style="width: 25%"> OPD Service:</td>
            <td> <?php echo get_service_by_id ( $patient -> service_id ) -> title ?> </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<br>
<h4> Permanent Address </h4>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <tr>
        <td style="width: 25%"> Nationality:</td>
        <td> <?php echo ucfirst ( $patient -> nationality ) ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Address:</td>
        <td> <?php echo $patient -> address ?> </td>
    </tr>
    </tbody>
</table>
<br>
<h4> Emergency Address </h4>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <tr>
        <td style="width: 25%"> Name:</td>
        <td> <?php echo $patient -> emergency_person_name ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Number:</td>
        <td> <?php echo $patient -> emergency_person_number ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Relation:</td>
        <td> <?php echo $patient -> emergency_person_relation ?> </td>
    </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <tr>
        <td style="width: 50%">
            Reviewed By:
            <br><br><br><br><br><br><br><br><br>
            <p style="border-top: 2px solid #000000; padding-top: 15px">Signature & Date</p>
        </td>
        <td style="width: 50%">
            <p> I solemnly affirm and declare that the above information provided by me is true and correct to best of my knowledge and belief and nothing has been concealed there from. </p>
            <br><br><br><br><br>
            <p style="border-top: 2px solid #000000; padding-top: 15px">Signature & Date</p>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>