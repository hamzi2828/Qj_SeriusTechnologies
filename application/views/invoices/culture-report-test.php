<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            header: myheader;
            footer: myfooter;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        .report {
            width: 100%;
            display: block;
            float: left;
            margin-top: 10px;
        }

        .report h3 {
            font-weight: 800 !important;
            margin-top: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000000;
        }

        .report h2 {
            font-weight: 600 !important;
            margin-top: 10px;
            padding-bottom: 0;
        }

        .report p {
            font-size: 14px;
            color: #000000;
            margin-top: 0;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<div class="report">
    <h3 style="text-align: center; margin-top: 0">
        <strong><?php echo ucwords ( @$report -> report_title ) ?></strong>
    </h3>
</div>
<?php echo @$report -> study ?>
<br />
<?php if ( count ( $antibiotics ) > 0 ) : ?>
    <h2><strong>Antibiotic (Susceptibility)</strong></h2>
    <table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="5" border="1">
        <thead>
        <tr>
            <td></td>
            <td></td>
            <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
                <th>
                    <table width="100%" border="1">
                        <thead>
                        <tr>
                            <th>Organism 1</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $report -> organism_1 ?></td>
                        </tr>
                        </tbody>
                    </table>
                </th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
                <th>
                    <table width="100%" border="1">
                        <thead>
                        <tr>
                            <th>Organism 2</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $report -> organism_2 ?></td>
                        </tr>
                        </tbody>
                    </table>
                </th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
                <th>
                    <table width="100%" border="1">
                        <thead>
                        <tr>
                            <th>Organism 3</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $report -> organism_3 ?></td>
                        </tr>
                        </tbody>
                    </table>
                </th>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Sr.No</th>
            <th>Antibiotic</th>
            <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
                <th>Result</th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
                <th>Result</th>
            <?php endif; ?>
            <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
                <th>Result</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            if ( count ( $antibiotics ) > 0 ) {
                foreach ( $antibiotics as $antibiotic ) {
                    $antibioticInfo = get_antibiotic_by_id ( $antibiotic -> antibiotic_id );
                    ?>
                    <tr>
                        <td align="center"><?php echo $counter++; ?></td>
                        <td align="center"><?php echo $antibioticInfo -> title ?></td>
                        <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
                            <td align="center"><?php echo $antibiotic -> result_1; ?></td>
                        <?php endif; ?>
                        <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
                            <td align="center"><?php echo $antibiotic -> result_2; ?></td>
                        <?php endif; ?>
                        <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
                            <td align="center"><?php echo $antibiotic -> result_3; ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
    
    <table width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="5" border="0">
        <tbody>
        <tr>
            <td>
                <strong style="color: #FF0000">S: Sensitive</strong>
            </td>
            <td>
                <strong style="color: #FF0000">IS: Intermediate Sensitive</strong>
            </td>
            <td>
                <strong style="color: #FF0000">IR: Intermediate Resistant</strong>
            </td>
            <td>
                <strong style="color: #FF0000">R: Resistant</strong>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>