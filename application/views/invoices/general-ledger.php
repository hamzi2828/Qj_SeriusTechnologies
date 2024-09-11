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
<div style="text-align: right">
    <strong>Receipt Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<div style="text-align: right">
    <strong>Search Criteria:</strong>
    <?php echo date('d-m-Y', strtotime(@$_REQUEST['start_date'])) ?> @
    <?php echo date('d-m-Y', strtotime(@$_REQUEST['end_date'])) ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> General Ledger </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Trans. ID</th>
        <th> Invoice/Sale ID</th>
        <th> Voucher No.</th>
        <th> Date</th>
        <th> Account Head</th>
        <th> Description</th>
        <th> Debit</th>
        <th> Credit</th>
        <th> Running Balance</th>
    </tr>
    </thead>
    <tbody>
	<?php
	$net_closing_balance = 0;
	if($ledgers and count($ledgers) > 0) {
		foreach ($ledgers as $ledger) {
			$acc_head_id = $ledger->id;
			$transactions = get_transactions($acc_head_id);
			if ($transactions and count($transactions) > 0) {
				end($transactions);
				$last_key = key($transactions);

				$counter = 1;
				$total_credit = 0;
				$total_debit = 0;
				$running_balance = 0;
				foreach ($transactions as $key => $transaction) {
					$parent = get_account_head_parent($transaction->acc_head_id);
					if ($transaction->transaction_type == 'opening_balance' and $counter == 1)
						$running_balance = $transaction->debit + $transaction->credit; else if (!empty($parent) and ($parent == bank_id or $parent == cash_from_pharmacy or $parent == cash_from_lab or $parent == cash_from_opd))
						$running_balance = ($running_balance + $transaction->credit) - $transaction->debit; else if ($transaction->acc_head_id == cash_from_pharmacy or $transaction->acc_head_id == cash_from_lab or $transaction->acc_head_id == cash_from_opd)
						$running_balance = ($running_balance + $transaction->credit) - $transaction->debit; else
						$running_balance = ($running_balance - $transaction->debit) + $transaction->credit;
//					if ($key == $last_key)
//						$net_closing_balance += $running_balance;
					$second = check_id_double_entry($transaction -> voucher_number, $transaction -> id);
					?>
                    <tr class="odd gradeX <?php if ($transaction->transaction_type == 'opening_balance')
						echo 'opening' ?>">
                        <td><?php echo $counter++ ?></td>
                        <td>
							<?php
							echo '<strong>'.$transaction->id.'</strong><br>';

							if(count($second) > 0) {
							    foreach ($second as $item) {
							        echo $item -> id . '<br>';
                                }
                            }
							?>
                        </td>
                        <td>
                            <?php
                                if ( !empty( trim ( $transaction -> invoice_id ) ) )
                                    echo $transaction -> invoice_id;
                                else if ( !empty( trim ( $transaction -> internal_issuance_id ) ) )
                                    echo $transaction -> internal_issuance_id;
                                else
                                    echo $transaction -> stock_id;
                            ?>
                        </td>
                        <td><?php echo $transaction->voucher_number ?></td>
                        <td><?php echo date_setter($transaction->trans_date) ?></td>
                        <td><?php echo get_account_head($transaction->acc_head_id)->title ?></td>
                        <td><?php echo $transaction->description ?></td>
                        <td><?php echo $transaction->credit ?></td>
                        <td><?php echo $transaction->debit ?></td>
                        <td><?php echo $running_balance ?></td>
                    </tr>
					<?php
					if ($transaction->transaction_type != 'opening_balance') {
						$total_credit += $transaction->credit;
						$total_debit += $transaction->debit;
					}
				}
                
                $net_closing_balance += ( $total_credit - $total_debit );
			}
		}
	}
	?>
    </tbody>
	<?php
	if ($transactions and count($transactions) > 0) {
		?>
        <tfoot>
        <tr>
            <th colspan="8" style="text-align: right"> <?php echo $total_credit ?></th>
            <th> <?php echo $total_debit ?></th>
            <th></th>
        </tr>
        </tfoot>
		<?php
	}
	?>
</table>
<h4 style="width: 100%; display: block; float: right; text-align: right;">
    <strong>Net closing balance: </strong> <?php echo number_format($net_closing_balance) ?>
</h4>
</body>
</html>