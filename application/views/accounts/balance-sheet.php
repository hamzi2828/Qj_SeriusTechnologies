<div class="row">
	<div class="col-md-12">
		<div class="search">
			<form method="get" autocomplete="off">
				<div class="form-group col-lg-4 col-lg-offset-3">
					<label for="exampleInputEmail1">Date</label>
					<input type="text" name="trans_date" class="date date-picker form-control" placeholder="Transaction date" required="required" value="<?php echo ( @$_REQUEST[ 'trans_date' ] ) ? @$_REQUEST[ 'trans_date' ] : date ( 'm/d/Y' ) ?>">
				</div>
				<div class="col-lg-1" style="padding-top: 25px">
					<button type="submit" class="btn btn-primary btn-block">Search</button>
				</div>
			</form>
		</div>
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i> Balance Sheet
					<?php
					$trans_date = @$_REQUEST['trans_date'];
					if(isset($trans_date) and !empty($trans_date)) {
						?>
						(<small><?php echo date('jS F Y', strtotime ($trans_date)) ?></small>)
					<?php
					}
					?>
				</div>
                
                <?php if ( isset($trans_date) and !empty($trans_date) ) : ?>
                    <a href="<?php echo base_url ('/invoices/balance-sheet?' . $_SERVER[ 'QUERY_STRING' ]) ?>" target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="">
					<thead>
					<tr>
						<th> Account Head </th>
						<th> Closing Balance </th>
					</tr>
					</thead>
					<tbody>
					    <tr>
                            <td>
                                <h3 style="font-size: 18px; font-weight: 800 !important;"> Assets </h3>
                            </td>
                            <td style="padding-left: 25px">
                                <h3 style="font-size: 18px; font-weight: 800 !important;">
                                    <?php
                                        $C = ( ($cash_balances[ 'net_closing' ]) + $banks[ 'net_closing' ] + $receivable_accounts[ 'net_closing' ] + $inventory[ 'net_closing' ]) + ( ( $furniture_fixture[ 'net_closing' ] + $intangible_assets[ 'net_closing' ] + $bio_medical_surgical_items[ 'net_closing' ] + $machinery_equipment[ 'net_closing' ] + $electrical_equipment[ 'net_closing' ] + $it_equipment[ 'net_closing' ] + $office_equipment[ 'net_closing' ] + $land_building[ 'net_closing' ]) - $accumulated_depreciation[ 'net_closing' ]);
                                        echo number_format (abs ($C), 2);
                                    ?>
                                </h3>
                            </td>
                        </tr>
					    <tr>
                            <td>
                                <h6 style="color: #000000; font-weight: 800 !important;"> Current Assets: </h6>
                            </td>
                            <td></td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($cash_balances['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($cash_balances[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($banks['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($banks[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($receivable_accounts['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($receivable_accounts[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($inventory['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($inventory[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                            </td>
                            <td style="padding-left: 25px">
                                <h6 style="color: #000000; font-weight: 800 !important;">
                                    <?php echo $A = number_format ($cash_balances[ 'net_closing' ] + $banks[ 'net_closing' ] + $receivable_accounts[ 'net_closing' ] + $inventory[ 'net_closing' ], 2) ?>
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6 style="color: #000000; font-weight: 800 !important;"> Non-Current assets:</h6>
                            </td>
                            <td></td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($furniture_fixture['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($furniture_fixture[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($intangible_assets['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($intangible_assets[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($bio_medical_surgical_items['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($bio_medical_surgical_items[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($machinery_equipment['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($machinery_equipment[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($electrical_equipment['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($electrical_equipment[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($it_equipment['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($it_equipment[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($office_equipment['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($office_equipment[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($land_building['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($land_building[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                            </td>
                            <td style="padding-left: 25px">
                                <h6 style="color: #000000; font-weight: 800 !important;">
                                    <?php
                                        $B = $furniture_fixture[ 'net_closing' ] + $intangible_assets[ 'net_closing' ] + $bio_medical_surgical_items[ 'net_closing' ] + $machinery_equipment[ 'net_closing' ] + $electrical_equipment[ 'net_closing' ] + $it_equipment[ 'net_closing' ] + $office_equipment[ 'net_closing' ] + $land_building[ 'net_closing' ];
                                        echo number_format (abs ($B), 2);
                                        ?>
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo get_account_head ($accumulated_depreciation[ 'account_head_id' ]) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php
                                    echo number_format (abs ($accumulated_depreciation[ 'net_closing' ]), 2);
                                    $U = $accumulated_depreciation[ 'net_closing' ];
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6 style="color: #000000; font-weight: 800 !important;"> Net Non-Current Assets</h6>
                            </td>
                            <td style="padding-left: 25px">
                                <?php
                                    $P = ($B) - ($U);
                                    echo number_format (@abs ($P), 2);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 18px; font-weight: 800 !important;"> Liabilities
                                </h3>
                            </td>
                            <td style="padding-left: 25px">
                                <h3 style="font-size: 18px; font-weight: 800 !important;">
                                    <?php
                                        $F = ( $payable_accounts[ 'net_closing' ] + $accrued_expenses[ 'net_closing' ] + $unearned_revenue[ 'net_closing' ] + $WHT_payable[ 'net_closing' ]) + ( $long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ]);
                                        echo number_format (abs ($F), 2);
                                        ?>
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h6 style="color: #000000; font-weight: 800 !important;"> Current liabilities:
                                </h6>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($payable_accounts[ 'account_head_id' ]) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($payable_accounts[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($accrued_expenses['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($accrued_expenses[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($unearned_revenue['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($unearned_revenue[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td style="padding-left: 25px">
                                <?php echo get_account_head ($WHT_payable['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($WHT_payable[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                            </td>
                            <td style="padding-left: 25px">
                                <h6 style="color: #000000; font-weight: 800 !important;">
                                    <?php echo $D = number_format (abs ($payable_accounts[ 'net_closing' ] + $accrued_expenses[ 'net_closing' ] + $unearned_revenue[ 'net_closing' ] + $WHT_payable[ 'net_closing' ]), 2) ?>
                                </h6>
                            </td>
                        </tr>
					    <tr>
                            <td>
                                <?php echo get_account_head ($long_term_debt['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($long_term_debt[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
					    <tr>
                            <td>
                                <?php echo get_account_head ($other_long_term_liabilities['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php echo number_format (abs ($other_long_term_liabilities[ 'net_closing' ]), 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                            </td>
                            <td style="padding-left: 25px">
                                <h6 style="color: #000000; font-weight: 800 !important;">
                                    <?php echo $E = number_format (abs ($long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ]), 2) ?>
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="font-size: 18px; font-weight: 800 !important;"> Shareholder's Equity
                            
                                </h3>
                            </td>
                            <td>
                                <h3 style="font-size: 18px; font-weight: 800 !important;"></h3>
                            </td>
                        </tr>
					    <tr>
                            <td>
                                <?php echo get_account_head ($capital['account_head_id']) -> title ?>
                            </td>
                            <td style="padding-left: 25px">
                                <?php
                                    $G = $capital[ 'net_closing' ];
                                    echo number_format (abs ($G), 2)
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Net Profit</td>
                            <td style="padding-left: 25px">
                                <?php
                                    $H = $calculate_net_profit;
                                    echo number_format (abs ($H), 2)
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <h6 style="color: #000000; font-weight: 800 !important;"> Total: </h6>
                            </td>
                            <td style="padding-left: 25px">
                                <h6 style="color: #000000; font-weight: 800 !important;">
                                    <?php echo $I = number_format (abs ($G + $H), 2) ?>
                                </h6>
                            </td>
                        </tr>
                    </tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<style>
	.input-xsmall {
		width: 100px !important;
	}
	
	.opening td {
		background-color: rgba(0, 255, 0, 0.3) !important;
	}
</style>
