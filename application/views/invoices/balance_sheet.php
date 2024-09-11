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
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="firstpage">
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"><br><br /><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /></span></td>
</tr></table>
</htmlpageheader>
<htmlpageheader name="otherpages" style="display:none"></htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo @$user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br/>
<div style="text-align: right">
	<strong>Search Criteria:</strong>
	<?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'trans_date' ] ) ) ?>
	<?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'trans_date' ] ) ) : '' ?>
</div>
<br/>
<br/>
<br/>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Balance Sheet </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Account Head</th>
        <th> Closing Balance</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <strong> Assets </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php
                    $C = ( ( $cash_balances[ 'net_closing' ] ) + $banks[ 'net_closing' ] + $receivable_accounts[ 'net_closing' ] + $inventory[ 'net_closing' ] ) + ( ( $furniture_fixture[ 'net_closing' ] + $intangible_assets[ 'net_closing' ] + $bio_medical_surgical_items[ 'net_closing' ] + $machinery_equipment[ 'net_closing' ] + $electrical_equipment[ 'net_closing' ] + $it_equipment[ 'net_closing' ] + $office_equipment[ 'net_closing' ] + $land_building[ 'net_closing' ] ) - $accumulated_depreciation[ 'net_closing' ] );
                    echo number_format (abs ($C), 2);
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Current Assets: </strong>
        </td>
        <td></td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($cash_balances[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($cash_balances[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($banks[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($banks[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($receivable_accounts[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($receivable_accounts[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($inventory[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($inventory[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php echo $A = number_format ($cash_balances[ 'net_closing' ] + $banks[ 'net_closing' ] + $receivable_accounts[ 'net_closing' ] + $inventory[ 'net_closing' ], 2) ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Non-Current assets:</strong>
        </td>
        <td></td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($furniture_fixture[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($furniture_fixture[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($intangible_assets[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($intangible_assets[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($bio_medical_surgical_items[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($bio_medical_surgical_items[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($machinery_equipment[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($machinery_equipment[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($electrical_equipment[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($electrical_equipment[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($it_equipment[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($it_equipment[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($office_equipment[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($office_equipment[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($land_building[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($land_building[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php
                    $B = $furniture_fixture[ 'net_closing' ] + $intangible_assets[ 'net_closing' ] + $bio_medical_surgical_items[ 'net_closing' ] + $machinery_equipment[ 'net_closing' ] + $electrical_equipment[ 'net_closing' ] + $it_equipment[ 'net_closing' ] + $office_equipment[ 'net_closing' ] + $land_building[ 'net_closing' ];
                    echo number_format (abs ($B), 2);
                ?>
            </strong>
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
            <strong> Net Non-Current Assets</strong>
        </td>
        <td style="padding-left: 25px">
            <?php
                $P = ( $B ) - ( $U );
                echo number_format (@abs ($P), 2);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Liabilities
            </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php
                    $F = ( $payable_accounts[ 'net_closing' ] + $accrued_expenses[ 'net_closing' ] + $unearned_revenue[ 'net_closing' ] + $WHT_payable[ 'net_closing' ] ) + ( $long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ] );
                    echo number_format (abs ($F), 2);
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Current liabilities:
            </strong>
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
            <?php echo get_account_head ($accrued_expenses[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($accrued_expenses[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($unearned_revenue[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($unearned_revenue[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td style="padding-left: 25px">
            <?php echo get_account_head ($WHT_payable[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($WHT_payable[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php echo $D = number_format (abs ($payable_accounts[ 'net_closing' ] + $accrued_expenses[ 'net_closing' ] + $unearned_revenue[ 'net_closing' ] + $WHT_payable[ 'net_closing' ]), 2) ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo get_account_head ($long_term_debt[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($long_term_debt[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo get_account_head ($other_long_term_liabilities[ 'account_head_id' ]) -> title ?>
        </td>
        <td style="padding-left: 25px">
            <?php echo number_format (abs ($other_long_term_liabilities[ 'net_closing' ]), 2) ?>
        </td>
    </tr>
    <tr>
        <td align="right">
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php echo $E = number_format (abs ($long_term_debt[ 'net_closing' ] + $other_long_term_liabilities[ 'net_closing' ]), 2) ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td>
            <strong> Shareholder's Equity
            
            </strong>
        </td>
        <td>
            <strong></strong>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo get_account_head ($capital[ 'account_head_id' ]) -> title ?>
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
            <strong> Total: </strong>
        </td>
        <td style="padding-left: 25px">
            <strong>
                <?php echo $I = number_format (abs ($G + $H), 2) ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
