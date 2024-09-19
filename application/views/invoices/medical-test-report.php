<?php header ( 'Content-Type: application/pdf' ); ?>
<?php require 'vendor/autoload.php'; ?>
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

        td {
            vertical-align: top;
            border: 0;
        }

        th {
            border-left: 0;
            border-right: 0;
            border-top: 0;
        }
    </style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<?php if ( $this -> input -> get ( 'logo' ) == 'true' ) : ?>
<table width="100%"><tr>
<td width="50%" style="color:#000; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" style="height: 80px"></td>
<td width="50%" style="text-align: right;"><img src="<?php echo base_url ( '/assets/img/receipt-site-name.jpeg' ) ?>" style="height: 40px"><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?></span></td>
</tr></table>
<?php endif; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter"></htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" page="all" value="on" />
mpdf-->
<?php if ( $this -> input -> get ( 'logo' ) == 'true' ) echo '<hr style="margin-bottom: 0" />' ?>
<table width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 10px" cellpadding="0"
       border="0">
    
    <tbody>
    <tr>
        <td width="90%">
            <table width="100%">
                <tbody>
                <tr>
                    <td width="20%" align="left">
                        <strong>Lab No.:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> lab_no_prefix . '-' . $test -> lab_no ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Name:</strong>
                    </td>
                    <td width="30%" align="left">
                        <strong><?php echo $test -> name ?></strong>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Trade | Natl.:</strong>
                    </td>
                    <td width="30%" align="left">
                        <strong>
                            <?php echo $test -> trade ?>
                            <?php echo !empty( trim ( $test -> nationality ) ) ? '|' . get_country_by_id ( $test -> nationality ) -> title : '' ?>
                        </strong>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Father Name:</strong>
                    </td>
                    <td width="30%" align="left">
                        <strong><?php echo $test -> father_name ?></strong>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>CNIC | Passport:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> identity ?>
                        <?php echo !empty( trim ( $test -> passport ) ) ? '|' . $test -> passport : '' ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Marital Status:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> marital_status ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Age | Gen (DOB):</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo calculateAge ( $test -> dob ) ?>
                        <?php echo '|' . ucwords ( $test -> gender ) ?>
                        <?php echo $test -> dob ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Spec. Received:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo date_setter ( $test -> spec_received ) ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Country to Visit:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo get_country_by_id ( $test -> country_id ) -> title ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Reported On:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo date_setter ( $test -> updated_at, 5 ) ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>OEP/ Ref By:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> oep ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Printed By:</strong>
                    </td>
                    <td align="left" colspan="3">
                        <?php echo $user -> name . ' | ' . date ( 'm/d/Y H:i:s A' ) ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        
        <td width="10%" align="right">
            <?php
                $image = '';
                if ( !empty( trim ( $test -> image_data ) ) )
                    $image = $test -> image_data;
                if ( !empty( trim ( $test -> image ) ) )
                    $image = $test -> image;
                if ( !empty( trim ( $image ) ) ) :
                    ?>
                    <img src="<?php echo $image ?>" style="max-height: 100px;">
                <?php endif; ?>
        </td>
    </tr>
    </tbody>

</table>
<hr />

<table width="100%" style="font-size: 10pt; border-collapse: collapse; margin: 0; vertical-align: center !important;">
    <tbody>
    <tr>
        <td align="left">
            <?php
                $data = $test -> name . "%0A";
                $data .= $test -> mr_no . "%0A";
                $data .= $test -> lab_no;
            ?>
            <img src="https://quickchart.io/qr?text=<?php echo $data ?>&size=75" />
        </td>
        <td align="center">
            <?php echo $test -> oep_id == '5' ? '<h1 style="color: #808080">Only for JMS</h1>' : '' ?>
        </td>
        <td align="right">
            <?php
                $identifier = $test -> id . '-' . $test -> lab_no . '-' . $test -> mr_no;
                $link       = online_report_url . 'medical-test-report/?identifier=' . base64_encode ( $identifier );
            ?>
            <img src="https://quickchart.io/qr?text=<?php echo $link ?>&size=75" />
        </td>
    </tr>
    </tbody>
</table>
<hr />

<table width="100%" style="font-size: 10pt; border-collapse: collapse; margin: 0 0 10px 0">
    <tbody>
    <tr>
        <td align="center">
            <strong>Pre Medical Assessment Report</strong>
        </td>
    </tr>
    </tbody>
</table>

