<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            sheet-size: 2.794in 1.5in;
        }

        body {
            font-family: sans-serif;
            font-size: 12pt;
        }

        table td {
            font-size: 12px;
        }
    </style>
</head>
<body>

<table width="100%" float="left">
    <tbody>
    <tr>
        <td width="100%" style="height: 100%">
            <strong><?php echo $report -> name ?></strong>
        </td>
    </tr>
    <tr>
        <td width="100%" style="height: 100%">
            <br />
            <strong><?php echo $report -> lab_no_prefix . '-' . $report -> lab_no ?></strong>
        </td>
    </tr>
    <tr>
        <td width="100%" style="height: 100%">
            <strong>
                <?php
                    echo calculateAge ( $report -> dob );
                    if ( !empty( trim ( $report -> gender ) ) )
                        echo '|' . ucwords ( $report -> gender )
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td width="100%" style="height: 100%">
            <strong><?php echo date_setter ( date ( 'Y-m-d H:i:s' ) ) ?></strong>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>