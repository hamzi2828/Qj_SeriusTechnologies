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
			<img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" width="120" style="width: 120px"> <br><br><br>
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

<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Lab Cash Balance Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Sale ID</th>
        <th> EMR#</th>
        <th> Patient Name</th>
        <th> Test</th>
        <th> Price</th>
        <th> Discount(%)</th>
        <th> Net Price</th>
        <th> Paid Amount</th>
        <th> Balance</th>
        <th> Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $sales ) > 0 ) {
            $counter = 1;
            foreach ( $sales as $sale ) {
                $sale_info = get_lab_sale ( $sale -> sale_id );
                $patient = get_patient ( $sale -> patient_id );
                $saleTotal = get_lab_sales_total ( $sale -> sale_id );
                $panel_id = $patient -> panel_id;
                $balance = $sale_info -> total - $sale_info -> paid_amount;
                if ( $balance > 0 ) {
                    ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $sale -> sale_id; ?></td>
                        <td><?php echo $sale -> patient_id; ?></td>
                        <td>
                            <?php
                                echo $patient -> name;
                            ?>
                        </td>
                        <td>
                            <?php
                                $tests = explode ( ',', $sale -> tests );
                                if ( count ( $tests ) > 0 ) {
                                    foreach ( $tests as $test_id ) {
                                        $test = get_test_by_id ( $test_id );
                                        echo @$test -> name . '<br>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if ( $sale -> refunded == '1' and !empty( trim ( $sale -> remarks ) ) )
                                    echo number_format ( $saleTotal, 2 );
                                else
                                    echo number_format ( $sale -> price, 2 );
                            ?>
                        </td>
                        <td><?php echo $sale_info -> discount ?></td>
                        <td><?php echo number_format ( $sale_info -> total, 2 ) ?></td>
                        <td><?php echo number_format ( $sale_info -> paid_amount, 2 ) ?></td>
                        <td><?php echo number_format ( $sale_info -> total - $sale_info -> paid_amount, 2 ) ?></td>
                        <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                    </tr>
                    <?php
                }
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>