<?php if ( !empty( $history ) ) : ?>
    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 10px" cellpadding="0"
           cellspacing="0"
           border="1">
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <thead>
                    <tr>
                        <th align="center" colspan="2">HISTORY OF CANDIDATE</th>
                    </tr>
                    <tr>
                        <th width="60%" align="left" style="border-right: 1px solid #000000">
                            (About any Present of Pass illness)
                        </th>
                        <th width="40%" align="left">Result</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Tuberculosis</td>
                        <td><?php echo $history -> tuberculosis == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Asthma</td>
                        <td><?php echo $history -> asthma == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Typhoid Fever</td>
                        <td><?php echo $history -> typhoid_fever == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Ulcer</td>
                        <td><?php echo $history -> ulcer == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Malaria</td>
                        <td><?php echo $history -> malaria == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Surgical Procedure</td>
                        <td><?php echo $history -> surgical_procedure == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>(Psychiatric / Neurology Disorders)</td>
                        <td><?php echo $history -> psychiatric_neurology_disorders == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Allergy</td>
                        <td><?php echo $history -> allergy == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Diabetes</td>
                        <td><?php echo $history -> diabetes == '1' ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr>
                        <td>Others</td>
                        <td><?php echo $history -> others ?></td>
                    </tr>
                    </tbody>
                </table>
            </td>
            
            <td width="50%" style="border-left: 1px solid #000000">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <thead>
                    <tr>
                        <th align="center" colspan="4">GENERAL PHYSICAL EXAMINATION</th>
                    </tr>
                    <tr>
                        <th align="left" style="border-right: 1px solid #000000">Examination</th>
                        <th align="left">Result</th>
                        <th align="left" style="border-right: 1px solid #000000">Examination</th>
                        <th align="left">Result</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> height ) ) ) : ?>
                            <td>Height</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> height ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> height ) ) ) : ?>
                            <td>BP</td>
                            <td><?php echo $physical_examination -> bp ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> weight ) ) ) : ?>
                            <td>Weight</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> weight ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> pulse ) ) ) : ?>
                            <td>Pulse</td>
                            <td><?php echo $physical_examination -> pulse ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> vision ) ) ) : ?>
                            <td>Vision (Both Side)</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> vision ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> heart_beat ) ) ) : ?>
                            <td>Heart Beat</td>
                            <td><?php echo $physical_examination -> heart_beat ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> color ) ) ) : ?>
                            <td>Color Vision</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> color ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> lungs ) ) ) : ?>
                            <td>Lungs</td>
                            <td><?php echo $physical_examination -> lungs ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> hearing ) ) ) : ?>
                            <td>Hearing</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> hearing ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> abdomen ) ) ) : ?>
                            <td>Abdomen</td>
                            <td><?php echo $physical_examination -> abdomen ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> liver ) ) ) : ?>
                            <td>Liver</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> liver ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> hernia ) ) ) : ?>
                            <td>Hernia</td>
                            <td><?php echo $physical_examination -> hernia ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> skin ) ) ) : ?>
                            <td>Skin</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> skin ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> kidneys ) ) ) : ?>
                            <td>Kidneys</td>
                            <td><?php echo $physical_examination -> kidneys ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if ( !empty( trim ( $physical_examination -> hemorrhoids ) ) ) : ?>
                            <td>Hemorrhoids</td>
                            <td style="border-right: 1px solid #000000"><?php echo $physical_examination -> hemorrhoids ?></td>
                        <?php endif; ?>
                        
                        <?php if ( !empty( trim ( $physical_examination -> varicose_veins ) ) ) : ?>
                            <td>Varicose Veins</td>
                            <td><?php echo $physical_examination -> varicose_veins ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <?php if ( !empty( trim ( $physical_examination -> thyroid_gland ) ) ) : ?>
                            <td style="border-left: 1px solid #000000">Thyroid Gland</td>
                            <td><?php echo $physical_examination -> thyroid_gland ?></td>
                        <?php endif; ?>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>

<table width="100%" style="font-size: 10pt; border-collapse: collapse; margin: 10px 0">
    <tbody>
    <tr>
        <td align="center">
            <strong>Lab Investigations</strong>
        </td>
    </tr>
    </tbody>
</table>

