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
    <?php 
        // Display the date range
        if (!empty($this->input->get('start-date')) && !empty($this->input->get('end-date'))) {
            echo date('d-m-Y', strtotime($this->input->get('start-date'))) . ' - ' . date('d-m-Y', strtotime($this->input->get('end-date')));
        } else {
            echo 'No date range specified';
        }

        // Check and display the selected OEP
        if (!empty($this->input->get('oep-id'))) {
            $oep_id = $this->input->get('oep-id');
            $this->load->model('MedicalTestModel');
            $oep_details = $this->MedicalTestModel->get_details_of_oep_by_id($oep_id);

            if (!empty($oep_details)) {
           
                echo "<strong> | OEP:</strong> " . $oep_details->name;
            } else {
                echo " | OEP: Not Found";
            }
        }
    ?>
</td>
    </tr>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 25px" cellpadding="8" border="1">
    <thead>
    <tr>
        <th align="right">Sr. No</th>
        <th align="left">Lab No</th>
        <th align="left">Name</th>
        <th align="left">Father Name</th>
        <th align="left">CNIC | Passport</th>
        <th align="left">Trade | Natl</th>
        <th align="left">Age | Gen (DOB)</th>
        <th align="left">Country to Visit</th>
        <th align="left">Spec. Received</th>
        <th align="left">OEP/Ref By</th>
        <th align="left">Payment Method</th>
        <th align="left">Payment</th>
        <th align="left">Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $total_payments = 0; // Initialize total payments

        if (count($tests) > 0) {
            foreach ($tests as $test) {
                $country     = get_country_by_id($test->country_id);
                $age         = calculateAge($test->dob);
                $nationality = get_country_by_id($test->nationality);

                // Calculate payment for the test
                $this->load->model('MedicalTestModel');
                $oep_details = $this->MedicalTestModel->get_details_of_oep_by_id($test->oep_id);
                $payment = isset($oep_details->price) ? $oep_details->price : 0;
                $total_payments += $payment; // Add to total payments
                ?>
                <tr>
                    <td align="right"><?php echo $counter++ ?></td>
                    <td><?php echo medical_test_lab_no_prefix . $test->lab_no ?></td>
                    <td><?php echo $test->name ?? 'N/A' ?></td>
                    <td><?php echo $test->father_name ?? 'N/A' ?></td>
                    <td>
                        <?php
                            echo $test->identity ?? '';
                            echo !empty(trim($test->passport)) ? '|' . $test->passport : '';
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $test->trade ?? '';
                            echo isset($nationality->title) ? '|' . $nationality->title : '';
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $age ?? '-';
                            echo !empty(trim($test->gender)) ? '|' . ucwords($test->gender) : '';
                        ?>
                    </td>
                    <td><?php echo $country->title ?? '-' ?></td>
                    <td><?php echo date_setter($test->spec_received) ?></td>
                    <td><?php echo $test->oep ?? 'N/A' ?></td>
                    <td><?php echo ucwords($test->payment_method ?? 'Not Specified') ?></td>
                    <td><?php echo $payment > 0 ? $payment : '0.00'; ?></td>
                    <td>
                        <?php
                            switch ($test->fit) {
                                case '1':
                                    echo '<span class="badge badge-success">Fit</span>';
                                    break;
                                case '2':
                                    echo '<span class="badge badge-warning">Pending</span>';
                                    break;
                                case '3':
                                    echo '<span class="badge badge-primary">Defer</span>';
                                    break;
                                default:
                                    echo '<span class="badge badge-danger">UnFit</span>';
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="11" style="text-align: right; font-weight: bold;">Total Payments:</td>
            <td><strong><?php echo $total_payments; ?></strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>


</body>
</html>