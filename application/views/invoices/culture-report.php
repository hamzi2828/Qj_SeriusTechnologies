<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
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
        }

        .items td.cost {
            text-align: center;
        }

        .report {
            width: 100%;
            display: block;
            float: left;
            margin-top: 10px;
        }

        .report h3 {
            font-weight: 800 !important;
            margin-top: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000000;
        }

        .report h2 {
            font-weight: 600 !important;
            margin-top: 10px;
            padding-bottom: 0;
        }

        .report p {
            font-size: 14px;
            color: #000000;
            margin-top: 0;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<?php
    $patient_id = get_patient_id_by_sale_id ( $report -> sale_id );
    $patient    = get_patient ( $patient_id );
    if ( isset( $_REQUEST[ 'logo' ] ) and $_REQUEST[ 'logo' ] == 'true' ) :
        ?>
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>"style="height: 80px;">
		</td>
		<td width="50%" style="text-align: right;">
			<img src="<?php echo base_url ( '/assets/img/receipt-site-name.jpeg' ) ?>" style="height: 40px"><br />
			<span style="font-size: 8pt"><?php echo hospital_address ?></span><br>
			<span style="font-family:dejavusanscondensed;font-size: 8pt">&#9742;</span>
			<span style="font-size: 8pt"><?php echo hospital_phone ?></span>
		</td>
	</tr>
</table>
<?php endif; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<?php if ( isset( $_REQUEST[ 'logo' ] ) and $_REQUEST[ 'logo' ] == 'true' ) : ?>
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

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<?php
    if ( isset( $_REQUEST[ 'logo' ] ) and $_REQUEST[ 'logo' ] == 'true' )
        $marginTop = '115px';
    else {
        echo '<br/><br/>';
        $marginTop = '170px';
    }
?>
<p style="width: 100%; text-align: left; color: #000000; font-size: 11px; position: absolute; z-index: 9999; top: <?php echo $marginTop ?>">
    <strong>QJ Diagnostic is established in the memory of the beloved mother of Dr. Jamal Nasir (CEO of Citilab) and
            Zubair Nasir</strong>
</p>
<table width="100%">
    <tr>
        <td width="50%" align="left" style="color:#000; ">
            <span style="font-size: 8pt">
                <strong>Invoice ID:</strong> <?php echo @$report -> sale_id ?><br>
                <strong> MR Number: </strong> <?php echo @$patient -> id ?><br>
                <strong> Name: </strong> <?php echo $patient -> prefix . ' ' . @$patient -> name ?><br>
                <?php
                    if ( !empty( trim ( $patient -> father_name ) ) && !empty( trim ( $patient -> relationship ) ) )
                        echo '<span style="font-size: 8pt;"><strong>' . $patient -> relationship . ': </strong>' . $patient -> father_name . '</span><br/>';
                    if ( !empty( trim ( $patient -> passport ) ) )
                        echo '<span style="font-size: 8pt;"><strong>Patient Passport: </strong>' . $patient -> passport . '</span><br/>';
                    if ( !empty( trim ( $patient -> cnic ) ) )
                        echo '<span style="font-size: 8pt;"><strong>CNIC: </strong>' . $patient -> cnic . '</span><br/>';
                ?>
                <strong> Gender: </strong>
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
                <br>
                <strong> Age: </strong> <?php echo @$patient -> age . ' ' . ucwords ( $patient -> age_year_month ) ?><br>
                <?php if ( !empty( trim ( @$report -> order_by ) ) ) : $doctor = get_doctor ( @$report -> order_by ) ?>
                    <strong> Referred By: </strong> <?php echo @$doctor -> name ?><br>
                <?php endif; ?>
                <?php
                    if ( !empty( trim ( @$report -> sample_id ) ) ) :
                        $sample = get_sample_by_id ( @$report -> sample_id );
                        ?>
                    <?php endif; ?>
            </span>
        </td>
        <td width="50%" align="right" style="font-size: 8pt">
            <?php /* $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $report -> id ); ?>
            <img src="https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=<?php echo $barcodeValue ?>&choe=UTF-8"
                 title="<?php echo $barcodeValue ?>" style="margin-top: -30px; margin-right: -20px" /> <br /> <?php */ ?>
            <strong> Sample Date: </strong> <?php echo date_setter ( $lab -> date_sale ) ?><br>
            <strong> Date/Time: </strong> <?php echo date_setter ( $report -> date_added ) ?>
        </td>
    </tr>
</table>
<div class="report">
    <h3 style="text-align: center; margin-top: 0">
        <strong><?php echo ucwords ( @$report -> report_title ) ?></strong>
    </h3>
</div>

<table width="100%" border="0">
    <tbody>
    <?php
        if ( !empty( trim ( @$report -> sample_id ) ) ) :
            $sample = get_sample_by_id ( @$report -> sample_id );
            ?>
            <tr>
                <td width="100%">
                    <strong> Specimen: </strong> <?php echo @$sample -> name ?>
                </td>
            </tr>
        <?php
        endif;
    ?>
    </tbody>
</table>
<br /><br />
<?php
    if ( !empty( $report ) && ( strpos ( $report -> study, "table" ) !== false ) ) {
        echo $report -> study;
    }
    
    if ( !empty( $report ) && ( strpos ( $report -> conclusion, "table" ) !== false ) ) {
        echo $report -> conclusion;
    }
    
    if ( !empty( $report ) && ( strpos ( $report -> study, "table" ) === false ) && ( strpos ( $report -> conclusion, "table" ) === false ) ) {
        ?>
        <table width="100%" border="0">
            <tbody>
            <?php if ( !empty( trim ( $report -> study ) ) ) : ?>
                <tr>
                    <td width="100%">
                        <br>
                        <?php echo $report -> study ?>
                    </td>
                </tr>
            <?php endif; ?>
            
            <?php if ( !empty( trim ( $report -> conclusion ) ) ) : ?>
                <tr>
                    <td width="100%">
                        <br /><br /><br />
                        <?php echo $report -> conclusion ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php
    }
?>

<br />
<?php if ( count ( $antibiotics ) > 0 ) : ?>
    <h2><strong>Antibiotic (Susceptibility)</strong></h2>
    <table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="5" border="1">
        <thead>
        <tr>
            <td></td>
            <td></td>
            <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
                <th>
                    <table width="100%" border="1">
                        <thead>
                        <tr>
                            <th>Organism 1</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $report -> organism_1 ?></td>
                        </tr>
                        </tbody>
                    </table>
                </th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
                <th>
                    <table width="100%" border="1">
                        <thead>
                        <tr>
                            <th>Organism 2</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $report -> organism_2 ?></td>
                        </tr>
                        </tbody>
                    </table>
                </th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
                <th>
                    <table width="100%" border="1">
                        <thead>
                        <tr>
                            <th>Organism 3</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $report -> organism_3 ?></td>
                        </tr>
                        </tbody>
                    </table>
                </th>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Sr.No</th>
            <th>Antibiotic</th>
            <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
                <th>Result</th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
                <th>Result</th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
                <th>Result</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            if ( count ( $antibiotics ) > 0 ) {
                foreach ( $antibiotics as $antibiotic ) {
                    $antibioticInfo = get_antibiotic_by_id ( $antibiotic -> antibiotic_id );
                    ?>
                    <tr>
                        <td align="center"><?php echo $counter++; ?></td>
                        <td align="center"><?php echo $antibioticInfo -> title ?></td>
                        <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
                            <td align="center"><?php echo $antibiotic -> result_1; ?></td>
                        <?php endif; ?>
                        <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
                            <td align="center"><?php echo $antibiotic -> result_2; ?></td>
                        <?php endif; ?>
                        <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
                            <td align="center"><?php echo $antibiotic -> result_3; ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
    
    <table width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="5" border="0">
        <tbody>
        <tr>
            <td>
                <strong style="color: #FF0000">S: Sensitive</strong>
            </td>
            <td>
                <strong style="color: #FF0000">IS: Intermediate Sensitive</strong>
            </td>
            <td>
                <strong style="color: #FF0000">IR: Intermediate Resistant</strong>
            </td>
            <td>
                <strong style="color: #FF0000">R: Resistant</strong>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>