<?php if ( !empty( $lab_investigation ) ) : ?>
    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 10px" cellpadding="0"
           cellspacing="0"
           border="1">
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <thead>
                    <tr>
                        <th align="center" colspan="2">HEMATOLOGY AND CHEMISTRY</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ( !empty( trim ( $lab_investigation -> hb ) ) ) : ?>
                        <tr>
                            <td>HB</td>
                            <td><?php echo $lab_investigation -> hb ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> ast ) ) ) : ?>
                        <tr>
                            <td>AST</td>
                            <td><?php echo $lab_investigation -> ast ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> urea ) ) ) : ?>
                        <tr>
                            <td>UREA</td>
                            <td><?php echo $lab_investigation -> urea ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> bsr ) ) ) : ?>
                        <tr>
                            <td>BSR</td>
                            <td><?php echo $lab_investigation -> bsr ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> creatinine ) ) ) : ?>
                        <tr>
                            <td>Creatinine</td>
                            <td><?php echo $lab_investigation -> creatinine ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> bilirubin ) ) ) : ?>
                        <tr>
                            <td>Bilirubin</td>
                            <td><?php echo $lab_investigation -> bilirubin ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> alt ) ) ) : ?>
                        <tr>
                            <td>ALT</td>
                            <td><?php echo $lab_investigation -> alt ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </td>
            
            <td width="50%" style="border-left: 1px solid #000000">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <thead>
                    <tr>
                        <th align="center" colspan="2">SEROLOGY AND VENEREAL DISEASES</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ( !empty( trim ( $lab_investigation -> anti_hcv ) ) ) : ?>
                        <tr>
                            <td>Anti HCV</td>
                            <td><?php echo $lab_investigation -> anti_hcv ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> hbsag ) ) ) : ?>
                        <tr>
                            <td>HbsAg</td>
                            <td><?php echo $lab_investigation -> hbsag ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> hiv ) ) ) : ?>
                        <tr>
                            <td>HIV</td>
                            <td><?php echo $lab_investigation -> hiv ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> vdrl ) ) ) : ?>
                        <tr>
                            <td>VDRL</td>
                            <td><?php echo $lab_investigation -> vdrl ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> tuberculosis ) ) ) : ?>
                        <tr>
                            <td>Tuberculosis</td>
                            <td><?php echo $lab_investigation -> tuberculosis ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> blood_group ) ) ) : ?>
                        <tr>
                            <td>Blood Group</td>
                            <td><?php echo $lab_investigation -> blood_group ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    
    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 0" cellpadding="0" cellspacing="0"
           border="1">
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <thead>
                    <tr>
                        <th align="center" colspan="2">URINE ANALYSIS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ( !empty( trim ( $lab_investigation -> ph ) ) ) : ?>
                        <tr>
                            <td>PH</td>
                            <td><?php echo $lab_investigation -> ph ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> sugar ) ) ) : ?>
                        <tr>
                            <td>Sugar</td>
                            <td><?php echo $lab_investigation -> sugar ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> albumin ) ) ) : ?>
                        <tr>
                            <td>Albumin</td>
                            <td><?php echo $lab_investigation -> albumin ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> pus_cells ) ) ) : ?>
                        <tr>
                            <td>Pus Cells</td>
                            <td><?php echo $lab_investigation -> pus_cells ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </td>
            
            <td width="50%" style="border-left: 1px solid #000000">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <thead>
                    <tr>
                        <th align="center" colspan="2">STOOL EXAMINATION</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ( !empty( trim ( $lab_investigation -> ova_cysts ) ) ) : ?>
                        <tr>
                            <td>OVA/Cysts</td>
                            <td><?php echo $lab_investigation -> ova_cysts ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> rbcs ) ) ) : ?>
                        <tr>
                            <td>RBCs</td>
                            <td><?php echo $lab_investigation -> rbcs ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    
    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 0" cellpadding="0" cellspacing="0"
           border="1">
        <thead>
        <tr>
            <th align="center" colspan="2">URINE FOR DRUGS OF ABUSE</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <tbody>
                    <?php if ( !empty( trim ( $lab_investigation -> amphetamine ) ) ) : ?>
                        <tr>
                            <td>Amphetamine (AMP)</td>
                            <td><?php echo $lab_investigation -> amphetamine ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> benzodiazepine ) ) ) : ?>
                        <tr>
                            <td>Benzodiazepine (BZO)</td>
                            <td><?php echo $lab_investigation -> benzodiazepine ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> marijuana ) ) ) : ?>
                        <tr>
                            <td>Marijuana (THC)</td>
                            <td><?php echo $lab_investigation -> marijuana ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> methamphetamine ) ) ) : ?>
                        <tr>
                            <td>Methamphetamine (MET)</td>
                            <td><?php echo $lab_investigation -> methamphetamine ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> anti_depressant ) ) ) : ?>
                        <tr>
                            <td>Anti Depressant</td>
                            <td><?php echo $lab_investigation -> anti_depressant ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </td>
            
            <td width="50%" style="border-left: 1px solid #000000">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                    <tbody>
                    <?php if ( !empty( trim ( $lab_investigation -> barbiturate ) ) ) : ?>
                        <tr>
                            <td>Barbiturate (BAR)</td>
                            <td><?php echo $lab_investigation -> barbiturate ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> cocaine ) ) ) : ?>
                        <tr>
                            <td>Cocaine (COC)</td>
                            <td><?php echo $lab_investigation -> cocaine ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> methadone ) ) ) : ?>
                        <tr>
                            <td>Methadone (MTD)</td>
                            <td><?php echo $lab_investigation -> methadone ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $lab_investigation -> phencyclidine ) ) ) : ?>
                        <tr>
                            <td>Phencyclidine (PCP)</td>
                            <td><?php echo $lab_investigation -> phencyclidine ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php if ( !empty ( $lab_investigation ) && !empty( trim ( $lab_investigation -> x_ray_chest ) ) ) : ?>
    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 0" cellpadding="0" cellspacing="0"
           border="1">
        <thead>
        <tr>
            <th align="center" colspan="2">X-RAY CHEST</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="50%">X-RAY CHEST (P/A VIEW)</td>
            <td width="50%"><?php echo $lab_investigation -> x_ray_chest ?></td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>








