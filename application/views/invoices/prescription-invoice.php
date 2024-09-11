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
        .details {
            width: 100%;
            display: block;
            float: left;
            margin-bottom: 15px;
        }
        .left {
            width: 35%;
            float: left;
            display: block;
            border-right: 1px solid #a4a4a4;
            padding-right: 10px;
        }
        .right {
            width: 63%;
            float: right;
            display: block;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" style="height: 80px"><br><br /><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /></strong></span><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 18pt;"><?php echo get_doctor($prescription -> doctor_id) -> name; ?></span><span style="font-weight: bold; font-size: 10pt;">
<br><?php echo get_doctor($prescription -> doctor_id) -> qualification; ?>
<br><?php echo get_specialization_by_id(get_doctor($prescription -> doctor_id) -> specialization_id) -> title; ?><br /></strong></span><?php echo get_doctor($prescription -> doctor_id) -> description; ?><br /><span style="font-weight: bold; font-size: 25pt;"><?php echo $prescription -> consultancy_id ?></span><br><br></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><img src="<?php echo base_url('/assets/img/hadiyat.png') ?>" style="height: 80px"><br><br><small><b>Advice/Follow up:</b> <?php if(!empty(trim($prescription -> follow_up)) and $prescription -> follow_up > 0) echo get_follow_up_by_id($prescription -> follow_up) -> title ?><br><br><br><br>_________________________________</small><br><small><b>Doctor's Sign</b></small><br><br></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br/>
<div style="text-align: right">
    <strong>Receipt Date:</strong> <?php echo date_setter($prescription -> date_added) ?>
</div>
<br>
<br/>
<div class="left">
    <div class="details">
        <?php $patient = get_patient($prescription -> patient_id); ?>
        <h3 style="border-bottom: 1px solid #a4a4a4; margin-top: 0"><strong>Patient Information</strong></h3>
        EMR:
        <?php echo $patient -> id ?><br>
        Name:
        <?php echo $patient -> name ?><br>
        Age:
        <?php echo $patient -> age ?><br>
        Gender:
        <?php echo ($patient -> gender == '0') ? 'Female' : 'Male' ?>
    </div>
    <?php
        $vitals = get_vitals($prescription -> patient_id);
        if(count($vitals) > 0) :
        ?>
    <div class="details">
        <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Patient Vitals</strong></h3>
        <?php
            foreach ( $vitals as $vital ) {
                echo '<strong> ' . $vital->vital_key . ' </strong>: ' . $vital->vital_value . '<br>';
            }
        ?>
    </div>
    <?php
        endif;
    ?>
    <?php if(!empty(trim($prescription -> complaints))) : ?>
    <div class="details">
        <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Complaints</strong></h3>
        <?php echo $prescription -> complaints ?>
    </div>
    <?php endif; ?>
    <?php if(!empty(trim($prescription -> diagnosis))) : ?>
    <div class="details">
        <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Investigations</strong></h3>
        <?php echo $prescription -> diagnosis ?>
    </div>
    <?php endif; ?>
</div>
<div class="right" style="margin-top: 50px">
    <h1 style="margin-top: -5px; margin-bottom: 0; margin-left: -2px"><strong>R<sub>x</sub></strong></h1>
    <div class="details">
        <?php
        if(count($medicines) > 0) {
            ?>
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 30px" cellpadding="8" border="1">
                <thead>
                <tr style="background: #f5f5f5;">
                    <td> Medicine </td>
                    <td> Dosage </td>
                    <td> Timings </td>
                    <td> Days </td>
                    <td> Instructions </td>
                </tr>
                </thead>
        <?php
            foreach ($medicines as $medicine) {
                $medicine_info = get_medicine($medicine -> medicine_id);
                if(is_numeric($medicine -> instructions) and $medicine -> instructions > 0)
                    $instruction = get_instruction_by_id($medicine -> instructions) -> instruction;
                else
                    $instruction = $medicine -> instructions;
                ?>
                <tr>
                    <td align="center"><?php echo $medicine_info -> name ?></td>
                    <td align="center"><?php echo $medicine -> dosage ?></td>
                    <td align="center"><?php echo $medicine -> timings ?></td>
                    <td align="center"><?php echo $medicine -> days ?></td>
                    <td align="center"><?php echo $instruction ?></td>
                </tr>
        <?php
            }
            ?>
            </table>
        <?php
        }
        ?>
    </div>
</div>
<div class="details">
	<?php
	if(count($tests) > 0) {
		?>
        <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Diagnosis (<small>Lab Tests</small>)</strong></h3>
        <ul>
    <?php
        foreach ($tests as $test) {
            $test_info = get_test_by_id($test -> test_id);
            ?>
            <li>
                <?php echo $test_info -> name ?>
            </li>
    <?php
        }
        ?>
        </ul>
    <?php
    }
    ?>
</div>
</body>
</html>