<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
            margin-header: 5mm; /* <any of the usual CSS values for margins> */
            margin-footer: 2mm;
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
        }

        .items td.cost {
            text-align: center;
        }

        .report {
            width: 100%;
            display: block;
            float: left;
            margin-top: 30px;
        }

        .report h2.title {
            font-weight: 800 !important;
            margin-top: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000000;
        }

        .report h2.study, .report h2.conclusion {
            font-weight: 600 !important;
            margin-top: 10px;
            padding-bottom: 0;
            font-size: 14px;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .report p {
            font-size: 14px;
            color: #000000;
            margin-top: 0;
            margin-bottom: 0;
        }

        ul {
            padding-left: 20px !important;
        }

        li {
            list-style-position: outside !important;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="firstpage">
<?php $patient = get_patient ( @$report -> patient_id ) ?>
<?php if ( isset( $_GET[ 'logo' ] ) and $_GET[ 'logo' ] == 'true' ) : ?>
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px">
		</td>
		<td width="50%" style="text-align: right;">
			<img src="<?php echo base_url ( '/assets/img/receipt-site-name.jpeg' ) ?>" style="height: 40px"><br />
			<span style="font-size: 8pt;"><?php echo hospital_address ?></span><br />
			<span style="font-family:dejavusanscondensed; font-size: 8pt;">&#9742;</span>
			<span style="font-size: 8pt;"><?php echo hospital_phone ?></span> <br />
		</td>
	</tr>
</table>
<?php endif; ?>
</htmlpageheader>
<htmlpageheader name="otherpages" style="display:none"></htmlpageheader>

<htmlpagefooter name="myfooter">
<?php if ( isset( $_GET[ 'logo' ] ) and $_GET[ 'logo' ] == 'true' ) : ?>
	<div style="width: 100%; float: left; display:block; text-align: left;">
		<strong> Reported By:  </strong>
		<?php
    $reportedBy     = get_doctor ( @$report -> doctor_id );
    $specialization = get_specialization_by_id ( $reportedBy -> specialization_id );
    echo get_doctor ( @$report -> doctor_id ) -> name . ' (' . $specialization -> title . ') - ' . $reportedBy -> qualification;
    ?>
	</div>
	<div style="width: 100%; float: left; display:block; text-align: center;">
		This is a Computer Generated Report. No need of signature or stamp.
	</div>
	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
		Page {PAGENO} of {nb}
	</div>
<?php else : ?>
    <div style="width: 100%; float: left; display:block; text-align: left;">
		<strong> Reported By:  </strong>
		<?php
    $reportedBy     = get_doctor ( @$report -> doctor_id );
    $specialization = get_specialization_by_id ( $reportedBy -> specialization_id );
    echo get_doctor ( @$report -> doctor_id ) -> name . ' (' . $specialization -> title . ') - ' . $reportedBy -> qualification;
    ?>
    </div>
    <div style="width: 100%; float: left; display:block; text-align: center; padding-bottom: 35px">
		This is a Computer Generated Report. No need of signature or stamp.
	</div>
<?php endif; ?>
</htmlpagefooter>

<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<?php
    $top = '115px';
    if ( !isset( $_REQUEST[ 'logo' ] ) or $_REQUEST[ 'logo' ] == 'false' ) {
        echo '<br/><br/><br/>';
        $top = '170px';
    }
?>
<p style="width: 100%; text-align: left; color: #000000; font-size: 11px; position: absolute; z-index: 9999; top: <?php echo $top ?>">
    <strong>QJ Diagnostic is established in the memory of the beloved mother of Dr. Jamal Nasir (CEO of Citilab) and
            Zubair Nasir</strong>
</p>
<br />
<br />
<br />
<table width="100%">
    <tr>
        <td width="50%" align="left" style="color:#000; ">
            <span style="font-size: 8pt;"><strong> Invoice ID: </strong><?php echo @$report -> sale_id ?><br>
			<span style="font-size: 8pt;"><strong> MR No: </strong> <?php echo @$patient -> id ?></span><br>
			<span style="font-size: 8pt;"><strong> Name: </strong> <?php echo get_patient_name ( 0, $patient ) ?></span><br>
            <?php
                if ( !empty( trim ( $patient -> father_name ) ) && !empty( trim ( $patient -> relationship ) ) )
                    echo '<span style="font-size: 8pt;"><strong>' . $patient -> relationship . ': </strong>' . $patient -> father_name . '</span><br/>';
                if ( !empty( trim ( $patient -> passport ) ) )
                    echo '<span style="font-size: 8pt;"><strong>Patient Passport: </strong>' . $patient -> passport . '</span><br/>';
                if ( !empty( trim ( $patient -> cnic ) ) )
                    echo '<span style="font-size: 8pt;"><strong>CNIC: </strong>' . $patient -> cnic . '</span><br/>';
            ?>
			<span style="font-size: 8pt;"><strong> Gender: </strong>
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
            </span><br>
			<span style="font-size: 8pt;">
                <strong> Age: </strong>
                <?php
                    echo @$patient -> age . ' ' . ucwords ( $patient -> age_year_month );
                ?>
            </span><br>
                <?php
                    if ( $report -> order_by > 0 ) :
                        $orderBy = get_doctor ( $report -> order_by );
                        $specialization = get_specialization_by_id ( $orderBy -> specialization_id );;
                        ?>
                        <span style="font-size: 8pt;">
                        <strong> Referred By: </strong> <?php echo $orderBy -> name; ?>
                    </span><br>
                    <?php endif; ?>
        </td>
        <td width="50%" align="right" style="font-size: 8pt">
            <?php /* $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $report -> id ); ?>
            <img src="https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=<?php echo $barcodeValue ?>&choe=UTF-8"
                 title="<?php echo $barcodeValue ?>" style="margin-top: -30px; margin-right: -20px"/> <br/> <?php */ ?>
            <strong> Report Date/Time: </strong> <?php echo date_setter ( $report -> date_added ) ?>
        </td>
    </tr>
</table>
<br />
<table width="100%">
    <tr>
        <td style="color:#000; text-align: center">
            <h3>
                <strong><?php echo ucwords ( @$report -> report_title ) ?></strong>
            </h3>
            <hr />
        </td>
    </tr>
</table>

<?php echo @$report -> study ?>
<h4 style="margin-bottom: 10px"><strong><u>CONCLUSION</u></strong></h4>
<?php echo @$report -> conclusion ?>

</body>
</html>