<?php if ( !empty( $lab_investigation_custom ) ) : ?>
    <?php
    // Initialize an array to store unique headings
    $uniqueHeadings = [];

    // Populate uniqueHeadings array from lab_investigation_custom
    foreach ($lab_investigation_custom as $custom) {
        if (!in_array($custom->header_name, $uniqueHeadings)) {
            $uniqueHeadings[] = $custom->header_name;
        }
    }
    ?>

    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 10px" cellpadding="0" cellspacing="0" border="1">
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2" border="1">
                    <thead>
                    <tr>
                        <!-- Dynamically display the first heading name here -->
                        <th align="center" colspan="2">
                            <?php echo !empty($uniqueHeadings[0]) ? $uniqueHeadings[0] : 'HEADING 1'; ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Loop through the custom data to find the first unique heading and its rows
                    foreach ($lab_investigation_custom as $custom) {
                        // Display the first unique heading and its rows
                        if ($custom->header_name == $uniqueHeadings[0] && !empty($custom->row_value)) { ?>
                            <tr>
                                <td><?php echo $custom->row_name; ?></td>
                                <td><?php echo $custom->row_value; ?></td>
                            </tr>
                        <?php }
                    }
                    ?>
                    </tbody>
                </table>
            </td>

            <td width="50%" style="border-left: 1px solid #000000">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2" border="1">
                    <thead>
                    <tr>
                        <!-- Dynamically display the second heading name here -->
                        <th align="center" colspan="2">
                            <?php echo !empty($uniqueHeadings[1]) ? $uniqueHeadings[1] : 'HEADING 2'; ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Loop again to display rows for the second unique heading
                    foreach ($lab_investigation_custom as $custom) {
                        // Display the second unique heading and its rows
                        if (!empty($uniqueHeadings[1]) && $custom->header_name == $uniqueHeadings[1] && !empty($custom->row_value)) { ?>
                            <tr>
                                <td><?php echo $custom->row_name; ?></td>
                                <td><?php echo $custom->row_value; ?></td>
                            </tr>
                        <?php }
                    }
                    ?>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>



    
    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 10px" cellpadding="0" cellspacing="0" border="1">
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2" border="1">
                    <thead>
                    <tr>
                        <!-- Dynamically display the first heading name here -->
                        <th align="center" colspan="2">
                            <?php echo !empty($uniqueHeadings[2]) ? $uniqueHeadings[2] : 'HEADING 3'; ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Loop through the custom data to find the first unique heading and its rows
                    foreach ($lab_investigation_custom as $custom) {
                        // If the heading is unique and not already stored, add it
                        if (!in_array($custom->header_name, $uniqueHeadings) && !empty($custom->row_value)) {
                            $uniqueHeadings[] = $custom->header_name;
                        }
                        // Display the first unique heading and its rows
                        if (!empty($uniqueHeadings[2]) && $custom->header_name == $uniqueHeadings[2] && !empty($custom->row_value)) { ?>
                            <tr>
                                <td><?php echo $custom->row_name; ?></td>
                                <td><?php echo $custom->row_value; ?></td>
                            </tr>
                        <?php }
                    }
                    ?>
                    </tbody>
                </table>
            </td>

            <td width="50%" style="border-left: 1px solid #000000">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2" border="1">
                    <thead>
                    <tr>
                        <!-- Dynamically display the second heading name here -->
                        <th align="center" colspan="2">
                            <?php echo !empty($uniqueHeadings[3]) ? $uniqueHeadings[3] : 'HEADING 4'; ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Loop again to display rows for the second unique heading
                    foreach ($lab_investigation_custom as $custom) {
                        // Display the second unique heading and its rows
                        if (!empty($uniqueHeadings[3]) && $custom->header_name == $uniqueHeadings[3] && !empty($custom->row_value)) { ?>
                            <tr>
                                <td><?php echo $custom->row_name; ?></td>
                                <td><?php echo $custom->row_value; ?></td>
                            </tr>
                        <?php }
                    }
                    ?>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>



    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 10px" cellpadding="0" cellspacing="0" border="1">
        <thead>
        <tr>
            <th align="center" colspan="2"> <?php echo !empty($uniqueHeadings[4]) ? $uniqueHeadings[4] : 'HEADING 5'; ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                       <tbody>
                        <?php
                        // Initialize a counter for the rows
                        $rowCount = 0;
                        foreach ($lab_investigation_custom as $custom) {
                            // Ensure the heading is unique and matches the fifth heading
                            if (!in_array($custom->header_name, $uniqueHeadings) && !empty($custom->row_value)) {
                                $uniqueHeadings[] = $custom->header_name;
                            }
                            // Check if the row belongs to the fifth heading
                            if (!empty($uniqueHeadings[4]) && $custom->header_name == $uniqueHeadings[4] && !empty($custom->row_value)) {
                                $rowCount++;
                                // Display the first 5 rows in the left column
                                if ($rowCount >= 0 && $rowCount <= 3) { ?>
                                    <tr>
                                        <td><?php echo $custom->row_name; ?></td>
                                        <td><?php echo $custom->row_value; ?></td>
                                    </tr>
                                <?php }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </td>
            
            <td width="50%" style="border-left: 1px solid #000000">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                       <tbody>
                        <?php
                        // Initialize a counter for the rows
                        $rowCount = 0;
                        foreach ($lab_investigation_custom as $custom) {
                            // Ensure the heading is unique and matches the fifth heading
                            if (!in_array($custom->header_name, $uniqueHeadings)) {
                                $uniqueHeadings[] = $custom->header_name;
                            }
                            // Check if the row belongs to the fifth heading
                            if (!empty($uniqueHeadings[4]) && $custom->header_name == $uniqueHeadings[4] && !empty($custom->row_value)) {
                                $rowCount++;
                                // Display the first 5 rows in the left column
                                if ($rowCount >= 4 && $rowCount <= 7) { ?>
                                    <tr>
                                        <td><?php echo $custom->row_name; ?></td>
                                        <td><?php echo $custom->row_value; ?></td>
                                    </tr>
                                <?php }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>



    <table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 0" cellpadding="0" cellspacing="0"
           border="1">
        <thead>
        <tr>
            <th align="center" colspan="2"> <?php echo !empty($uniqueHeadings[5]) ? $uniqueHeadings[5] : 'HEADING 6'; ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                       <tbody>
                    <?php
                    // Loop through the custom data to find the first unique heading and its rows
                    foreach ($lab_investigation_custom as $custom) {
                        // If the heading is unique and not already stored, add it
                        if (!in_array($custom->header_name, $uniqueHeadings)) {
                            $uniqueHeadings[] = $custom->header_name;
                        }
                        // Display the first unique heading and its rows
                        if (!empty($uniqueHeadings[5]) && $custom->header_name == $uniqueHeadings[5] && !empty($custom->row_value)) { ?>
                            <tr>
                            <td width="50%"><?php echo $custom->row_name; ?></td>
                            <td width="50%"><?php echo $custom->row_value; ?></td>
                            </tr>
                        <?php }
                    }
                    ?>
                    </tbody>
                </table>
            </td>
            
            <td width="50%">
                <table class="border-bottom-td" width="100%" style="border-collapse: collapse;" cellpadding="2"
                       border="1">
                
                </table>
            </td>
        </tr>
        </tbody>
    </table>



<?php endif; ?>











<table width="100%" style="font-size: 8pt; border-collapse: separate; margin-top: 15px" cellpadding="0" cellspacing="0"
       border="0">
    <tbody>
    <tr>
        <td align="center">
            The examine is medically
            <strong><u>
                    <?php
                        if ( $test -> fit === '1' )
                            echo 'Fit';
                        else if ( $test -> fit === '0' )
                            echo 'Unfit';
                        else if ( $test -> fit === '3' )
                            echo 'Defer';
                        else if ( $test -> fit === '5' )
                            echo 'Hold';
                    ?>
                </u></strong>
            for employment where it may be concerned.
        </td>
    </tr>
    <tr>
        <td align="center">
            Not valid for court. This report is acceptable only for 60 days.
        </td>
    </tr>
    <tr>
        <td align="center">
            Electronically verified report, no signature(s) required.
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>