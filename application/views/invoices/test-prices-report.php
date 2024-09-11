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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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

        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
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

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Test Prices Report </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th align="center"> Sr. No</th>
        <th align="left"> Name</th>
        <th align="left"> Type</th>
        <th align="left"> Panel</th>
        <th align="center"> Price</th>
        <th align="center"> Discounted Price</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $net = 0;
        $discount_net = 0;
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
//                $test = get_test_by_id ( $report -> test_id );
                $prices = explode ( ',', $report -> prices );
                $panels = explode ( ',', $report -> panels );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left"> <?php echo @$report -> test_name ?> </td>
                    <td align="left"> <?php echo @ucwords ( $report -> test_type ) ?> </td>
                    <td align="left">
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    $panelInfo = get_panel_by_id ( $panel );
                                    echo @$panelInfo -> name . '<br/>';
                                }
                            } ?>
                    </td>
                    <td align="center">
                        <?php
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    $net = $net + $price;
                                    echo @number_format ( $price, 2 ) . '<br/>';
                                }
                            } ?>
                    </td>
                    <td align="center">
                        <?php
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    $discounted_price = $price - ( $price * ( $report -> discount / 100 ) );
                                    $discount_net = $discount_net + $discounted_price;
                                    echo number_format ( $discounted_price, 2 ) . '<br/>';
                                }
                            } ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>