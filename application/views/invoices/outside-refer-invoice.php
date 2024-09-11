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

        .parent {
            padding-left: 25px;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%">
<tr>
<td width="50%" style="color:#000; ">
    <strong style="font-size: 18pt"><?php echo get_doctor ( $refer_outside -> doctor_id ) -> name ?></strong> <br/>
    <p style="font-size: 9pt;">Date: <u><?php echo date_setter ( $refer_outside -> created_at, 5 ) ?></u></p>
</td>
<td width="50%" style="text-align: right;"><img src="<?php echo base_url ( '/assets/img/receipt-site-name.jpeg' ) ?>" style="height: 32px"><br /></td>
</tr>
</table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:left; float:left">
<small><b>Signature & Stamp of Doctor: __________________________________</b><br></small>
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%" style="font-size: 8pt; margin-top: 25px">
    <tbody>
    <tr>
        <td align="left">
            <strong style="font-size: 12pt;">Sr.No</strong>
            <strong style="font-size: 12pt"><?php echo $refer_outside -> id ?></strong>
        </td>
        <td align="right">
            <strong style="font-size: 12pt;">Invoice ID#</strong>
            <u style="font-size: 12pt">
                <strong><?php echo $refer_outside -> sale_id ?></strong>
            </u>
        </td>
    </tr>
    <tr>
        <td align="left" colspan="2">
            <strong>Name: </strong>
            <span><?php echo get_patient_name ( 0, $patient ) ?></span> <br />
            <strong>Age/Gender: </strong>
            <span>
                <?php echo get_patient_dob ( $patient ) ?>/
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
            </span> <br />
            <?php if ( !empty( trim ( $patient -> cnic ) ) ) : ?>
                <strong>CNIC: </strong>
                <span><?php echo $patient -> cnic ?></span> <br />
            <?php endif ?>
            <strong>User: </strong>
            <span><?php echo get_user ( $refer_outside -> user_id ) -> name ?></span> <br />
            <strong>Branch: </strong>
            <span><?php echo $refer_outside -> branch ?></span>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" style="font-size: 10pt; margin-top: 25px">
    <thead>
    <tr>
        <th align="center" colspan="2">TESTS REQUIRED</th>
    </tr>
    </thead>
</table>

<table width="100%" style="font-size: 9pt; width: 300px; margin: 10px auto 0 auto" border="0" cellpadding="4px"
       cellspacing="0">
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $test = get_test_by_id ( $sale -> test_id );
                ?>
                <tr>
                    <td width="10%" align="center"><?php echo $counter++ ?>.</td>
                    <td width="90%" align="left"><?php echo $test -> name ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>