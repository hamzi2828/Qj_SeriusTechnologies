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
        }

        .items td.cost {
            text-align: center;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br />Transaction#<?php echo $transaction_id ?></span></td>
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
<div style="text-align: right">
    <strong>Receipt Date:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3>
                <?php
				$heading = '';
                if ( count ( $transactions ) > 0 )
					$heading = voucher_number_naming( $transactions[0] -> voucher_number);
                ?>
                <strong> <?php echo $heading ?> </strong>
            </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
    <tr style="background: #f5f5f5;">
        <td>Sr. No.</td>
        <td>Voucher#</td>
        <td>Date</td>
        <td>Account Head</td>
        <td>Description</td>
        <td>Debit</td>
        <td>Credit</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
	<?php
	if ( count ( $transactions ) > 0 ) {
		$counter = 1;
		$credit = 0;
		$debit = 0;
		foreach ( $transactions as $transaction ) {
			if ( $transaction -> transaction_type != 'opening_balance' ) {
				$credit = $credit + $transaction -> credit;
				$debit  = $debit + $transaction -> debit;
				$parent = get_account_head_parent ( $transaction -> acc_head_id );
				$second_transaction = get_second_transaction_by_voucher_number($transaction -> voucher_number, $transaction -> id);
			}
			?>
            <tr>
                <td align="center"><?php echo $counter++ ?></td>
                <td align="center"><?php echo $transaction -> voucher_number ?></td>
                <td align="center"><?php echo date_setter ( $transaction -> trans_date ) ?></td>
                <td align="center"><?php echo get_account_head ( $transaction -> acc_head_id ) -> title ?></td>
                <td align="center"><?php echo $transaction -> description ?></td>
                <td align="center"><?php echo $transaction -> credit ?></td>
                <td align="center"><?php echo $transaction -> debit ?></td>
            </tr>
			<?php
            if(!empty($second_transaction)) {
				$credit = $credit + $second_transaction -> credit;
				$debit  = $debit + $second_transaction -> debit;
                ?>
                <tr>
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="center"><?php echo $second_transaction -> voucher_number ?></td>
                    <td align="center"><?php echo date_setter ( $second_transaction -> trans_date ) ?></td>
                    <td align="center"><?php echo get_account_head ( $second_transaction -> acc_head_id ) -> title ?></td>
                    <td align="center"><?php echo $second_transaction -> description ?></td>
                    <td align="center"><?php echo $second_transaction -> credit ?></td>
                    <td align="center"><?php echo $second_transaction -> debit ?></td>
                </tr>
            <?php
            }
		}
		?>

        <!-- END ITEMS HERE -->
        <tr>
            <td class="blanktotal" colspan="5"></td>
            <td class="totals cost">Pkr-<?php echo $credit ?>/-</td>
            <td class="totals cost"><b>Pkr-<?php echo $debit ?>/-</b></td>
        </tr>
		<?php
	}
	?>
    </tbody>
</table>
</body>
</html>