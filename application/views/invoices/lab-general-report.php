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
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"> <br><br><br>
		</td>
		<td width="50%" style="text-align: right;">
			<span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br />
			<?php echo hospital_address ?><br />
			<span style="font-family:dejavusanscondensed;">&#9742;</span>
			<?php echo hospital_phone ?>
		</td>
	</tr>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
		Page {PAGENO} of {nb}
	</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" page="all" value="on" />
mpdf-->
<div style="text-align: right">
    <strong>Receipt Date:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<div style="text-align: right">
    <strong>Search Criteria:</strong>
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?> @
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Lab General Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Sale ID#</th>
        <th> Test</th>
        <th> Patient</th>
        <th> Patient Type</th>
        <th> Price</th>
        <th> Discount(%)</th>
        <th> Net Price</th>
        <th> Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $reports ) > 0 ) {
            $counter = 1;
            $total = 0;
            $p_total = 0;
            foreach ( $reports as $report ) {
                $patient = get_patient ( $report -> patient_id );
                $sale = get_lab_sale ( $report -> sale_id );
                $total = $total + $sale -> total;
                $p_total = $p_total + $report -> price;
                $tests = explode ( ',', $report -> tests );
                ?>
                <tr>
                    <td> <?php echo $counter++ ?> </td>
                    <td> <?php echo $report -> sale_id ?> </td>
                    <td>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    if ( !check_if_test_is_child ( $test ) )
                                        echo get_test_by_id ( $test ) -> name . '<br>';
                                }
                            } ?>
                    </td>
                    <td> <?php echo $patient -> name ?> </td>
                    <td> <?php echo ucfirst ( $patient -> type ) ?> </td>
                    <td> <?php echo $report -> price ?> </td>
                    <td> <?php echo $sale -> discount ?> </td>
                    <td> <?php echo $sale -> total ?> </td>
                    <td> <?php echo date_setter ( $report -> date_added ) ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="5" class="text-right"><b>Total</b></td>
                <td><?php echo $p_total ?></td>
                <td class="text-right"><b>Net Total</b></td>
                <td><?php echo $total ?></td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>