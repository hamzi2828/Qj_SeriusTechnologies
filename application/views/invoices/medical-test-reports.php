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
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"></td>
<td width="50%" style="text-align: right;"><img src="<?php echo base_url ( '/assets/img/receipt-site-name.jpeg' ) ?>" style="height: 40px"><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?></span></td>
</tr></table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
	<div style="border-top: 1px solid #000000; font-size: 8pt; text-align: center; padding-top: 3mm; ">
		Page {PAGENO} of {nb}
	</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" page="all" value="on" />
mpdf-->
<hr style="margin-bottom: 0" />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="0"
       border="0">
    <tbody>
    <tr>
        <td align="right">
            <strong>Search Criteria:</strong>
            <?php echo date ( 'd-m-Y', strtotime ( $this -> input -> get ( 'start-date' ) ) ) ?> -
            <?php echo date ( 'd-m-Y', strtotime ( $this -> input -> get ( 'end-date' ) ) ) ?>
        </td>
    </tr>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 25px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Lab No</th>
        <th align="left"> Name</th>
        <th align="left"> Father Name</th>
        <th align="left"> CNIC | Passport</th>
        <th align="left"> Trade | Natl</th>
        <th align="left"> Age | Gen (DOB)</th>
        <th align="left"> Country to Visit</th>
        <th align="left"> Spec. Received</th>
        <th align="left"> OEP/Ref By</th>
        <th align="left"> Payment Method</th>
        <th align="left"> Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $country     = get_country_by_id ( $test -> country_id );
                $age         = calculateAge ( $test -> dob );
                $nationality = get_country_by_id ( $test -> nationality );
                ?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo medical_test_lab_no_prefix . $test -> lab_no ?></td>
                    <td><?php echo $test -> name ?></td>
                    <td><?php echo $test -> father_name ?></td>
                    <td>
                        <?php
                            if ( !empty( trim ( $test -> identity ) ) )
                                echo $test -> identity;
                            
                            if ( !empty( trim ( $test -> passport ) ) )
                                echo '|' . $test -> passport;
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( !empty( trim ( $test -> trade ) ) )
                                echo $test -> trade;
                            
                            if ( !empty( trim ( $test -> nationality ) ) )
                                echo '|' . $nationality -> title;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $age;
                            if ( !empty( trim ( $test -> gender ) ) )
                                echo '|' . ucwords ( $test -> gender )
                        ?>
                    </td>
                    <td><?php echo !empty( $country ) ? $country -> title : '-' ?></td>
                    <td><?php echo date_setter ( $test -> spec_received ) ?></td>
                    
                    <td><?php echo $test -> oep ?></td>
                    <td><?php echo ucwords ( $test -> payment_method ) ?></td>
                    <td>
                        <?php
                            if ( $test -> fit === '1' )
                                echo '<span class="badge badge-success">Fit</span>';
                            else if ( $test -> fit === '2' )
                                echo '<span class="badge badge-warning">Pending</span>';
                            else if ( $test -> fit === '3' )
                                echo '<span class="badge badge-primary">Defer</span>';
                            else if ( $test -> fit === '0' )
                                echo '<span class="badge badge-danger">UnFit</span>';
                        ?>
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