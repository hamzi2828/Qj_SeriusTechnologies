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
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"><br><br /><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /></span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo $user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> OT Timings </strong></h3>
        </td>
    </tr>
</table>
<br>

<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Sale ID</th>
        <th> Patient EMR</th>
        <th> Patient Name</th>
        <th> Patient Type</th>
        <th> Consultant</th>
        <th> Procedures</th>
        <th> Patient In Time</th>
        <th> Patient Out Time</th>
        <th> Difference in Time</th>
        <th> User Name</th>
        <th> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $timings ) > 0 ) {
            foreach ( $timings as $timing ) {
                $consultant = get_ipd_patient_consultant ( $timing -> sale_id );
                $patient = get_patient ( $timing -> patient_id );
                $procedures = get_ipd_procedures ( $timing -> sale_id );
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo $timing -> sale_id ?></td>
                    <td><?php echo $patient -> id ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td>
                        <?php
                            echo ucfirst ( $patient -> type );
                            if ( $patient -> panel_id > 0 )
                                echo ' / ' . get_panel_by_id ( $patient -> panel_id ) -> name;
                        ?>
                    </td>
                    <td><?php echo @get_doctor ( $consultant -> doctor_id ) -> name ?></td>
                    <td>
                        <?php
                            if ( count ( $procedures ) > 0 ) {
                                foreach ( $procedures as $procedure ) {
                                    echo @get_ipd_service_by_id ( $procedure -> service_id ) -> title . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo $timing -> in_time ?></td>
                    <td><?php echo $timing -> out_time ?></td>
                    <td>
                        <?php
                            $in_time = new DateTime( $timing -> in_time );
                            $out_time = new DateTime( $timing -> out_time );
                            $interval = $in_time -> diff ( $out_time );
                            echo $interval -> m . " Months <br/> " . $interval -> d . " Days <br/> " . $interval -> h . " Hours <br/> " . $interval -> i . " Minutes ";
                        ?>
                    </td>
                    <td><?php echo get_user ( $timing -> user_id ) -> name ?></td>
                    <td><?php echo date_setter ( $timing -> created_at ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>